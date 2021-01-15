<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$modules = new FieldsBuilder('modules');
$modules
    ->addPostObject('cptModules', [
        'label' => 'Select Module',
        'post_type' => 'module',
        'filters' => [],
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 1,
        'wrapper' => ['width' => 100]
    ]);

return $modules;
