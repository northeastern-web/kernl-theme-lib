<?php

namespace Kernl\Lib;

use function Roots\wp_die;

class PostTypes
{
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        add_action('acf/init', function () {
            $this->modules();
            $this->profiles();
        });
    }

    /**
     * Register modules cpt
     * @return void
     */
    protected function modules()
    {
        register_post_type('module', [
            'labels'                => [
                'name'                => __('Modules'),
                'singular_name'       => __('Module'),
                'add_new'             => __('Add Module'),
                'add_new_item'        => __('Add New Module'),
                'edit_item'           => __('Edit Module'),
            ],
            'public'                => false,
            'has_archive'           => 'modules',
            'rewrite'               => ['slug' => 'module'],
            'supports'              => ['title'],
            'taxonomies'            => [],
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 30,
            'menu_icon'             => 'dashicons-tagcloud',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'post'
        ]);
    }

    /**
     * Register profiles cpt and profile_type custom tax
     * @return void
     */
    protected function profiles()
    {
        register_post_type('profile', [
            'labels'                => [
                'name'                => __('Profiles'),
                'singular_name'       => __('Profile'),
                'add_new'             => __('Add Profile'),
                'add_new_item'        => __('Add New Profile'),
                'edit_item'           => __('Edit Profile'),
            ],
            'public'                => true,
            'has_archive'           => false,
            'rewrite'               => ['slug' => 'profile'],
            'supports'              => ['title', 'editor'],
            'taxonomies'            => ['post_tag'],
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-id-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true
        ]);

        // Custom Taxonomy
        register_taxonomy('profile_type', ['profile'], [
            'show_ui'         => true,
            'query_var'       => true,
            'public'          => true,
            'has_archive'     => true,
            'hierarchical'    => true,
            'show_in_rest'    => true,
            'rest_base'       => 'profile_type',
            'rewrite'         => [
                'slug'          => 'profile_type',
                'with_front'    => true,
                'heirarchical'  => true
            ],
            'labels' => [
                'name'                       => _x('Profile Types', 'taxonomy general name'),
                'singular_name'              => _x('Profile Type', 'taxonomy singular name'),
                'search_items'               => __('Search Types'),
                'popular_items'              => __('Popular Types'),
                'all_items'                  => __('All Types'),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __('Edit Type'),
                'update_item'                => __('Update Type'),
                'add_new_item'               => __('Add New Type'),
                'new_item_name'              => __('New Type'),
                'separate_items_with_commas' => __('Separate gallery tags with commas'),
                'add_or_remove_items'        => __('Add or remove gallery tags'),
                'choose_from_most_used'      => __('Choose from the most used gallery tags'),
                'menu_name'                  => __('Profile Types'),
            ]
        ]);
    }
}
