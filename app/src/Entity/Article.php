<?php
/**
 * Article entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="articles")
 */
class Article
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $title;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Text.
     *
     * @var text
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     *
     * @Gedmo\Slug(fields={"title"})
     */
    private $code;

    /**
     * Comments.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Comment[] Comments
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Comment",
     *     mappedBy="article",
     *     cascade={"persist", "remove"}
     * )
     */
    private $comments;

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for Text.
     *
     * @return text|null Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Setter for Text.
     *
     * @param text $text Text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Getter for Category.
     *
     * @return string|null Result
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }


    /**
     * Setter for Category.
     *
     * @param Category|null $category
     *
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Getter for Code.
     *
     * @return string|null Result
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Setter for code.
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }


    /**
     * Getter for comments.
     *
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Add comment method.
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    /**
     * Remove comment method.
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }
}
