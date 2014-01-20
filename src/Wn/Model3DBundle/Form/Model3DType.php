<?php

namespace Wn\Model3DBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Model3DType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom'  , 'text')
            ->add('file' ,'file')
            ->add('textures','collection',array('type'         => new TextureType(),
                                                'allow_add'    => true,
                                                'allow_delete' => true))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wn\Model3DBundle\Entity\Model3D'
        ));
    }

    public function getName()
    {
        return 'wn_model3dbundle_model3dtype';
    }
}
