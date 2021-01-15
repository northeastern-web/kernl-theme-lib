<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$profile = new FieldsBuilder('profile');
$profile
    ->addMessage('Instructions', 'Fill in contact fields below. Post title should be “Last, First” name to create an alphabetical post order')
    ->addText('fname', ['label' => 'First name', 'wrapper' => ['width' => 50]])
    ->addText('lname', ['label' => 'Last name', 'wrapper' => ['width' => 50]])
    ->addText('area', ['label' => 'Area', 'wrapper' => ['width' => 50]])
    ->addText('title', ['label' => 'Title', 'wrapper' => ['width' => 50]])
    ->addText('email', ['label' => 'Email', 'wrapper' => ['width' => 50]])
    ->addText('phone', ['label' => 'Phone', 'wrapper' => ['width' => 50]])
    ->addImage('image', ['label' => 'Headshot', 'preview_size' => 'thumbnail', 'wrapper' => ['width' => 40]]);
return $profile;
