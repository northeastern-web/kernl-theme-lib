<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$card = new FieldsBuilder('card');
$card
    ->addAccordion('Settings', ['open' => 0, 'wrapper' => ['class' => 'kernl-accordion__shade']])
        ->addLink('url', ['label' => 'Link', 'wrapper' => ['width' => 25]])
        ->addImage('image', ['label' => 'BG', 'preview_size' => 'thumbnail', 'wrapper' => ['width' => 25]])
        ->addSelect('options', [
            'label' => 'Options',
            'allow_null' => 1,
            'multiple' => 1,
            'return_format' => 'value',
            'ui' => 1,
            'ajax' => 1,
            'default_value' => '',
            'wrapper' => ['width' => 25]
        ])
            ->addChoices(array_merge(Acf::$options['card'], Acf::$utilities['backgrounds']))
        ->addText('cssClass', ['label' => 'CSS Class', 'wrapper' => ['width' => 25]])
    ->addAccordion('Content', ['open' => 1])
        ->addTrueFalse('hasTitles', ['label' => 'Enable Header & Footer', 'ui' => 1, 'wrapper' => ['width' => 30]])
        ->addText('header', ['label' => 'Header', 'wrapper' => ['width' => 70]])
            ->conditional('hasTitles', '==', '1')
        ->addText('title', ['label' => 'Title'])
        ->addFields(Utility::getField('wysiwyg'))
        ->addText('footer', ['label' => 'Footer', 'wrapper' => ['width' => 100]])
            ->conditional('hasTitles', '==', '1');

return $card;
