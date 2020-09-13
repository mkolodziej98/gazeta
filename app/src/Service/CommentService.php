<?php
/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Article;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CommentService.
 */
class CommentService
{
    /**
     * Comment repository.
     *
     * @var \App\Repository\CommentRepository
     */
    private $commentRepository;



    /**
     * CommentService constructor.
     *
     * @param \App\Repository\CommentRepository       $commentRepository Comment repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator         Paginator
     */
    public function __construct(CommentRepository $commentRepository, PaginatorInterface $paginator)
    {
        $this->commentRepository = $commentRepository;
    }



    /**
     * Save comment.
     *
     * @param \App\Entity\Comment $comment Comment entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    /**
     * Delete comment.
     *
     * @param \App\Entity\Comment $comment Comment entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }

    /**
     * Get comment by article.
     *
     * @param \App\Entity\Article $article Article entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getByArticle(Article $article)
    {

    return $this->commentRepository->findByArticle($article);

    }
}