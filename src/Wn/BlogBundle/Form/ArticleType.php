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
            ->add('title'             , 'text')
            ->add('dateOfPublication' , 'datetime')
            ->add('category'          , 'entity', array('class' => 'WnBlogBundle:Category',
                                                        'property' => 'name',
                                                        'multiple' => false))
            ->add('synopsis'          , 'text')
            ->add('poster'            , new PosterType())
            ->add('content'           , 'textarea')
            ->add('publish'           , 'checkbox')
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
