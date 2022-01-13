<?php

namespace App\Controller\Admin;

use App\Entity\Places;
use App\Entity\Category;
use App\Repository\PlacesRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class PlacesCrudController extends AbstractCrudController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getEntityFqcn(): string
    {
        return Places::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('name'),
            TextEditorField::new('description'),
        ];

        $current = $this->getContext()->getEntity()->getInstance(); // this one was difficult to find

        array_push(($fields),
            AssociationField::new('parentPlace')
                ->setFormTypeOptions(
                    ['query_builder' => function (PlacesRepository $placesRepository) use ($current) {
                        $qb = $placesRepository->createQueryBuilder('p');

                        if ($current->getId()) {
                            $qb
                                ->where('p.id != :id')
                                ->setParameter('id', $current->getId());
                        }
                        return $qb;
                    }]
                )
        );

        return $fields;
    }
}
