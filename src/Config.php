<?php

namespace Kernl\Lib;

class Config
{
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->bootstrap();
        $this->globalActions();
        $this->globalFilters();
    }

    /**
     * Bootstrap Kernl ;)
     * @return void
     */
    protected function bootstrap()
    {
        // Instantiate various functionality
        new AcfDocumentation;
        new AcfLayout;
        new AcfPostMeta;
        new AcfCustomize;
        new Articles;
        new Profiles;
        new Navigation;
        new Modules;
        new ShortcodeAuth;
        new ShortcodeComponent;
        new ShortcodeIcon;
        new ShortcodeInclude;
        new ShortcodeMailchimp;
        new ShortcodeModule;
        new ShortcodePosts;
        new ShortcodeVideo;
        new ShortcodeWufoo;
    }

    /**
     * Global WP actions
     * @return void
     */
    protected function globalActions()
    {
        // after_switch_theme (Runs once upon theme activation)
        add_action('after_switch_theme', function () {
            // Grant Editor roles access to menus
            $editor_role = get_role('editor');
            $editor_role->add_cap('edit_theme_options');

            // Remove annoying default Tagline
            update_option('blogdescription', '');

            // Change default permalink
            update_option('permalink_structure', '/%postname%/');

            // Set timezone
            update_option('timezone_string', 'America/New_York');

            // Set first day of week
            update_option('start_of_week', '0');
        });

        // after_setup_theme (Runs when funtions.php is loaded)
        add_action('after_setup_theme', function () {
            // Enable features from Soil when plugin
            add_theme_support('soil-clean-up');
            add_theme_support('soil-jquery-cdn');
            add_theme_support('soil-nav-walker');
            add_theme_support('soil-nice-search');
            add_theme_support('soil-relative-urls');

            // Enable plugins to manage the document title
            add_theme_support('title-tag');

            // Add supported post formats
            // add_theme_support('post-formats', ['gallery', 'video']);

            // Register navigation menus
            register_nav_menus([
                'primary_navigation' => __('Primary Navigation', 'sage'),
                'utility_navigation' => __('Utility Navigation', 'sage'),
            ]);

            // Enable HTML5 markup support
            add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

            // Enable post thumbnails
            add_theme_support('post-thumbnails');

            // Enable selective refresh for widgets in customizer
            add_theme_support('customize-selective-refresh-widgets');
        }, 20);

        // admin_menu (Runs after default admin menu created)
        add_action('admin_menu', function () {
            // Add ACF Options menus
            acf_add_options_page([
                'page_title'  => 'kernl(theme) Documentation',
                'menu_title'  => 'Documentation',
                'capability'  => 'edit_posts',
                'position'    => '2.1',
                'icon_url'    => 'dashicons-carrot',
            ]);
            acf_add_options_page([
                'page_title'  => 'Theme Customizations',
                'menu_title'  => 'Customize',
                'capability'  => 'edit_posts',
                'position'    => '2.1',
                'icon_url'    => 'dashicons-clipboard',
            ]);
            acf_add_options_page([
                'page_title'  => 'Homepage',
                'menu_title'  => 'Homepage',
                'capability'  => 'edit_posts',
                'position'    => '2.2',
                'icon_url'    => 'dashicons-admin-home'
            ]);
        });

        // admin_enqueue_scripts
        add_action('admin_enqueue_scripts', function () {
            // Add custom stylesheet to wp-admin
            wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/../vendor/northeastern-web/kernl-lib-wp/src/assets/styles/wp-admin.css');
        });

        // wp_dashboard_setup
        add_action('wp_dashboard_setup', function () {
            // Remove useless meta boxes
            remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
            remove_meta_box('dashboard_primary', 'dashboard', 'side');
            remove_meta_box('tribe_dashboard_widget', 'dashboard', 'normal');
        });

        //////////////////////
        // Template Actions //
        //////////////////////

        // wp_head items with priority 1
        add_action('wp_head', function () {
            // Add tag manager Script
            // if (\WP_ENV == 'production') {
                echo \Northeastern\Support\Analytics::googleTagManagerScript();
            // }

            // echo meta head assets
            echo \Northeastern\Support\Meta::head();

            // echo global elements assets
            echo '
                <link rel="stylesheet" href="https://global-packages.cdn.northeastern.edu/global-elements/dist/css/index.css">
                <script src="https://global-packages.cdn.northeastern.edu/global-elements/dist/js/index.umd.js" defer></script>
                <script src="https://global-packages.cdn.northeastern.edu/kernl-ui/dist/js/index.umd.js" defer></script>
                <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900" rel="stylesheet">
            ';
        }, 1);

        // wp_head with priority 20
        add_action('wp_head', function () {
            // Add items globally to <head> from Customize
            if (get_field('txt_head', 'option')) {
                echo get_field('txt_head', 'option');
            }

            // Add styles globally within <head> from Customize
            if (get_field('txt_css', 'option')) {
                echo '
                    <style>
                        '. get_field('txt_css', 'option') .'
                    </style>
                ';
            }
        }, 20);

        // wp_body_open
        add_action('wp_body_open', function () {
            // Add tag manager NoScript
            // if (\WP_ENV == 'production') {
                echo \Northeastern\Support\Analytics::googleTagManagerNoScript();
            // }

            // Add skip to main content
            echo '
                <div x-data="NUGlobalElements.header({ skipToMainSelector: \'#main\' })" x-init="init()" style="height: 48px; background-color: black"></div>
            ';
        });

        // wp_footer
        add_action('wp_footer', function () {
            // Add items globally to footer area from Customize
            if (get_field('txt_footer', 'option')) {
                echo get_field('txt_footer', 'option');
            }

            // Add chrome script
            echo '<div x-data="NUGlobalElements.footer()" x-init="init()"></div>';

            // Add google analytics tracker
            // if (\WP_ENV == 'production' && get_field('txt_analytics', 'option')) {
            // if (get_field('txt_analytics', 'option')) {
                   // echo NU::googleAnalytics(get_field('txt_analytics', 'option'));
            // }
        });
    }

    /**
     * Global WP filters
     * @return void
     */
    protected function globalFilters()
    {
        // upload_mimes (allow SVG mimes)
        add_filter('upload_mimes', function ($mimes) {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        });

        // admin_footer_text (Add theme & version to wp-admin)
        add_filter('admin_footer_text', function ($text) {
            return 'Theme: '. wp_get_theme()->get('Name') .' '. wp_get_theme()->get('Version');
        }, 1, 2);

        // show_admin_bar (Remove on admin bar on front-end)
        add_filter('show_admin_bar', '__return_false');

        // admin_bar_menu (Replacing "Howdy")
        add_filter('admin_bar_menu', function ($wp_admin_bar) {
            $my_account=$wp_admin_bar->get_node('my-account');
            $title = str_replace('Howdy,', 'User: ', $my_account->title);
            $wp_admin_bar->add_node([
                'id' => 'my-account',
                'title' => $title,
            ]);
        }, 25);

        // SEO framwork plugin (Misc settings)
        add_filter('the_seo_framework_metabox_priority', function () {
            return 'low';
        });
        add_filter('the_seo_framework_indicator', '__return_false');
        add_filter('the_seo_framework_seo_bar_pill', '__return_true');
        add_filter('the_seo_framework_show_seo_column', '__return_false');

        // nav_menu_css_class (Menu highlighting for Tribe Calendar)
        add_filter('nav_menu_css_class', function ($classes = [], $menu_item = false) {
            // Check if the current queried page is an event, or the events archive, and whether the current item in the filter is '/events/'
            if ((is_singular('tribe_events') || is_post_type_archive('tribe_events')) && $menu_item->url == '/events/') {
                $classes[] = 'current-page-ancestor';
            }

            // The filter also wants to highlight the "Posts" archive. Stop it from doing that.
            if ((is_singular('tribe_events') || is_post_type_archive('tribe_events')) && $menu_item->url == get_post_type_archive_link('post')) {
                if (($key = array_search('current_page_parent', $classes)) !== false) {
                    unset($classes[$key]);
                }
            }

            // Return the correct classes for this menu item.
            return $classes;
        }, 10, 2);

        // Add `unfiltered_html` capability to editors
        add_filter('map_meta_cap', function ($caps, $cap, $user_id) {
            if ('unfiltered_html' === $cap && user_can($user_id, 'editor')) {
                $caps = ['unfiltered_html'];
            }
            return $caps;
        }, 1, 3);

        // Remove protection on excerpt
        add_action('init', function () {
            remove_filter('get_the_excerpt', 'members_content_permissions_protect', 95);
            remove_filter('the_excerpt', 'members_content_permissions_protect', 95);
            add_filter('members_please_log_in', function () {
                return;
            }, 100);
        }, 100);

        // Set Sage-friendly The Events Calendar template
        if (class_exists('Tribe__Settings_Manager')) {
            // Set the The Events Calendar default template to our Sage-friendly template.
            \Tribe__Settings_Manager::set_option('tribeEventsTemplate', 'views/events.blade.php');
        }
    }
}
