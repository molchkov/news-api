<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[Groups(['News:Get', 'News:GetCollection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups(['News:Get', 'News:GetCollection'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\Column(length: 300)]
    private ?string $previewText = null;

    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    /**
     * @var Collection<int, File>
     */
    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'news')]
    private Collection $previewImage;

    /**
     * @var Collection<int, File>
     */
    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'news')]
    private Collection $detailImage;

    /**
     * @var Collection<int, Tag>
     */
    #[Groups(['News:Get', 'News:GetCollection', 'News:Post', 'News:Patch'])]
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'news')]
    private Collection $tags;

    public function __construct()
    {
        $this->previewImage = new ArrayCollection();
        $this->detailImage = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getPreviewText(): ?string
    {
        return $this->previewText;
    }

    public function setPreviewText(string $previewText): static
    {
        $this->previewText = $previewText;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getPreviewImage(): Collection
    {
        return $this->previewImage;
    }

    public function addPreviewImage(File $previewImage): static
    {
        if (!$this->previewImage->contains($previewImage)) {
            $this->previewImage->add($previewImage);
            $previewImage->setNews($this);
        }

        return $this;
    }

    public function removePreviewImage(File $previewImage): static
    {
        if ($this->previewImage->removeElement($previewImage)) {
            // set the owning side to null (unless already changed)
            if ($previewImage->getNews() === $this) {
                $previewImage->setNews(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getDetailImage(): Collection
    {
        return $this->detailImage;
    }

    public function addDetailImage(File $detailImage): static
    {
        if (!$this->detailImage->contains($detailImage)) {
            $this->detailImage->add($detailImage);
            $detailImage->setNews($this);
        }

        return $this;
    }

    public function removeDetailImage(File $detailImage): static
    {
        if ($this->detailImage->removeElement($detailImage)) {
            // set the owning side to null (unless already changed)
            if ($detailImage->getNews() === $this) {
                $detailImage->setNews(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
