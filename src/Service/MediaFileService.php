<?php

namespace App\Service;

use App\Entity\MediaFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MediaFileService
{
    public function __construct(private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function getAbsolutePath(MediaFile $mediaFile)
    {
        return $this->parameterBag->get('app.storage.images') . $mediaFile->getName();
    }
}