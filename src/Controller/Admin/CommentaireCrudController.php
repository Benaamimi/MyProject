<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('blogpost'),
            AssociationField::new('peinture'),
            TextField::new('auteur')->hideOnForm(),
            EmailField::new('email')->onlyOnForms(),
            DateTimeField::new('createdAt')->hideOnForm(),
            TextareaField::new('contenu'),
            BooleanField::new('isPublished'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new $entityFqcn; 
        $comment->setCreatedAt(new \DateTime());

        return $comment;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
          ->setDefaultSort(['createdAt' => 'DESC']);
    }
    
}
