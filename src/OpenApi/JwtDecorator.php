<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class JwtDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private readonly OpenApiFactoryInterface $decorated
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        $this->addSchemas($openApi);
        $this->addRefreshPath($openApi);
        $this->adjustLoginPath($openApi);
        $this->addLogoutPath($openApi);

        return $openApi;
    }

    private function addSchemas(OpenApi $openApi): void
    {
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Token'] = $this->createTokenSchema();
        $schemas['RefreshTokenCredentials'] = $this->createRefreshTokenCredentialsSchema();
    }

    private function createTokenSchema(): \ArrayObject
    {
        return new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                    'description' => 'JWT token to send in Authorization header.',
                ],
                'refresh_token' => [
                    'type' => 'string',
                    'description' => 'Refresh token to get new token.',
                    'readOnly' => true,
                ],
            ],
        ]);
    }

    private function createRefreshTokenCredentialsSchema(): \ArrayObject
    {
        return new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                    'description' => 'Refresh token.',
                    'example' => 'your_refresh_token',
                ],
            ],
        ]);
    }

    private function addRefreshPath(OpenApi $openApi): void
    {
        $refreshPathItem = new Model\PathItem(
            post: new Model\Operation(
                operationId: 'postRefreshTokenCredentialsItem',
                tags: ['RefreshToken'],
                responses: [
                    '200' => [
                        'description' => 'Get Refresh Token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Regenerate new token and refresh token.',
                description: 'Regenerate new token and refresh token.',
                requestBody: new Model\RequestBody(
                    description: 'Generate new Refresh Token',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/RefreshTokenCredentials',
                            ],
                        ],
                    ]),
                ),
                security: [],
            ),
        );

        $openApi->getPaths()->addPath('/api/token/refresh', $refreshPathItem);
    }

    private function adjustLoginPath(OpenApi $openApi): void
    {
        $tokenResponse = new Response(
            description: 'User token created',
            content: new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Token',
                    ],
                ],
            ])
        );

        $loginPathItem = $openApi->getPaths()->getPath('/api/login_check');
        $loginOperation = $loginPathItem?->getPost();

        if ($loginPathItem and $loginOperation) {
            $openApi->getPaths()->addPath('/api/login_check', $loginPathItem->withPost($loginOperation
                ->withDescription('Get JWT token to login.')
                ->withResponse(HttpResponse::HTTP_OK, $tokenResponse)
            ));
        }
    }

    private function addLogoutPath(OpenApi $openApi): void
    {
        $logoutPathItem = new Model\PathItem(
            post: new Model\Operation(
                operationId: 'postLogoutItem',
                tags: ['Logout'],
                responses: [
                    HttpResponse::HTTP_NO_CONTENT => [
                        'description' => 'Logged out',
                    ],
                    HttpResponse::HTTP_UNAUTHORIZED => [
                        'description' => 'Access Denied',
                    ],
                ],
                summary: 'Logout',
                description: 'Logout user. Remove refresh token from database.',
                security: [['JWT' => []]],
            ),
        );

        $openApi->getPaths()->addPath('/api/logout', $logoutPathItem);
    }
}
