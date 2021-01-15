<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$button = new FieldsBuilder('button');
$button
    ->addLink('url', ['label' => 'Link', 'wrapper' => ['width' => 25]])

    ->addTrueFalse('isModalTrigger', ['label' => 'Opens a modal?', 'ui' => 1, 'wrapper' => ['width' => 25]])

    ->addSelect('options', [
        'label' => 'Options',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => '',
        'wrapper' => ['width' => 25]
    ])
    ->addChoices(array_merge(Acf::$options['button'], Acf::$utilities['backgrounds']))

    ->addTrueFalse('hasIcon', ['label' => 'Include Icon', 'ui' => 1, 'wrapper' => ['width' => 25]])
    ->addSelect('icon', [
        'label' => 'Select an icon',
        'allow_null' => 1,
        'multiple' => 0,
        'return_format' => 'value',
        'ui' => 1,
        'ajax' => 1,
        'wrapper' => ['width' => '50']
    ])
    ->addChoices(Acf::$icons)
    ->conditional('hasIcon', '==', '1')

    ->addTrueFalse('iconPosition', ['label' => 'Place icon to right of text', 'ui' => 1, 'wrapper' => ['width' => 50]])
    ->conditional('hasIcon', '==', '1');
return $button;
