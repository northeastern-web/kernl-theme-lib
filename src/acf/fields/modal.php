<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$modal = new FieldsBuilder('modal');
$modal
    ->addText('id', [
        'label' => 'ID',
        'required' => 1,
        'placeholder' => 'Unique ID used to invoke modal',
        'wrapper' => ['width' => 50,]
    ])
    ->addText('cssClass', ['label' => 'Modal Class', 'default_value' => 'bg-white', 'wrapper' => ['width' => 50,]])
    ->addFields(Utility::getField('wysiwyg'));

return $modal;
