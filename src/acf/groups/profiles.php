<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$profiles = new FieldsBuilder('profiles', [
    'title' => 'profiles',
    'style' => 'seamless',
    'position' => 'acf_after_title',
    'hide_on_screen' => [],
]);

$profiles
    ->setLocation('post_type', '==', 'profile');

$profiles
    ->addFields(Utility::getField('profile'));

return $profiles;
