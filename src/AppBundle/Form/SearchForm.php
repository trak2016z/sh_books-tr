<?php

/*
 * Class representing the search books form.
 * All rights reserved. © 2016 inż. Konrad Niżnik.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchForm extends AbstractType {
            
    /**
     * Returns ready to use searching form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('searchField', null, array(
                'label' => 'Tytuł, autor, słowo kluczowe'))
            ->add('searchButton', SubmitType::class, array(
                'label' => 'Szukaj'));
    }

}
