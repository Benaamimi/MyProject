<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Blogpost;
use App\Entity\Peinture;
use App\Entity\Categorie;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        $faker->addProvider(new PicsumPhotosProvider($faker));


        // création des users 
            $user = new User;
    
            $user->setEmail("user@test.com")
                ->setPrenom($faker->firstName())
                ->setNom($faker->lastName())
                ->setTelephone($faker->phoneNumber())
                ->setAPropos($faker->text(400))
                ->setInstagram('instagram')
                ->setRoles(['ROLE_PEINTRE'])
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
                    ->setDescription(ucfirst($faker->text(150)))
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
                        ->setFile($faker->imageUrl(1000,1000, true))
                        // ->setFile('https://picsum.photos/400/400?random')
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
