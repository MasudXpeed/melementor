<?php
class Melementor_Posts_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'postwidget';
    }

    public function get_title()
    {
        return __('Post Widget', 'melementor');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
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
                'label' => __('Posts Widget Settings', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Post Count', 'melementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '3',
                'min' => 1,
                'max' => 50,
                'step' => 1,
                'responsive'    => false
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Posts Widget Style', 'melementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'label' => esc_html__('Typography', 'melementor'),
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .post-title',
                'fields_options' => [
                    'typography' => [
                        'default' => 'custom',
                    ],
                    'font_weight' => [
                        'default' => '600',
                    ],
                    'font_size' => [
                        'default' => [
                            'size' => '18',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ]
                ],
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label' => __('Title Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-title a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $posts_per_page = $settings['posts_per_page'];
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page
        );
        $query = new WP_Query($args);
?>
        <div class="posts-wrapper">
            <?php if ($query->have_posts()) : ?>
                <!-- pagination here -->

                <!-- the loop -->
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="single-post">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
                        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                <?php endwhile; ?>
                <!-- end of the loop -->

                <!-- pagination here -->

                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        </div>
<?php
    }

    protected function _content_template()
    {
    }
}
