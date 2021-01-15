<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$optionPages = new FieldsBuilder('optionPages', ['style' => 'seamless']);
$optionPages
    ->addFields(Utility::getField('settings'))
    ->addFields(Utility::getField('titles'));

$optionPages
    ->setLocation('options_page', '==', 'kernl-events')
    ->or('options_page', '==', 'kernl-profiles');

return $optionPages;
