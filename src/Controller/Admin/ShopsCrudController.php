<?php

namespace App\Controller\Admin;

use App\Entity\Shops;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ShopsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Shops::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('title'),
            TextEditorField::new('description'),
            ChoiceField::new('typeOfPayment')->setChoices(Shops::TYPE_PAYMENT)
        ];

        return $fields;
    }
    
}
