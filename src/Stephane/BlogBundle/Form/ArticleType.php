<?php

namespace Stephane\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, array('attr' => array(
                'title' => "Le titre doit contenir au moins 10 caractères")
                ))
            ->add('contenu', 'textarea', array('attr'=>array('class'=>'ckeditor')))
            ->add('auteur', 'text')
            ->add('datecreation','date')
            ->add('publication', 'checkbox', array("required"=>false))
            ->add('categories', 'entity',
            	array("class" => "StephaneBlogBundle:Categorie",
            		"property" => "nom",
            		"multiple" => true,
            		"expanded" => true))
//            ->add('image')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Stephane\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'stephane_blogbundle_article';
    }
}
