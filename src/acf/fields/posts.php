<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

$categories = get_categories(['fields' => 'id=>name']);
$tags = get_tags(['fields' => 'id=>name']);
$post_types = [];
foreach (get_post_types(['public' => true]) as $type) {
    if ($type !== 'attachment' && $type !== 'page') {
        $post_types[] = $type;
    }
}

$taxonomies = [];
foreach (get_taxonomies(['public' => true]) as $taxonomy) {
    $taxonomies[$taxonomy] = get_terms($taxonomy, ['fields' => 'id=>name']);
}

$posts = new FieldsBuilder('posts');
$posts
    ->addSelect('columnClass', [
        'label' => 'Columns',
        'placeholder' => 'Place view within columns',
        'allow_null' => 1,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'ajax' => 1,
        'wrapper' => ['width' => '25']
    ])
    ->addChoices(Acf::$options['column'])
    ->addSelect('view', [
        'label' => 'Apply a view',
        'placeholder' => 'Select a view to display post',
        'allow_null' => 1,
        'multiple' => 0,
        'return_format' => 'value',
        'ui' => 1,
        'ajax' => 1,
        'wrapper' => ['width' => '25']
    ])
    ->addChoices(['block.card' => 'Card', 'block.list' => 'List stack'])
    ->addText('viewClass', ['label' => 'CSS Class on view', 'wrapper' => ['width' => 25]])
    ->addText('wrapperClass', ['label' => 'CSS Class on wrapper', 'wrapper' => ['width' => 25]])
    ->addGroup('wpQuery', ['open' => 0])
    ->addNumber('posts_per_page', [
        'label' => '# of posts',
        'min' => -1,
        'default_value' => 3,
        'wrapper' => ['width' => 50]
    ])
    ->addSelect('post_type', [
        'label' => 'Post Types',
        'allow_null' => 0,
        'multiple' => 1,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => '',
        'wrapper' => ['width' => 50]
    ])
    ->addChoices($post_types)
    ->addSelect('order', [
        'label' => 'Order',
        'allow_null' => 0,
        'multiple' => 0,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => 'DESC',
        'wrapper' => ['width' => 50]
    ])
    ->addChoices(['ASC' => 'ASC', 'DESC' => 'DESC'])
    ->addSelect('orderby', [
        'label' => 'Order by',
        'allow_null' => 0,
        'multiple' => 0,
        'return_format' => 'value',
        'ui' => 1,
        'default_value' => 'date',
        'wrapper' => ['width' => 50]
    ])
    ->addChoices(['none' => 'None'], ['ID' => 'ID'], ['author' => 'Author'], ['title' => 'Title'], ['name' => 'Name'], ['type' => 'Type'], ['date' => 'Date'], ['modified' =>  'Last Modified'], ['parent' => 'Parent'], ['rand' => 'Random'], ['relevance' => 'Relevance'], ['menu_order' =>  'Menu order'])
    ->addTaxonomy('category__in', [
        'label' => 'Categories',
        'taxonomy' => 'category',
        'allow_null' => 0,
        'multiple' => 1,
        'return_format' => 'id',
        'field_type' => 'multi_select',
        'ui' => 1,
        'wrapper' => ['width' => 100]
    ])
    ->conditional('post_type', '==', 'post')
    ->addTaxonomy('tag__in', [
        'label' => 'Tags',
        'taxonomy' => 'post_tag',
        'allow_null' => 0,
        'multiple' => 1,
        'return_format' => 'id',
        'field_type' => 'multi_select',
        'ui' => 1,
        'wrapper' => ['width' => 100]
    ])
    ->addTaxonomy('ctax_profile_type', [
        'label' => 'Profile Type',
        'taxonomy' => 'profile_type',
        'allow_null' => 0,
        'multiple' => 1,
        'return_format' => 'id',
        'field_type' => 'multi_select',
        'ui' => 1,
        'wrapper' => ['width' => 100]
    ])
    ->conditional('post_type', '==', 'profile')
    ->addTaxonomy('ctax_tribe_events_cat', [
        'label' => 'Event Category',
        'taxonomy' => 'tribe_events_cat',
        'allow_null' => 0,
        'multiple' => 1,
        'return_format' => 'id',
        'field_type' => 'multi_select',
        'ui' => 1,
        'wrapper' => ['width' => 100]
    ])
    ->conditional('post_type', '==', 'tribe_events');

return $posts;
