<?php
/**
 * Article controller.
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\ArticleService;
use App\Service\CommentService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController.
 *
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * Article service.
     *
     * @var \App\Service\ArticleService
     */
    private $articleService;

    /**
     * Comment service.
     *
     * @var \App\Service\CommentService
     */
    private $commentService;

    /**
     * ArticleController constructor.
     *
     * @param \App\Service\ArticleService $articleService Article service
     */
    public function __construct(ArticleService $articleService, CommentService $commentService)
    {
        $this->articleService = $articleService;
        $this->commentService = $commentService;
    }

    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP request
     * @param \App\Repository\ArticleRepository         $articleRepository Article repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator         Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="article_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->articleService->createPaginatedList($page);

        return $this->render(
            'article/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Article                       $article           Article entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP request
     * @param \App\Repository\CommentRepository         $commentRepository Comment repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator         Paginator
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="article_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Article $article): Response
    {
        return $this->render(
            'article/show.html.twig',
            ['article' => $article,
                'data' => $this->commentService->getByArticle($article), ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP request
     * @param \App\Repository\ArticleRepository         $articleRepository Article repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="article_create",
     * )
     */
    public function create(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleService->save($article);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('article_index');
        }

        return $this->render(
            'article/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP request
     * @param \App\Entity\Article                       $article           Article entity
     * @param \App\Repository\ArticleRepository         $articleRepository Article repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="article_edit",
     * )
     *
     *  @IsGranted(
     *     "EDIT",
     *     subject="article",
     * )
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleService->save($article);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('article_index');
        }

        return $this->render(
            'article/edit.html.twig',
            [
                'form' => $form->createView(),
                'article' => $article,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request           HTTP request
     * @param \App\Entity\Article                       $article           Article entity
     * @param \App\Repository\ArticleRepository         $articleRepository Article repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="article_delete",
     * )
     *
     *  @IsGranted(
     *     "DELETE",
     *     subject="article",
     * )
     */
    public function delete(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleService->delete($article);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('article_index');
        }

        return $this->render(
            'article/delete.html.twig',
            [
                'form' => $form->createView(),
                'article' => $article,
            ]
        );
    }
}
