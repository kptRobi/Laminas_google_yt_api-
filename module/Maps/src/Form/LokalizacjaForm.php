<?php

namespace Maps\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;
use Maps\Model\Lokalizacje;

class LokalizacjaForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->setAttributes(['method' => 'post', 'class' => 'form']);
        $this->add([
            'name' => 'adres',
            'type' => 'Text',
            'options' => [
                'label' => 'Adres',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'opis',
            'type' => 'Text',
            'options' => [
                'label' => 'Opis',
            ],
            'attributes' => ['class' => 'form-control'],
        ]);
        $this->add([
            'name' => 'dodaj',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Dodaj',
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return[
            [
                'name' => 'adres',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [],
                ],
                [
                    'name' => 'opis',
                    'required' => true,
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [],
                ],

        ];
    }
}