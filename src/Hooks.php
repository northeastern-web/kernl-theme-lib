<?php

namespace Kernl\Lib;

use function Roots\wp_die;

class Hooks
{
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->actions();
        $this->filters();
    }

    /**
     * WP actions
     * @return void
     */
    protected function actions()
    {
        // after_switch_theme (Runs once upon theme activation)
        add_action('after_switch_theme', function () {
            // Grant Editor roles access to menus
            $editor_role = get_role('editor');
            $editor_role->add_cap('edit_theme_options');
            $editor_role->add_cap('unfiltered_html');
            $editor_role->add_cap('srm_manage_redirects');

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
            // add_theme_support('soil-nav-walker');
            add_theme_support('soil-nice-search');
            add_theme_support('soil-relative-urls');

            // Enable plugins to manage the document title
            add_theme_support('title-tag');

            // Register navigation menus
            register_nav_menus([
                'navCentral'    => __('Central', 'kernl'),
                'navSupport'    => __('Support', 'kernl'),
                'navBar'        => __('Navbar', 'kernl'),
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
            if (function_exists('acf_add_options_page')) {
                acf_add_options_page(array(
                    'page_title'    => 'kernl(theme) General Settings',
                    'menu_title'    => 'kernl(theme)',
                    'menu_slug'     => 'kernl',
                    'capability'    => 'edit_posts',
                    'redirect'      => false,
                    'position'      => '2.1',
                ));

                acf_add_options_sub_page(array(
                    'page_title'    => 'Events Settings',
                    'menu_title'    => 'Events',
                    'menu_slug'     => 'kernl-events',
                    'post_id'       => 'events',
                    'parent_slug'   => 'kernl',
                ));
                acf_add_options_sub_page(array(
                    'page_title'    => 'Profiles Settings',
                    'menu_title'    => 'Profiles',
                    'menu_slug'     => 'kernl-profiles',
                    'post_id'       => 'profiles',
                    'parent_slug'   => 'kernl',
                ));
            }

            // Add ACF Options menus
            // acf_add_options_page([
            //     'capability'  => 'edit_posts',
            //     'icon_url'    => 'dashicons-carrot',
            //     'menu_slug'   => 'kernl',
            //     'menu_title'  => 'kernl(theme)',
            //     'page_title'  => 'kernl(theme) customizations',
            // ]);

            // acf_add_options_page([
            //     'page_title'  => 'Homepage',
            //     'menu_title'  => 'Homepage',
            //     'capability'  => 'edit_posts',
            //     'position'    => '3.0',
            //     'icon_url'    => 'dashicons-admin-home'
            // ]);
        });

        // admin_enqueue_scripts
        add_action('admin_enqueue_scripts', function () {
            // Add custom stylesheet to wp-admin
            wp_enqueue_style('admin-styles', Utility::getThemeURL() . '/vendor/nupods/kernl-theme-lib/resources/assets/styles/wp-admin.css');
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
            if (\WP_ENV == 'production') {
                echo NU::gtmScript();
            }

            // Marketing's favicons
            echo NU::headMeta();

            // Add Lato font
            echo '<link href="//fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900" rel="stylesheet">';

            // Add chrome style
            echo NU::chromeStyle();
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
                        ' . get_field('txt_css', 'option') . '
                    </style>
                ';
            }
        }, 20);

        // wp_body_open
        add_action('wp_body_open', function () {
            // Add tag manager NoScript
            if (\WP_ENV == 'production') {
                echo NU::gtmNoScript();
            }

            // Add skip to main content
            echo '
                <a class="skip alert" href="#app">Skip to main content</a>
                <!--[if IE]>
                <div class="bg-beige fs-sm pa-1 pa-2@d">
                    <b><i>Note</i></b>: You are using an <strong>outdated</strong> browser. Please <a class="tc-red" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
                </div>
                <![endif]-->
            ';
        });

        // wp_footer
        add_action('wp_footer', function () {
            // Add items globally to footer area from Customize
            if (get_field('txt_footer', 'option')) {
                echo get_field('txt_footer', 'option');
            }

            // Add WP edit link
            echo edit_post_link('<i data-feather="edit"></i></span><span class="edit-text">Edit', '', '', 0, 'pos-fixed z-max pin-b pin-r btn -sm bg-blue mb-0');

            // Add chrome script
            echo NU::chromeScript();

            // Add google analytics tracker
            if (\WP_ENV == 'production' && get_field('gaTracker', 'option')) {
                echo NU::googleAnalytics(get_field('gaTracker', 'option'));
            }
        });
    }

    /**
     * WP filters
     * @return void
     */
    protected function filters()
    {
        // upload_mimes (allow SVG mimes)
        add_filter('upload_mimes', function ($mimes) {
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        });

        // admin_footer_text (Add theme & version to wp-admin)
        add_filter('admin_footer_text', function ($text) {
            return 'Theme: ' . wp_get_theme()->get('Name') . ' ' . wp_get_theme()->get('Version');
        }, 1, 2);

        // show_admin_bar (Remove on admin bar on front-end)
        add_filter('show_admin_bar', '__return_false');

        // admin_bar_menu (Replacing "Howdy")
        add_filter('admin_bar_menu', function ($wp_admin_bar) {
            $my_account = $wp_admin_bar->get_node('my-account');
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

        // Remove protection on excerpt
        add_action('init', function () {
            remove_filter('get_the_excerpt', 'members_content_permissions_protect', 95);
            remove_filter('the_excerpt', 'members_content_permissions_protect', 95);
            add_filter('members_please_log_in', function () {
                return;
            }, 100);
        }, 100);

        // Set Sage-friendly template for The Events Calendar
        if (class_exists('Tribe__Settings_Manager')) {
            // Set the The Events Calendar default template to our Sage-friendly template.
            \Tribe__Settings_Manager::set_option('tribeEventsTemplate', 'views/events.blade.php');
        }

        add_filter('template_include', function ($template) {
            // Condition to force CPT's leveraging the layout to use the default page template
            if (get_field('sectionLayout', 'option') && is_singular(get_field('sectionLayout', 'option'))) {
                return get_page_template();
            }

            // Condition to redirect Tribe Events templates
            if (tribe_is_event() || tribe_is_event_category() || tribe_is_in_main_loop() || tribe_is_view() || 'tribe_events' == get_post_type() || is_singular('tribe_events')) {
                return get_theme_file_path(
                    'resources/' . \Tribe__Settings_Manager::get_option('tribeEventsTemplate')
                );
            }

            return $template;
        });

        // Customize TinyMCE style/format options dropdown
        add_filter('tiny_mce_before_init', function ($settings) {
            // @dd('here');
            $style_type = [
                'title' => 'Typography',
                'items' => [
                    [
                        'title' => 'Alignment',
                        'items' => [
                            [
                                'title' => 'Left',
                                'selector' => '*',
                                'classes' => 'ta-l',
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Right',
                                'selector' => '*',
                                'classes' => 'ta-r',
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Center',
                                'selector' => '*',
                                'classes' => 'ta-c',
                                'wrapper' => false
                            ]
                        ]
                    ],
                    [
                        'title' => 'Weight',
                        'items' => [
                            [
                                'title' => '300',
                                'selector' => '*',
                                'classes' => 'fw-300',
                                'wrapper' => false
                            ],
                            [
                                'title' => '400',
                                'selector' => '*',
                                'classes' => 'fw-400',
                                'wrapper' => false
                            ],
                            [
                                'title' => '700',
                                'selector' => '*',
                                'classes' => 'fw-700',
                                'wrapper' => false
                            ],
                            [
                                'title' => '900',
                                'selector' => '*',
                                'classes' => 'fw-900',
                                'wrapper' => false
                            ],
                        ]
                    ],
                    [
                        'title' => 'Sizing',
                        'items' => [
                            [
                                'title' => 'font size xs',
                                'selector' => '*',
                                'classes' => 'fs-xs',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'font size sm',
                                'selector' => '*',
                                'classes' => 'fs-sm',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'font size root',
                                'selector' => '*',
                                'classes' => 'fs-root',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Lead',
                                'selector' => '*',
                                'classes' => 'fs-lead',
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 1',
                                'selector' => '*',
                                'classes' => 'fs-d1',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 2',
                                'selector' => '*',
                                'classes' => 'fs-d2',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 3',
                                'selector' => '*',
                                'classes' => 'fs-d3',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 4',
                                'selector' => '*',
                                'classes' => 'fs-d4',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 5',
                                'selector' => '*',
                                'classes' => 'fs-d5',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 6',
                                'selector' => '*',
                                'classes' => 'fs-d6',
                                'exact' => true,
                                'wrapper' => false
                            ],
                            [
                                'title' => 'Display 7',
                                'selector' => '*',
                                'classes' => 'fs-d7',
                                'exact' => true,
                                'wrapper' => false
                            ],
                        ]
                    ]
                ]
            ];

            $style_buttons = [
                'title' => 'Buttons',
                'items' => [
                    [
                        'title' => 'Basic',
                        'selector' => 'a',
                        'classes' => 'btn',
                        'wrapper' => false
                    ],
                    [
                        'title' => 'Marketing',
                        'selector' => 'a',
                        'classes' => 'btn -m',
                        'wrapper' => false
                    ],
                    [
                        'title' => 'Pill',
                        'selector' => 'a',
                        'classes' => 'btn br-pill',
                        'wrapper' => false
                    ],
                    [
                        'title' => 'Block',
                        'selector' => 'a',
                        'classes' => 'btn -block',
                        'wrapper' => false
                    ],
                    [
                        'title' => 'Small',
                        'selector' => 'a',
                        'classes' => 'btn -sm',
                        'wrapper' => false
                    ],
                ],
            ];

            $settings['style_formats'] = json_encode([
                $style_type,
                $style_buttons
            ]);
            $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;';

            return $settings;
        });

        // Customize TinyMCE buttons
        add_filter('mce_buttons', function ($buttons) {
            // $buttons contains all current buttons
            // instead, return specific buttons to add to tiny mce
            return ['undo', 'redo', 'removeformat', '|', 'bold', 'italic', 'superscript', 'blockquote', 'bullist', 'numlist', 'table', 'hr', 'link', 'unlink', '|', 'formatselect', 'styleselect'];
        });

        // Remove second row entirely
        add_filter('mce_buttons_2', function ($buttons) {
            return []; // clearing out row 2
        });
    }
}
