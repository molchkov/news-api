<?php

namespace App\DataFixtures;

use App\Entity\File;
use App\Entity\News;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $tags = [];
        for ($k = 0; $k < 20; $k++) {
            $tag = new Tag();
            $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now'));
            $tag->setCreatedAt($createdAt);
            $tag->setTitle($faker->word);
            $tag->setSlug($faker->slug(3));
            $manager->persist($tag);
            $tags[] = $tag;
        }

        for ($i = 0; $i < 50; $i++) {
            $news = new News();
            $news->setTitle($faker->sentence(6, true));
            $news->setSlug($faker->slug(3));
            $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now'));
            $news->setCreatedAt($createdAt);
            $news->setPreviewText($faker->text(300));
            $news->setText($faker->text(500));

            for ($j = 0; $j < 2; $j++) {
                $file = new File();
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now'));
                $file->setCreatedAt($createdAt);
                $file->setMime($faker->mimeType);
                $file->setOriginalName($faker->word . '.' . $faker->fileExtension);
                $file->setName($faker->word . '.' . $faker->fileExtension);
                $file->setPath('/path/to/file'); // Замените на реальный путь к файлу
                $news->addPreviewImage($file);
                $news->addDetailImage($file);

                $manager->persist($file);
            }

            $randomTags = $faker->randomElements($tags, rand(1, 5));
            foreach ($randomTags as $randomTag) {
                $news->addTag($randomTag);
            }

            $manager->persist($news);
        }


        $manager->flush();
    }
}
