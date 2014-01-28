<?php

namespace Wn\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title'  , 'text')
            ->add('note'   , 'text')
            ->add('file'   , 'file')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wn\GalleryBundle\Entity\ImageGallery'
        ));
    }

    public function getName()
    {
        return 'wn_gallerybundle_elementgallerytype';
    }
}
