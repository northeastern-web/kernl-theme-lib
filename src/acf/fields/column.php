<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$column = new FieldsBuilder('column');
$column
    ->addSelect('options', [
        'label' => 'Column Options',
        'placeholder' => 'Select column size and position',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'ajax' => 1,
        'wrapper' => ['width' => '66']
    ])
    ->addChoices(Acf::$options['column'])
    ->addText('cssClass', ['label' => 'CSS Class', 'wrapper' => ['width' => 33]])
    ->addFlexibleContent('blocks', [
        'label' => 'Content blocks',
        'button_label' => 'Add Block',
        'max' => 5,
        'wrapper' => ['class' => ''],
    ])
    ->addLayout(Utility::getField('wysiwyg'))
    ->addLayout(Utility::getField('card'))
    ->addLayout(Utility::getField('accordion'))
    ->addLayout(Utility::getField('button'))
    ->addLayout(Utility::getField('carousel'))
    ->addLayout(Utility::getField('gallery'))
    ->addLayout(Utility::getField('tabs'))
    ->addLayout(Utility::getField('posts'))
    ->addLayout(Utility::getField('modal'))
    ->addLayout(Utility::getField('video'))
    ->addLayout(Utility::getField('wufoo'))
    ->addLayout(Utility::getField('modules'))
    ->addLayout(Utility::getField('code'));

return $column;
