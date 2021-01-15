<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$settings = new FieldsBuilder('settings');
$settings
    ->addSelect('options', [
        'label' => 'Options',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'ajax' => 1,
        'default_value' => '',
        'wrapper' => ['width' => 33]
    ])
        ->addChoices(array_merge(Acf::$options['section'], Acf::$utilities['backgrounds'], Acf::$utilities['heights']))
    ->addText('cssClass', ['label' => 'CSS Class', 'wrapper' => ['width' => 33]])
    ->addFile('image', ['label' => 'BG', 'preview_size' => 'thumbnail', 'mime_types' => '.png, .jpg, .mp4', 'wrapper' => ['width' => 33]]);

return $settings;
