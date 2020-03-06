<?php

namespace App\Listener;

use App\Entity\Picture;
use App\Helper\FileDirectory;
use App\Service\Uploader;
use Doctrine\ORM\Mapping as ORM;

class PictureUploadListener
{
    /**
     * @var Uploader
     */
    private $uploader;

    /**
     * @var string
     */
    private $directory;

    public function __construct(Uploader $uploader, string $directory)
    {
        $this->uploader = $uploader;
        $this->directory = $directory;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersistHandler(Picture $picture)
    {
        if (!empty($picture->getFile())) {

            $extension = $this->uploader->getExtension($picture->getFile());

            if (empty($picture->getFileName())) {
                $picture->setFileName(md5(uniqid()));
            } else {
                $fileDirectory = new FileDirectory();
                $targetDir = $this->directory;
                $fileDirectory->removeFile($targetDir, $picture->getFullName());
            }

            if (empty($picture->getName())) {
                $picture->setName('Nouveau fichier');
            }

            $picture->setFileExtension($extension);
        }
        $picture->setUpdateAt(new \DateTime());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postPersistHandler(Picture $picture)
    {
        if (!empty($picture->getFile())) {

            $targetDir = $this->directory;


            $this->uploader->setTargetDir($targetDir);
            $this->uploader->upload($picture->getFile(), $picture->getFileName());
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemoveHandler(Picture $picture)
    {
        $fileDirectory = new FileDirectory();
        $targetDir = $this->directory;
        $fileDirectory->removeFile($targetDir, $picture->getFullName());
    }
}
