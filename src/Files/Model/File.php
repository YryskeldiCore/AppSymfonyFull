<?php
declare(strict_types=1);

namespace App\Files\Model;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as LoadedFile;

/**
 * Class File
 * @package App\Files\Model
 * @ORM\Entity()
 * @ORM\Table(name="files")
 */
class File
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer", length=255)
     * @ORM\GeneratedValue()
     *
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @var integer
     * @ORM\Column(type="integer", length=100)
     */
    private $size;

    public function __construct(LoadedFile $file)
    {
        $this->filename = $file->getFilename();
        $this->hash = $file->getFilename();
        $this->size = $file->getSize();
        $this->path = $file->getPath();
    }



    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getLink(): string
    {
        return $_ENV['APP_HTTP_HOST'] . "/api/files/" . $this->getHash();
    }

    public function getDownloadLink(): string
    {
        return $_ENV['APP_HTTP_HOST'] . "/api/files/" . $this->getHash() . '/download';
    }

    /**
     * @return string
     * @
     */
    public function fullPath(): string
    {
        return $this->path() . "/" . $this->getFilename();
    }
}