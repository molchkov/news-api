<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[Groups(['Tag:Get', 'Tag:GetCollection', 'News:Get', 'News:GetCollection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['Tag:Get', 'Tag:GetCollection', 'Tag:Post', 'Tag:Patch', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['Tag:Get', 'Tag:GetCollection', 'Tag:Post', 'Tag:Patch', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['Tag:Get', 'Tag:GetCollection', 'Tag:Post', 'Tag:Patch', 'News:Get', 'News:GetCollection'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, News>
     */
    #[ORM\ManyToMany(targetEntity: News::class, mappedBy: 'tags')]
    private Collection $news;

    public function __construct()
    {
        $this->news = new ArrayCollection();
    }

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): static
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->addTag($this);
        }

        return $this;
    }

    public function removeNews(News $news): static
    {
        if ($this->news->removeElement($news)) {
            $news->removeTag($this);
        }

        return $this;
    }
}
