<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$wysiwyg = new FieldsBuilder('wysiwyg');
$wysiwyg
    ->addWysiwyg('wysiwyg', ['label' => '']);

return $wysiwyg;
