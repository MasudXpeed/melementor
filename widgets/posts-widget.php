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
        $this->add_control(
            'column_class',
            [
                'label' => esc_html__('Posts Column', 'bascart'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default'   => (isset($default['column']) ? esc_attr($default['column']) : 'col-md-6 col-lg-2'),
                'options'   => [
                    'col-md-6 col-lg-12' => 'Column 1',
                    'col-md-6 col-lg-6' => 'Column 2',
                    'col-md-6 col-lg-4' => 'Column 3',
                    'col-md-6 col-lg-3' => 'Column 4',
                    'col-md-6 col-lg-2' => 'Column 6',
                ]
            ]
        );
        $this->add_control(
            'divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );
        $this->add_control(
            'hide_post_title',
            [
                'label' => __('Show post title', 'melementor'),
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
        $hide_post_title = $settings['hide_post_title'];
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
                    <?php
                    $column_class = !empty($settings['column_class']) ? $settings['column_class'] : 'col-md-4'; ?>
                    <div class="<?php echo esc_attr($column_class); ?>">
                        <div class="single-post">
                            <div class="post-thumbnail-wrapper">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
                            </div>
                            <div class="post-content">

                                <?php if ('yes' === $hide_post_title) : ?>
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <?php endif; ?>
                                <?php the_excerpt(); ?>

                            </div>
                        </div>
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
