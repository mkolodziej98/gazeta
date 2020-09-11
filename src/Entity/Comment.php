<?php
/**
 * Comment entity.
 */
namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * Primary key.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * Usernick.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     *     unique=true,
     * )
     *
     * @Assert\Email
     *
     */
    private $usernick;

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
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

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
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Usernick.
     *
     * @return string|null Usernick
     */
    public function getUsernick(): ?string
    {
        return $this->usernick;
    }

    /**
     * Setter for Usernick.
     *
     * @param string $usernick Usernick
     */
    public function setUsernick(string $usernick): void
    {
        $this->usernick = $usernick;
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
