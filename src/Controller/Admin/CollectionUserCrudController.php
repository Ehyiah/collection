<?php

namespace App\Controller\Admin;

use App\Entity\CollectionUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CollectionUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CollectionUser::class;
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
