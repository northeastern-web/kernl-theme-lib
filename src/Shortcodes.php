<?php

namespace Kernl\Lib;

use Illuminate\Container\Util;

class Shortcodes
{

    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->shortcodeVideo();
    }

    /**
     * Shortcode to craft a video embed
     * @return void add_shortcode()
     */
    protected function shortcodeVideo()
    {
        add_shortcode('vid', function ($atts) {
            $default_atts = [
                'id' => '',
                'player' => 'https://www.youtube.com/embed/',
                'cssClass' => 'ar-16x9 mb-1',
            ];
            $parameters = shortcode_atts($default_atts, $atts);

            // ideally, this will include the "block"
            echo '
            <div class="ar ' . $parameters['cssClass'] . '">
                <iframe class="ar-object w-100" src="' . $parameters['player'] . $parameters['id'] . '?title=0&byline=0&portrait=0&color=#cc0000" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>
            </div>';
        });
    }
}
