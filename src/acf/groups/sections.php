<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$sections = new FieldsBuilder('sections', [
    'title' => 'Sections',
    'style' => 'seamless',
    'position' => 'normal',
    'hide_on_screen' => ['the_content'],
    'menu_order' => 0, // load first
]);

$sections
    ->setLocation('post_type', '==', 'page');

// Setup loop for Customized layout options (defaults to 'page' post_type)
if (get_field('sectionLayout', 'option')) {
    foreach (get_field('sectionLayout', 'option') as $posttype) {
        $sections->getLocation()->or('post_type', '==', $posttype);
    }
}

$sections
    ->addFields(Utility::getField('section'));

return $sections;
