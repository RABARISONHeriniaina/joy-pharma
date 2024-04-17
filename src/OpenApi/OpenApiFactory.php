<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\SecurityScheme;
use ApiPlatform\OpenApi\Model\Server;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated,
        private ParameterBagInterface   $parameterBag,
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $appUrl = $this->parameterBag->get('app.url');
        $tags = $this->gatherTags($openApi);

        $securitySchemes = $openApi->getComponents()->getSecuritySchemes() ?? [];

        $apiKeyName = 'Authorization';
        $apiKeyIn = 'header';

        $securitySchemes['JWT'] = new SecurityScheme(
            'http',
            "Value for the $apiKeyName $apiKeyIn parameter.",
            null,
            null,
            'bearer',
            'JWT'
        );

        return $openApi
            ->withSecurity([])
            ->withTags(array_map(function ($tag) {
                return ['name' => $tag, 'description' => $tag];
            }, $tags))
            ->withServers([
                new Server($appUrl, 'Server for the API'),
            ]);
    }

    private function gatherTags(OpenApi $openApi): array
    {
        $tags = [];

        /** @var array<string, PathItem> $paths */
        $paths = $openApi->getPaths()->getPaths();

        foreach ($paths as $path) {
            /* @var PathItem $path */
            foreach (['getGet', 'getPost', 'getPut', 'getPatch', 'getDelete'] as $method) {
                if (method_exists($path, $method)) {
                    $operation = $path->$method();
                    $this->handleOperation($operation, $tags);
                }
            }
        }

        return array_unique($tags);
    }

    function handleOperation(?Operation $operation, array &$tags): void
    {
        if (!$operation) {
            return;
        }

        $operationTags = $operation->getTags();
        $tags = array_unique(array_merge($tags, $operationTags));
    }
}
