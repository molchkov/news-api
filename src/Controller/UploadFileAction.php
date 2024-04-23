<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class UploadFileAction extends AbstractController
{
    public function __invoke(Request $request): File
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $file = new File();
        $file->file = $uploadedFile;
        $file->setName($uploadedFile->getClientOriginalName());
        $file->setOriginalName($uploadedFile->getClientOriginalName());
        $file->setMime($uploadedFile->getMimeType());

        return $file;
    }
}