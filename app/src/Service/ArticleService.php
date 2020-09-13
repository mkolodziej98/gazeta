<?php
/**
 * Article service.
 */

namespace App\Service;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ArticleService.
 */
class ArticleService
{
    /**
     * Article repository.
     *
     * @var \App\Repository\ArticleRepository
     */
    private $articleRepository;


    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;



    /**
     * ArticleService constructor.
     *
     * @param \App\Repository\ArticleRepository       $articleRepository Article repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator         Paginator
     * @param \App\Service\CategoryService            $categoryService Category service
     */
    public function __construct(ArticleRepository $articleRepository, PaginatorInterface $paginator)
    {
        $this->articleRepository = $articleRepository;
        $this->paginator = $paginator;

    }


    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->articleRepository->queryAll(),
            $page,
            ArticleRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }



    /**
     * Save article.
     *
     * @param \App\Entity\Article $article Article entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Article $article): void
    {
        $this->articleRepository->save($article);
    }

    /**
     * Delete article.
     *
     * @param \App\Entity\Article $article Article entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Article $article): void
    {
        $this->articleRepository->delete($article);
    }

    /**
     * Get article by category.
     *
     * @param \App\Entity\Category $category Category entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getByCategory(Category $category)
    {

        return $this->articleRepository->findByCategory($category);

    }


}
