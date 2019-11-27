<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


// Class qui extends AbstractType ici pour générer des formulaire
// via la commande cmd: php bin/console make:form
class BienType extends AbstractType
{
    // fonction construit le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
        ;
    }

    // Options de formulaire de manière global
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getChoices(){
        $choices = Bien::HEAT;
        $output = [];
            foreach($choices as $keys => $values){
                $output[$values] = $keys;
            }
            return $output;
    }
}
