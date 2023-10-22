<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Peinture;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $hasher, SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // création des users 
            $user = new User;
    
            $user->setEmail("user@test.com")
                ->setPrenom($faker->firstName())
                ->setNom($faker->lastName())
                ->setTelephone($faker->phoneNumber())
                ->setAPropos($faker->text())
                ->setInstagram('instagram')
            ;
    
            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);
    
            $manager->persist($user);
       


        // création de 10 Blogpost
        for($i = 0; $i < 10; $i++){
            $blogPost = new Blogpost;

            $blogPost->setTitre(ucfirst($faker->words(2, true)))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                    ->setContenu($faker->text(350))
                    ->setSlug(strtolower($this->slugger->slug($blogPost->getTitre())))
                    ->setUser($user)
            ;

            $manager->persist($blogPost);
        }

        // Création de 5 categories
        for($k = 0; $k < 5; $k++){
            $categorie = new Categorie;

            $categorie->setNom(ucfirst($faker->word()))
                    ->setDescription($faker->word(10, true))
                    ->setSlug(strtolower($this->slugger->slug($categorie->getNom())))
            ;

            $manager->persist($categorie);

            //création de 2 Peintures/Catégorie
            for($j = 0; $j < 2; $j++){
                $peinture = new Peinture;

                $peinture->setNom(ucfirst($faker->words(3,true)))
                        ->setLargeur($faker->randomFloat(2, 20, 60))
                        ->setHauteur($faker->randomFloat(2, 20, 60))
                        ->setEnVente($faker->randomElement([true, false]))
                        ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                        ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                        ->setDescription($faker->text())
                        ->setPortfolio($faker->randomElement([true, false]))
                        ->setSlug(strtolower($this->slugger->slug($peinture->getNom())))
                        ->setFile($faker->imageUrl(400, 400, true))
                        ->addCategorie($categorie)
                        ->setPrix($faker->randomFloat(2, 100, 9999))
                        ->setUser($user) 
                ;

                $manager->persist($peinture);
            }
        }
        


        $manager->flush();
    }
}
