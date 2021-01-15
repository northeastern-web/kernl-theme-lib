<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$banner = new FieldsBuilder('banner', [
    'title' => 'Banner',
    'style' => 'seamless',
    'position' => 'acf_after_title',
    'menu_order' => 1,
]);

$banner
    ->setLocation('post_type', '==', 'page')
    ->or('post_type', '==', 'post')
    ->or('taxonomy', '==', 'all');

// Setup loop for Customized layout options (defaults to 'page' post_type)
if (get_field('bannerLayout', 'option')) {
    foreach (get_field('bannerLayout', 'option') as $posttype) {
        $banner->getLocation()->or('post_type', '==', $posttype);
    }
}

$banner
    ->addFields(Utility::getField('banner'));

return $banner;
