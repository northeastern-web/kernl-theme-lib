<?php

namespace Kernl\Lib;

use StoutLogic\AcfBuilder\FieldsBuilder;

class AcfCustomize
{
    /**
     * Constructor
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
            $generic = new FieldsBuilder('generic');
            $generic->addTab('Generic')
                ->addMessage('Logos', '')
                    ->addImage('med_logo', ['label' => 'Logo', 'preview_size' => 'medium', 'wrapper' => ['width' => '50'], 'return_format' => 'url'])
                    ->addImage('med_logo_white', ['label' => 'Logo (white)', 'preview_size' => 'medium', 'wrapper' => ['width' => '50'], 'return_format' => 'url'])
                ->addMessage('Google Analytics (applied in Production only)', '')
                    ->addText('txt_analytics', ['label' => 'GA Tracker'])
                ->addMessage('Global Styles', '')
                    ->addTrueFalse('bool_chrome_header', ['label' => 'Add brand header', 'wrapper' => ['width' => '25'], 'ui' => 1])
                    ->addTrueFalse('bool_chrome_footer', ['label' => 'Add brand footer', 'wrapper' => ['width' => '25'], 'ui' => 1])
                    ->addSelect('opt_masthead', [
                        'label' => 'Masthead Options',
                        'allow_null' => 1,
                        'multiple' => 1,
                        'return_format' => 'value',
                        'ui' => 1,
                        'wrapper' => ['width' => '100']
                    ])
                        ->addChoices([
                            ['bg--black' => 'Black'],
                            ['--megamenu' => 'Megamenu'],
                            ['+border' => 'Bordered'],
                            ['+chevron' => 'Chevron'],
                            ['--logo-md' => 'Medium Logo'],
                            ['--logo-lg' => 'Larger Logo'],
                        ])
                    ->addTrueFalse('bool_global_contain', ['label' => 'Contain document/page width', 'wrapper' => ['width' => '25'], 'ui' => 1])
                    ->addTrueFalse('bool_global_contain_body', ['label' => 'Apply contain to body only', 'wrapper' => ['width' => '25'], 'ui' => 1])
                        ->conditional('bool_global_contain', '==', '1')
                    ->addTextarea('txt_css', ['label' => 'Add Global CSS', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code'])
                ->addMessage('Global Items', '')
                    ->addTextarea('txt_head', ['label' => 'Add Global items to head', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code'])
                    ->addTextarea('txt_footer', ['label' => 'Add Global items to footer', 'wrapper' => ['width' => '100'], 'rows' => 15, 'class' => 'kernl--code']);

            $post_types = [];
            foreach (get_post_types(['public' => true]) as $type) {
                $post_types[] = ($type !== 'attachment' ? $type : null);
            }
            $layout = new FieldsBuilder('layout');
            $layout->addTab('Layout')
                ->addMessage('Add section layout to the following post types', '')
                ->addSelect('opt_post_sections', [
                    'label' => 'Select Post Types',
                    'allow_null' => 1,
                    'multiple' => 1,
                    'return_format' => 'value',
                    'ui' => 1,
                    'default_value' => 'page'
                ])
                    ->addChoices($post_types);

            $extend = new FieldsBuilder('extend');
            $extend->addTab('Extensions')
                ->addTrueFalse('bool_profiles', ['label' => 'Enable Profiles', 'ui' => 1])
                ->addTrueFalse('bool_articles', ['label' => 'Enable Articles (knowledgebase)', 'ui' => 1]);
                // ->addTrueFalse('bool_modules', ['label' => 'Enable Modules', 'ui' => 1]);

            $events = new FieldsBuilder('events');
            $events->addTab('Events')
                ->addMessage('Configure Tribe Events Calendar', 'Once the Tribe Events plugin has been activated, the following custom fields can further enhance your calendar.')
                ->addText('txt_events_pretitle', ['label' => 'Banner Pretitle'])
                ->addText('txt_events_title', ['label' => 'Banner Title'])
                ->addTextarea('txt_events_subtitle', ['label' => 'Banner Subtitle', 'wrapper' => ['width' => '100'], 'rows' => 3]);

            $page_not_found = new FieldsBuilder('page_not_found');
            $page_not_found->addTab('404 Page')
                ->addWysiwyg('txt_404', ['label' => 'Copy']);

            // Build the customize page
            $customize = new FieldsBuilder('customize', ['title' => 'Customize', 'style' => 'seamless']);
            $customize
                ->addFields($generic)
                ->addFields($layout)
                ->addFields($events)
                ->addFields($page_not_found)
                ->addFields($extend)
                    ->setLocation('options_page', '==', 'acf-options-customize');

            acf_add_local_field_group($customize->build());
        });
    }
}
