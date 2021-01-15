<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$postOptions = new FieldsBuilder('postOptions');

$postOptions
    ->setLocation('post_type', '==', 'post');

$postOptions
    ->addFields(Utility::getField('attribution'));

return $postOptions;
