<?php

namespace App\Controller\Admin;

use App\Entity\Executable;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExecutableCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Executable::class;
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
