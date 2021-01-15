<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$gallery = new FieldsBuilder('gallery');
$gallery
    ->addText('cssClass', ['label' => 'Column Class', 'default_value' => 'w-1/2 w-1/3@d'])
    ->addGallery('gallery', ['label' => 'Images'])
    ->addFields(Utility::getField('wysiwyg'));

return $gallery;
