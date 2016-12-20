<?php

/*
 * Class representing the book form (to adding new books).
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookForm extends AbstractType {
    
    /**
     * Allows to use in the class specified in the controller additional variables.
     */
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        parent::configureOptions($resolver);
        $resolver->setRequired(array('categories'));
    }
            
    /**
     * Returns ready to use book form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', null, array(
                'label' => 'Tytuł książki',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control input-sm', 'placeholder' => 'Tytuł książki')))
            ->add('author', null, array(
                'label' => 'Autor',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control input-sm', 'placeholder' => 'Autor')))
            ->add('description', TextareaType::class, array(
                'label' => 'Opis',
                'label_attr' => array('class' => 'control-label'),
                'required' => FALSE,
                'attr' => array('class' => 'form-control input-sm', 'rows' => 2, 'placeholder' => 'Tytuł')))
            ->add('forChange', CheckboxType::class, array(
                'label' => 'Wymienię',
                'required' => FALSE))
            ->add('keyWords', null, array(
                'label' => 'Słowa kluczowe',
                'label_attr' => array('class' => 'control-label'),
                'required' => FALSE,
                'attr' => array('class' => 'form-control input-sm', 'placeholder' => 'Słowa kluczowe')))
            ->add('category', ChoiceType::class, array(
                'label' => 'Kategoria',
                'choices' => $options['categories'],
                'required' => FALSE,
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'chosen-select', 'data-placeholder' => 'Wybierz kategorię')))
            ->add('price', null, array(
                'label' => 'Cena',
                'label_attr' => array('class' => 'control-label'),
                'attr' => array('class' => 'form-control input-sm', 'placeholder' => 'Cena')))
            ->add('save', SubmitType::class, array(
                'label' => 'Wyślij',
                'attr' => array('class' => 'btn btn-lg btn-success')));
    }

}
