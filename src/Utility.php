<?php

namespace Kernl\Lib;

class Utility
{
    public static function getThemeURL()
    {
        return get_stylesheet_directory_uri();
    }

    /**
     * Loads a file within views/templates
     * @param  string $file path to file in views/templates
     * @return ob_get_contents
     */
    public static function getView($path, $data = [])
    {
        // Sage function to locate compiled template
        $path = $path . '.blade.php';
        $location = locate_template($path . '.blade.php');
        @dd($path, $location);
        ob_start();
        extract($data);
        include $path;
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    /**
     * Helper function to get ACF field includes.
     *
     * @param  mixed $block
     * @return mixed
     */
    public static function getField($field)
    {
        $field = str_replace('.', '/', $field);
        return include(__DIR__ . "/acf/fields/{$field}.php");
    }

    /**
     * Get Global contain class
     * @return string
     */
    public static function getGlobalContain()
    {
        $output = (get_field('bool_global_contain', 'option') ? 'contain' : '');
        $output .= (get_field('bool_global_contain_body', 'option') ? ' --body' : '');
        return ($output ? 'class="' . $output . '"' : '');
    }

    /**
     * Helper function to get ACF logo field.
     *
     * @param  mixed $block
     * @return mixed
     */
    public static function getLogo()
    {
        $option = (is_home() ? 'option' : (is_singular() ? get_the_ID() : get_queried_object()));
        $logo = get_field('logo', 'option');

        // Check if logo should be white option
        if (
            !empty(get_field('masthead', 'option'))
            && in_array('-dark', get_field('masthead', 'option'))
        ) {
            $logo = get_field('logoWhite', 'option');
        }

        if (
            get_field('hasOverlay', $option)
            ||  self::getParentValues('hasOverlay')
        ) {
            $logo = get_field('logoWhite', 'option');
        }

        return $logo;
    }

    /**
     * Helper function to craft the masthead class
     *
     * @return string
     */
    public static function getMastheadClass()
    {
        $class = 'masthead';
        $option = (is_home() ? 'option' : (is_singular() ? get_the_ID() : get_queried_object()));

        // Check if global masthead options are set
        if (get_field('masthead', 'option')) {
            $class .= ' ' . implode(' ', get_field('masthead', 'option'));
        }

        // Check if specific page is an overlay
        if (get_field('hasOverlay', $option) ||  self::getParentValues('hasOverlay')) {
            $class .= ' -overlay';
        }

        // Check if has support nav
        if (has_nav_menu('navSupport')) {
            $class .= ' -support';
        }

        // Check if has navbar
        if (has_nav_menu('navBar')) {
            $class .= ' -navbar';
        }

        return $class;
    }

    /**
     * Helper function to get and ACF 'options' field
     * for multiple structures and components, we end up creating
     * and 'options' select field and 'class' text field we want applied.
     *
     * @param  string $class
     * @param  string $fieldtype
     * @return string
     */
    public static function getOptClass($class, $fieldtype = 'get_sub_field')
    {
        $option = get_queried_object();

        if (is_singular()) {
            $option = get_the_ID();
        }

        if (is_singular('profile')) {
            $option = 'profiles';
        }

        if (is_post_type_archive('tribe_events') || is_singular('tribe_events')) {
            $option = 'events';
        }

        if ($fieldtype('options', $option) && !is_search()) {
            $class .= ' ' . implode(' ', $fieldtype('options', $option));
        }

        if ($fieldtype('cssClass', $option) && !is_search()) {
            $class .= ' ' . $fieldtype('cssClass', $option);
        }

        if ($fieldtype('image', $option) && (strpos($class, 'card') !== 0) && !is_search()) {
            $class .= ' bg-img';
        }

        if ($class == 'masthead') {
            $class .= '';
        }

        if (is_search() && $class == 'banner') {
            $class .= '';
        }

        return rtrim($class);
    }

    /**
     * Look up ACF values for a page for closest ancestor
     *
     * @param  string $field ACF field to use
     * @return string Value of ACF field
     */
    public static function getParentValues($field)
    {
        // Start by getting all ancestor ids
        $ancestor_ids = get_post_ancestors(get_the_id());

        // If this is a child page
        if ($ancestor_ids) {
            // Grab all ancestor ids with valid inheritance options
            $inherit_options = [];
            foreach ($ancestor_ids as $ancestor_id) {
                if (get_field($field, $ancestor_id)) {
                    $inherit_options[] = $ancestor_id;
                }
            }

            // Set id of closest ancestor
            $inherit_id = current($inherit_options);

            // Check if title
            // - inject breadcrumb to pretitle
            if ($field == 'txt_title') {
                $output = '<nav class="breadcrumb">';
                foreach (array_reverse($ancestor_ids) as $ancestor_id) {
                    $output .= '<a href="' . get_permalink($ancestor_id) . '">' . get_the_title($ancestor_id) . '</a>';
                }
                $output .= '</nav>';
                return $output;
            }

            // Check Options
            if ($field == 'opt_section') {
                return self::getOptions('opt_section', ' ', 'get_field', $inherit_id);
            }

            // If not looking for special conditions above, return basic field
            return get_field($field, $inherit_id);
        }
    }

    /**
     * Get full Tribe Events date
     * @param  string   $content
     * @return string
     */
    public static function getTribeDate($id, $format = 'M j, Y | g:i A')
    {
        // Remove time format if event is all day
        if (tribe_event_is_all_day()) {
            $format = 'M j, Y';
        }

        // Get start and end dates
        $start_date = tribe_get_start_date($id, false, $format);
        $end_date = tribe_get_end_date($id, false, $format);

        // Return multiday format
        if (tribe_event_is_multiday()) {
            return $start_date . ' &mdash; ' . $end_date;
        }

        // Return single day format
        return $start_date;
    }

    /**
     * Get interior page navigation
     * @param  string   $content
     * @return string
     */
    public static function getInteriorNav($level = 'top', $depth = 2, $child_of = false, $title_li = '')
    {
        global $post;
        $ancestors = get_post_ancestors($post->ID);
        $root_ancestor = ($ancestors ? end($ancestors) : $post->ID);

        if (!$child_of) {
            if ($level === 'top') {
                if ($ancestors) {
                    $child_of = (count($ancestors) == 1 ? current($ancestors) : end($ancestors));
                } else {
                    $child_of = $post->ID;
                }
            } elseif (count($ancestors) > 1) {
                array_pop($ancestors); // remove last item
                $child_of = end($ancestors);
            } else {
                $child_of = $post->ID;
            }
        }

        return wp_list_pages('title_li=&child_of=' . $child_of . '&depth=' . $depth . '&echo=0');
    }

    /**
     * Remove empty paragraph tags
     * @param  string   $content
     * @return string
     */
    public static function removeEmptyParagraphs($content)
    {
        $content = force_balance_tags($content);
        $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
        $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
        return $content;
    }
}
