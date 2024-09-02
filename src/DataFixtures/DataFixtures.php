<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create Categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Create Tags
        $tags = [];
        for ($i = 1; $i <= 10; $i++) {
            $tag = new Tag();
            $tag->setName('Tag ' . $i);
            $manager->persist($tag);
            $tags[] = $tag;
        }

        // Book Names
        $bookNames = [
            'The Shadow of Dawn',
            'Whispers in the Wind',
            'The Lost Chronicles',
            'Echoes of Eternity',
            'The Enchanted Forest',
            'A Journey Through Time',
            'Secrets of the Forgotten Realm',
            'The Midnight Chronicles',
            'Beneath the Crimson Sky',
            'The Alchemist\'s Code',
            'Tales of the Moonlit Sea',
            'The Hidden Kingdom',
            'The Last Guardian',
            'Voices of the Past',
            'The Secret of the Silver Oak',
        ];

        // Create Books
        foreach ($bookNames as $key => $name) {
            $book = new Book();
            $book->setName($name);
            $book->setDescription('This is a description for ' . $name);
            $book->setCategory($categories[array_rand($categories)]);

            // Assign random tags (1 to 3 tags per book)
            $randomTags = array_rand($tags, rand(1, 3));
            foreach ((array) $randomTags as $tagIndex) {
                $book->addTag($tags[$tagIndex]);
            }

            $manager->persist($book);
        }
        
        $manager->flush();
    }
}