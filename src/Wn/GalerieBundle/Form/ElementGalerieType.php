<?php

namespace Wn\GalerieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ElementGalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre'  , 'text')
            ->add('note'   , 'text')
            ->add('file'   , 'file')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wn\GalerieBundle\Entity\ElementGalerie'
        ));
    }

    public function getName()
    {
        return 'wn_galeriebundle_elementgalerietype';
    }
}
