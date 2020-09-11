<?php
/**
 * Article fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ArticleFixtures.
 */
class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'articles', function ($i) {
            $article = new Article();
            $article->setTitle($this->faker->sentence);
            $article->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $article->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $article->setCategory($this->getRandomReference('categories'));
            $article->setText($this->faker->sentence);
//            $article->setAuthor($this->getRandomReference('admins'));

            return $article;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}