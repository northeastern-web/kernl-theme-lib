<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$section = new FieldsBuilder('section');
$section
    ->addRepeater('sections', [
        'label' => 'Sections',
        'layout' => 'block',
        'min' => 1,
        'wrapper' => ['class' => 'kernl-section'],
    ])
    ->addMessage('- Section', '', ['wrapper' => ['class' => 'kernl-section__msg']])
    ->addAccordion('Section Settings', ['open' => 0, 'multi_expand' => 1, 'wrapper' => ['class' => 'kernl-accordion__shade']])
    ->addFields(Utility::getField('settings'))
    ->addAccordion('Section Titles', ['open' => 0, 'multi_expand' => 1])
    ->addFields(Utility::getField('titles'))
    ->addAccordion('Section Content', ['open' => 1, 'multi_expand' => 1])
    ->addRepeater('columns', ['label' => 'Columns', 'layout' => 'block', 'min' => 1, 'collapsed' => 'options'])
    ->addFields(Utility::getField('column'));

return $section;
