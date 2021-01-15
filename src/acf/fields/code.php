<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$code = new FieldsBuilder('code');
$code
    ->addMessage('NOTE', '<b>Do not</b> add opening and closing tags for PHP (<code>&lt;? ... ?&gt;</code>) or JavaScript (<code><script> ... </script></code>). They are already in place.')
    ->addRadio('type', ['label' => 'Type', 'wrapper' => ['width' => 33], 'return_format' => 'value'])
    ->addChoices([
        'php' => 'PHP',
        'js' => 'Javascript'
    ])
    ->addTextarea('code', ['label' => 'Code', 'wrapper' => ['width' => 67], 'rows' => 50, 'class' => 'kernl--code']);
return $code;
