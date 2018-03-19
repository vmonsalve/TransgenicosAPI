<?php

namespace Tiempo\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProductosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class, array(
                'label' => 'Nombre',
                'attr'  => array('class' => 'form-control')
        ))
        ->add('categorias', EntityType::class, array(
              'class' => 'TiempoAdminBundle:Categorias',
              'choice_label' => 'nombre',
              'attr' => array('class' => 'form-control'),
              'label' => 'Categorias',
              'required' => true,
        ))
        ->add('marcas', EntityType::class, array(
              'class' => 'TiempoAdminBundle:Marcas',
              'choice_label' => 'nombre',
              'attr' => array('class' => 'form-control'),
              'label' => 'Marcas',
              'required' => true,
        ))
        ->add('estados', EntityType::class, array(
                'class' => 'TiempoAdminBundle:Estados',
                'choice_label' => 'estado',
                'attr' => array('class' => 'form-control'),
                'label' => 'Transgénico?',
                'required' => true,              
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tiempo\AdminBundle\Entity\Productos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tiempo_adminbundle_productos';
    }


}
