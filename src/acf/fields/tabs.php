<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$tabs = new FieldsBuilder('tabs');
$tabs
    ->addSelect('options', [
        'label' => 'Options',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => '-underline',
    ])
        ->addChoices(Acf::$options['tabs'])
    ->addRepeater('lay_tabs', [
        'label' => 'Items',
        'min' => 1,
        'layout' => 'block',
        'button_label' => 'Add an item',
        'collapsed' => 'title',
    ])
        ->addText('title', ['label' => 'Title', 'wrapper' => ['width' => '30']])
        ->addWysiwyg('copy', ['label' => 'Copy', 'wrapper' => ['width' => '70']]);

return $tabs;
