<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$post_types = [];
foreach (get_post_types(['public' => true]) as $type) {
    if ($type !== 'attachment') {
        $post_types[] = $type;
    }
}

$generic = new FieldsBuilder('generic');
$generic->addTab('Generic')
    ->addMessage('Logos', '')
    ->addImage('logo', ['label' => 'Logo', 'preview_size' => 'medium', 'wrapper' => ['width' => '50'], 'return_format' => 'url'])
    ->addImage('logoWhite', ['label' => 'Logo (white)', 'preview_size' => 'medium', 'wrapper' => ['width' => '50'], 'return_format' => 'url'])
    ->addMessage('Google Analytics', 'applied in Production only')
    ->addText('gaTracker', ['label' => 'GA Tracker'])
    ->addMessage('Global Styles', '')
    ->addTrueFalse('hasNUHeader', ['label' => 'Add brand header', 'wrapper' => ['width' => '25'], 'ui' => 1])
    ->addSelect('masthead', [
        'label' => 'Masthead Options',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'wrapper' => ['width' => '100']
    ])
    ->addChoices(Acf::$options['masthead'])
    ->addMessage('Add banner and section layout to the following post types', '')
    ->addSelect('bannerLayout', [
        'label' => 'Post Types including Banner layout',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => 'page'
    ])
    ->addChoices($post_types)
    ->addSelect('sectionLayout', [
        'label' => 'Post Types including Section layout',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => 'page'
    ])
    ->addChoices($post_types)
    ->addMessage('Global Items', 'Add items within &lt;head&gt; and before &lt;/body&gt;')
    ->addTextarea('globalStyle', ['label' => 'Add global styles', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code'])
    ->addTextarea('globalHead', ['label' => 'Add Global items to head', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code'])
    ->addTextarea('globalFooter', ['label' => 'Add Global items to footer', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code']);

$extend = new FieldsBuilder('extend');
$extend->addTab('Extensions')
    ->addTrueFalse('hasProfiles', ['label' => 'Enable Profiles', 'ui' => 1])
    ->addTrueFalse('hasArticles', ['label' => 'Enable Articles (knowledgebase)', 'ui' => 1])
    ->addTrueFalse('hasModules', ['label' => 'Enable Modules', 'ui' => 1]);

// $profiles = new FieldsBuilder('profiles');
// $profiles->addTab('Profiles')
//     ->addMessage('Configure profiles', 'Once the Tribe Events plugin has been activated, the following custom fields can further enhance your calendar.')
//     ->addText('profilePretitle', ['label' => 'Banner Pretitle'])
//     ->addText('profileTitle', ['label' => 'Banner Title'])
//     ->addTextarea('profileSubtitle', ['label' => 'Banner Subtitle', 'wrapper' => ['width' => '100'], 'rows' => 3]);

// $events = new FieldsBuilder('events');
// $events->addTab('Events')
//     ->addMessage('Configure Tribe Events Calendar', 'Once the Tribe Events plugin has been activated, the following custom fields can further enhance your calendar.')
//     ->addText('eventsPretitle', ['label' => 'Banner Pretitle'])
//     ->addText('eventsTitle', ['label' => 'Banner Title'])
//     ->addTextarea('eventsSubtitle', ['label' => 'Banner Subtitle', 'wrapper' => ['width' => '100'], 'rows' => 3]);

$pageNotFound = new FieldsBuilder('pageNotFound');
$pageNotFound->addTab('404 Page')
    ->addWysiwyg('404', ['label' => 'Copy']);


// Build the general options page
$general = new FieldsBuilder('general', ['title' => 'general', 'style' => 'seamless']);
$general
    ->addFields($generic)
    ->addFields($pageNotFound)
    ->addFields($extend)
    ->setLocation('options_page', '==', 'kernl');

// ->addFields($events)
// ->addFields($profiles)
return $general;
