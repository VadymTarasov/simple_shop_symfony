<?php

namespace App\Controller\Admin;

use App\Entity\ShopItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShopItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopItem::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            IdField::new('price'),
            TextEditorField::new('description'),
        ];
    }

}
