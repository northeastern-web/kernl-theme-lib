<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

class AcfDocumentation
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->defineFields();
    }

    /**
     * Defines ACF fields
     * @return void
     */
    protected function defineFields()
    {
        add_action('wp_loaded', function () {
            $docs = new FieldsBuilder('docs');
            $docs
                ->addMessage('Welcome to kernl(theme)', 'We hope you find this theme easy to use. Please see <a href="https://assets.provost.northeastern.edu/kernl/wp/">kernl(docs)</a> for detailed documentation.');

            // Build the customize page
            $documentation = new FieldsBuilder('documentation', ['title' => 'Customize', 'style' => 'seamless']);
            $documentation
                ->addFields($docs)
                    ->setLocation('options_page', '==', 'acf-options-documentation');

            acf_add_local_field_group($documentation->build());
        });
    }
}
