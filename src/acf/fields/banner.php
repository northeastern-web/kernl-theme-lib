<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$banner = new FieldsBuilder('banner', ['label' => 'Banner']);
$banner
    ->addAccordion('Banner Settings', ['open' => 0, 'multi_expand' => 1, 'wrapper' => ['class' => 'kernl-accordion__shade']])
    ->addFields(Utility::getField('settings'))
    ->addAccordion('Banner Titles', ['open' => 0, 'multi_expand' => 1])
    ->addFields(Utility::getField('titles'));

return $banner;
