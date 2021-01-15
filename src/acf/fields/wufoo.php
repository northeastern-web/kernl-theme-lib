<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$wufoo = new FieldsBuilder('wufoo');
$wufoo
    ->addText('id', ['label' => 'Wufoo Form ID', 'wrapper' => ['width' => 25]])
    ->addText('u', ['label' => 'Wufoo Username', 'wrapper' => ['width' => 25], 'default_value' => 'provostweb',])
    ->addSelect('header', ['label' => 'Header', 'wrapper' => ['width' => 25], 'default_value' => 'hide'])
    ->addChoices([
        'show' => 'Show',
        'hide' => 'Hide'
    ])
    ->addText('defaults', ['label' => 'Default Values', 'wrapper' => ['width' => 25], 'placeholder' => 'Field108=XYZ&Field110=ABCD']);
return $wufoo;
