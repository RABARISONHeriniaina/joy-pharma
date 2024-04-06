<?php

namespace App\Serializer;

use App\Entity\MediaFile;
use App\Service\MediaFileService;
use ArrayObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MediaFileNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
    private const ALREADY_CALLED = '___MEDIA_FILE___';

    public function __construct(private readonly MediaFileService $mediaFileService)
    {
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof MediaFile;
    }

    /**
     * @param MediaFile $object
     * @param string|null $format
     * @param array $context
     * @return array|ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize(mixed $object, string $format = null, array $context = []): float|array|bool|ArrayObject|int|string|null
    {
        $context[self::ALREADY_CALLED] = true;

        $absolutePath = $this->mediaFileService->getAbsolutePath($object);
        $object->setPath($absolutePath);

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [MediaFile::class];
    }
}