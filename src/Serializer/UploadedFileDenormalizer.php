<?php

namespace App\Serializer;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): UploadedFile
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     * @param mixed $data
     * @param string $type
     * @param null $format
     * @param array $context
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $data instanceof UploadedFile;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [UploadedFile::class];
    }
}