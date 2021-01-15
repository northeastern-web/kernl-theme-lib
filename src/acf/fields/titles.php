<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$titles = new FieldsBuilder('titles');
$titles
    ->addTrueFalse('hasTitles', ['label' => 'Enable Titles', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->addText('pretitle', ['label' => 'Pre Title', 'wrapper' => ['width' => '15']])
        ->conditional('hasTitles', '==', '1')
    ->addText('title', ['label' => 'Title', 'wrapper' => ['width' => '35']])
        ->conditional('hasTitles', '==', '1')
    ->addTextarea('subtitle', ['label' => 'Sub title', 'rows' => 1, 'wrapper' => ['width' => '35']])
        ->conditional('hasTitles', '==', '1');

return $titles;
