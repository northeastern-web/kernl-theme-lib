<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$carousel = new FieldsBuilder('carousel');
$carousel
    ->addSelect('options', ['label' => 'Options', 'multiple' => true, 'ui' => true])
    ->addChoice('"autoAdvance":"true"', 'Auto advance')
    ->addChoice('"infinite":"true"', 'Infinite loop')
    ->addChoice('"controls":"true"', 'Add controls')
    ->addChoice('"autoHeight":"true"', 'Adjust to visible item heights')
    ->addChoice('"matchHeight":"true"', 'Match item heights')
    ->addChoice('"pagination":"false"', 'Remove pagination')
    ->addRepeater('carousel', [
        'label' => 'Carousel items',
        'min' => 2,
        'button_label' => 'Add carousel',
        'layout' => 'block',
    ])
    ->addText('cssClass', ['label' => 'Class'])
    ->addFields(Utility::getField('wysiwyg'));
return $carousel;
