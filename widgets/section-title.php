<?php
class Melementor_Section_title_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'sectiontitle';
    }

    public function get_title()
    {
        return __('Section Title', 'melementor');
    }

    public function get_icon()
    {
        return 'eicon-text-area';
    }

    public function get_categories()
    {
        return ['melementor', 'basic'];
    }

    /*     
    public function get_script_depends()
    {
    }

    public function get_style_depends()
    {
    } 
    */

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Section Title', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __('Title', 'melementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => __('Section Title', 'melementor')
            ]
        );
        $this->add_control(
            'description',
            [
                'label' => __('Description', 'melementor'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'input_type' => 'text',
                'placeholder' => __('Description', 'melementor'),
                'default' => __('Section description', 'melementor')
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'setting_section',
            [
                'label' => __('Setting', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'text_align',
            [
                'label' => __('Alignment', 'melementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'melementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'melementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'melementor'),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'text-align:{{VALUE}};',
                    '{{WRAPPER}} .section-description' => 'text-align:{{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'melementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'melementor'),
                'label_off' => __('Hide', 'melementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_description',
            [
                'label' => __('Show Description', 'melementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'melementor'),
                'label_off' => __('Hide', 'melementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Heading Style', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __('Typography', 'melementor'),
                'selector' => '{{WRAPPER}} .section-title',
                'fields_options'    => [
                    'typography'    => [
                        'default'   => 'custom',
                    ],
                    'font_weight'   => [
                        'default'   => '700',
                    ],
                    'font_size'     => [
                        'default'   => [
                            'size'  => '19',
                            'unit'  => 'px'
                        ],
                        'size_units' => ['px']
                    ],
                    'text_transform'    => [
                        'default'   => 'capitalize',
                    ]
                ],
            ]
        );

        $this->add_control('text_color', [
            'label' => __('Text Color', 'melementor'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ff0000',
            'selectors' => [
                '{{WRAPPER}} .section-title' => 'color: {{VALUE}}',
            ],
        ]);
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $heading = $settings['heading'];
        $description = $settings['description'];
        $show_title = $settings['show_title'];
        $show_description = $settings['show_description'];
?>
        <div class="section-title-wrapper">
            <?php if ('yes' === $show_title) : ?>
                <h2 class="section-title"><?php echo esc_html($heading) ?></h2>
            <?php endif; ?>
            <?php if ('yes' === $show_description) : ?>
                <p class="section-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>

        </div>
    <?php
    }

    protected function _content_template()
    {
    ?>
        <div class="section-title-wrapper">
            <# if ( 'yes'===settings.show_title ) { #>
                <h2 class="section-title">{{{ settings.heading }}}</h2>
                <# } #>
                    <# if ( 'yes'===settings.show_description ) { #>
                        <p class="section-description">{{{settings.description}}}</p>
                        <# } #>
        </div>
<?php

    }
}
