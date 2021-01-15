<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$video = new FieldsBuilder('video');
$video
    ->addText('videoId', ['label' => 'Video ID', 'wrapper' => ['width' => 33]])
    ->addRadio('player', ['label' => 'Video Player', 'other_choice' => 1, 'wrapper' => ['width' => 33]])
    ->addChoices([
        'https://www.youtube.com/embed/' => 'YouTube',
        'https://player.vimeo.com/video/' => 'Vimeo'
    ])
    ->addText('cssClass', ['label' => 'CSS Class', 'wrapper' => ['width' => 33]]);
return $video;
