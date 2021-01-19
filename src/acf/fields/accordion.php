<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$accordion = new FieldsBuilder('accordion');
$accordion
    ->addSelect('options', [
        'label' => 'Options',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => '',
    ])
        ->addChoices(Acf::$options['accordion'])
    ->addRepeater('accordion', [
        'label' => 'Items',
        'min' => 1,
        'layout' => 'block',
        'button_label' => 'Add an item',
        'collapsed' => 'title',
    ])
        ->addText('title', ['label' => 'Title', 'wrapper' => ['width' => '30']])
        ->addWysiwyg('copy', ['label' => 'Copy', 'wrapper' => ['width' => '70']]);

return $accordion;