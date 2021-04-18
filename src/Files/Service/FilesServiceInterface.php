<?php
declare(strict_types=1);

namespace App\Files\Service;


use App\Files\Model\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FilesServiceInterface
{
    /**
     * @param UploadedFile $uploadedFile
     * @return File
     */
    public function upload(UploadedFile $uploadedFile): File;

    /**
     * @param string $hash
     * @return File
     */
    public function getFile(string $hash): File;
}