<?php

namespace Kernl\Lib;

class Pagination
{
    /**
     * Displays pagination for archives
     * @return string   Prints pagination format
     */
    public static function display($pages = '', $range = 4)
    {
        global $paged;
        $showitems = ($range * 2) + 1;
        $pagination = '';
        $pagination_list = '';
        $pagination_previous = '';
        $pagination_next = '';

        if (empty($paged)) {
            $paged = 1;
        }

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;

            if (!$pages) {
                $pages = 1;
            }
        }

        if ($pages > 1) {
            $pagination_previous .= '
                <li class="nav_item">
                    <a class="nav_link" href="'.get_pagenum_link($paged - 1).'" aria-label="Previous">
                        <i data-feather="chevron-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            ';

            $pagination_next .= '
                <li class="nav_item">
                    <a class="nav_link" href="'.get_pagenum_link($paged + 1).'" aria-label="Previous">
                        <i data-feather="chevron-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            ';

            for ($i=1; $i <= $pages; $i++) {
                if ($pages != 1 &&(!($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems)) {
                    $pagination_list .= ($paged == $i ? '
                        <li class="nav_item">
                            <a class="nav_link -active">'.$i.'<span class="sr-only">(current)</span></a>
                        </li>' :
                        '<li class="nav_item">
                            <a class="nav_link" href="'.get_pagenum_link($i).'">'.$i.'</a>
                        </li>
                    ');
                }
            }
        }

        return '
            <nav class="nav -pagination">
                <ul class="nav_list">'
                    . $pagination_previous . $pagination_list . $pagination_next .
                '</ul>
            </nav>
        ';
    }
}
