<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(){
      return [
        CategoryFixtures::class
      ];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i=0; $i < 20; $i++) {
          $article = new Article();
          $article->setName($faker->word());
          $article->setDescription($faker->paragraph(4, true));
          $article->setPrice($faker->randomFloat(2, 1, 999));
          $article->setCategory($this->getReference("CAT".mt_rand(0, 4)));
          $manager->persist($article);
          $this->addReference("ART".$i, $article);
        }

        $manager->flush();
    }
}
