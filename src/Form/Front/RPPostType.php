<?php

namespace App\Form\Front;

use App\Entity\PlayedCharacter;
use App\Entity\RPPost;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RPPostType extends AbstractType
{
    /**
     * @var $user Account
     */
    private $user;

    public function __construct(TokenStorageInterface $ts) {
        $this->user = $ts->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->user;
        $builder
            ->add('poster', EntityType::class, [
                'class' => PlayedCharacter::class,
                'query_builder' => function(EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('pc')
                        ->where('pc.account = :user')
                        ->setParameter('user', $user);
                }
            ])
            ->add('content')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RPPost::class,
        ]);
    }
}
