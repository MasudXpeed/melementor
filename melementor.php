<?php
/* 
    Plugin Name: Melementor
    Plugin URI: http://masudrana.me/
    Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
    Author: Masud Rana
    Text Domain: melementor
    Version: 1.0
    Author URI: http://masudrana.me/
*/

if (!defined('ABSPATH')) {
    exit;
}

final class Melementor_Extension
{

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {

        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }
    public function i18n()
    {

        load_plugin_textdomain('melementor');
    }
    public function on_plugins_loaded()
    {

        if ($this->is_compatible()) {
            add_action('elementor/init', [$this, 'init']);
        }
    }
    public function is_compatible()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }
        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }
        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }
        return true;
    }
    // Notice if Elementor installed and activated
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'melementor'),
            '<strong>' . esc_html__('Melementor', 'melementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'melementor') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    // Notice for required Elementor version
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'melementor'),
            '<strong>' . esc_html__('Melementor', 'melementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'melementor') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    // Notice for required PHP version
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension'),
            '<strong>' . esc_html__('Elementor Test Extension', 'elementor-test-extension') . '</strong>',
            '<strong>' . esc_html__('PHP', 'elementor-test-extension') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    public function init()
    {

        $this->i18n();

        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
    }
    public function init_widgets()
    {

        // Include Widget files
        require_once(__DIR__ . '/widgets/text-widget.php');
        require_once(__DIR__ . '/widgets/oembed-widget.php');

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Melementor_text_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Melementor_oEmbed_Widget());
    }
    public function includes()
    {
    }
}
Melementor_Extension::instance();
