<?php

namespace Kernl\Lib;

class ShortcodeInclude
{
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        $this->shortcodeInclude();
    }

    /**
     * Create WP shortcode [include file="/path/to/file"]
     * *Allows passing a query string
     * @return void
     */
    protected function shortcodeInclude()
    {
        add_shortcode('include', function ($atts) {
            extract(
                shortcode_atts(['file' => 'NULL'], $atts)
            );

            // check for query string of variables after file path
            if (strpos($file, "?")) {
                global $query_string;
                $qs_position = strpos($file, "?");
                $qs_values = str_replace("amp;", "", substr($file, $qs_position + 1));
                parse_str($qs_values, $query_string);

                // Remove query string from file
                $file = substr($file, 0, $qs_position);
            }

            $filepath = get_stylesheet_directory() .'/views/'. $file;

            // check if the file was specified and if the file exists
            if ($file != 'NULL' && file_exists($filepath)) {
                // turn on output buffering to capture script output
                ob_start();

                // include the specified file
                echo \App\template($filepath);

                // assign the file output to $content variable and clean buffer
                $content = ob_get_clean();

                return $content;
            }
        });
    }

    /**
     * Get template name based on comment Doc Block in parenthesis
     * eg. (Template: Card)
     * @param  string $file path to file
     * @return string       returns template name
     */
    private function getFileDocBlock($file)
    {
        $docComments = array_filter(
            token_get_all(file_get_contents($file)),
            function ($entry) {
                return $entry[0] == T_DOC_COMMENT;
            }
        );
        $fileDocComment = array_shift($docComments);

        // Match pattern in parenthesis
        preg_match('#\((.*?)\)#', $fileDocComment[1], $templateName);
        return $templateName;
    }
}
