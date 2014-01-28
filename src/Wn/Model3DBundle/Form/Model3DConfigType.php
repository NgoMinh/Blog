<?php

namespace Wn\Model3DBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Model3DConfigType extends Model3DType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('name')
            ->remove('file')
            ->remove('textures')
            ->add('camDistanceMin' , 'text')
            ->add('camDistanceMax' , 'text')
        ;
    }

    public function getName()
    {
        return 'wn_model3dbundle_model3dconfigtype';
    }
}
