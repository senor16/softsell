<?php

namespace App\Controller\Admin;

use App\Entity\Developer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DeveloperCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Developer::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
