<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$attribution = new FieldsBuilder('attribution', ['label' => 'Post Options']);
$attribution
    ->addTrueFalse('hasDate', ['label' => 'Display post date', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->addTrueFalse('hasAttribution', ['label' => 'Display post attribution', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->addTrueFalse('hasAuthorOverride', ['label' => 'Override author info', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->conditional('hasAttribution', '==', '1')
    ->addTrueFalse('hasExternalLink', ['label' => 'Add attribution link', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->conditional('hasAttribution', '==', '1')
    ->addTrueFalse('hasFullAuthor', ['label' => 'Display full author details', 'ui' => 1, 'wrapper' => ['width' => 15]])
    ->conditional('hasAttribution', '==', '1')
    ->addText('postAuthor', ['label' => 'Post Author', 'wrapper' => ['width' => 50, 'placeholder' => 'eg. Joseph Aoun']])
    ->conditional('hasAuthorOverride', '==', '1')
    ->addText('postSource', ['label' => 'Post Source', 'wrapper' => ['width' => 50, 'placeholder' => 'eg. News@Northeastern or Washington Post']])
    ->conditional('hasAuthorOverride', '==', '1')
    ->addLink('url', ['label' => 'Attribution Link', 'wrapper' => ['width' => 100]])
    ->conditional('hasExternalLink', '==', '1');

return $attribution;
