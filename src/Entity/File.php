<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as ComponentFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[Groups(['File:Get', 'File:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['File:Get', 'File:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['File:Get', 'File:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $mime = null;

    #[Groups(['File:Get', 'File:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[Groups(['File:Get', 'File:GetCollection', 'File:Post', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['File:Get', 'File:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[Vich\UploadableField(mapping: 'media_object', fileNameProperty: 'path')]
    public ?ComponentFile $file = null;

    #[ORM\ManyToOne(inversedBy: 'previewImage')]
    private ?News $news = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(string $mime): static
    {
        $this->mime = $mime;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): static
    {
        $this->news = $news;

        return $this;
    }
}
