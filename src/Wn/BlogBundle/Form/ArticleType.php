<?php

namespace Wn\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre'           , 'text')
            ->add('datePublication' , 'datetime')
            ->add('categorie'       , 'entity', array('class' => 'WnBlogBundle:Categorie',
                                                      'property' => 'nom',
                                                      'multiple' => false))
            ->add('synopsis'        , 'text')
            ->add('imageAffiche'    , new ImageAfficheType())
            ->add('contenu'         , 'textarea')
            ->add('publie'          , 'checkbox')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wn\BlogBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'wn_blogbundle_articletype';
    }
}
