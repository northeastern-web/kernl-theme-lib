<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$modules = new FieldsBuilder('modules', [
    'title' => 'modules',
    'style' => 'seamless',
    'position' => 'acf_after_title',
    'hide_on_screen' => [],
]);

$modules
    ->setLocation('post_type', '==', 'module');

$modules
    ->addFlexibleContent('module', [
        'label' => 'Modules',
        'button_label' => 'Add module',
        'wrapper' => ['class' => ''],
    ])
    ->addLayout(Utility::getField('wysiwyg'))
    ->addLayout(Utility::getField('card'))
    ->addLayout(Utility::getField('accordion'))
    ->addLayout(Utility::getField('carousel'))
    ->addLayout(Utility::getField('gallery'))
    ->addLayout(Utility::getField('tabs'))
    ->addLayout(Utility::getField('modal'))
    ->addLayout(Utility::getField('video'))
    ->addLayout(Utility::getField('wufoo'))
    ->addLayout(Utility::getField('posts'))
    ->addLayout(Utility::getField('code'));

return $modules;
