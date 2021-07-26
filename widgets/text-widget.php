<?php
class Melementor_text_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'melementortext';
    }

    public function get_title()
    {
        return __('Melementor Text', 'melementor');
    }

    public function get_icon()
    {
        return 'eicon-text-area';
    }

    public function get_categories()
    {
        return ['basic'];
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
                'label' => __('Text Box', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('Enter your text', 'melementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Masud Rana',
                'placeholder' => __('Awesome text', 'melementor'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text = $settings['text'];
        echo "<p>" . esc_html($text) . "</p>";
    }

    protected function _content_template()
    {
    }
}
