<?php

namespace App\Controller\Admin;

use App\Entity\Peinture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PeintureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Peinture::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextareaField::new('description')->hideOnIndex(),
            DateField::new('dateRealisation', 'Date de réalisation')->hideOnForm()->setFormat('dd.MM.yyyy'),
            NumberField::new('largeur')->hideOnIndex(),
            NumberField::new('hauteur')->hideOnIndex(),
            NumberField::new('prix')->hideOnIndex(),
            BooleanField::new('enVente'),
            BooleanField::new('portfolio'),
            // TextField::new('file')->onlyWhenCreating(),
            // ImageField::new('file')->setBasePath('/uploads/peintures/')->onlyOnIndex(),
            ImageField::new('file')->setUploadDir('public/uploads/peintures')->setUploadedFileNamePattern('[timestamp]-[slug]-[extension]')->onlyWhenCreating(),
            ImageField::new('file')->setUploadDir('public/uploads/peintures')->setUploadedFileNamePattern('[timestamp]-[slug]-[extension]')->setFormTypeOptions(['required' => false])->onlyWhenUpdating(),

            //affichage
            ImageField::new('file')->setBasePath('uploads/peintures')->hideOnForm(),

            SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
            AssociationField::new('categorie'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $peinture = new $entityFqcn; 
        $peinture
        // ->setDateRealisation(new \DateTime())
                ->setCreatedAt(new \DateTime());


        return $peinture;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }
}
