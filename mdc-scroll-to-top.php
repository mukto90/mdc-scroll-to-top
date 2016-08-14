<?php
/*
Plugin Name: Scroll to Top
Description: Adds a 'Scroll to Top' feature to your site.
Plugin URI: http://https://wordpress.org/plugins/mdc-scroll-to-top/
Author: Nazmul Ahsan
Author URI: http://nazmulahsan.me
Version: 2.0
License: GPL2
Text Domain: mdc-scroll-to-top 
*/

/*

    Copyright (C) 2016  Nazmul Ahsan  mail@nazmulahsan.me

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if( ! defined( 'ABSPATH' ) ) exit();
/**
 * main class for the plugin
 */
if( ! class_exists( 'MDC_Scroll_to_Top' ) ) :
class MDC_Scroll_to_Top {

    public static $_instance;

    public function __construct() {
        self::define();
        self::inc();
        self::hooks();
    }

    public function define() {
        define( 'MDC_SCROLL_TO_TOP', __FILE__ );
    }

    public function inc() {
        require_once dirname( MDC_SCROLL_TO_TOP ) . '/admin/mdc-scroll-to-top-settings.php';
    }

    public function hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'wp_footer', array( $this, 'show_icon' ) );
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_style( 'mdc-scroll-to-top', plugins_url( '/assets/css/style.css', MDC_SCROLL_TO_TOP ) );
        $background = mdc_get_option( 'background', 'mdc_scroll_to_top_style', 'transparent' );
        $bottom = mdc_get_option( 'bottom', 'mdc_scroll_to_top_style', '40' ) . 'px';
        $height = mdc_get_option( 'height', 'mdc_scroll_to_top_style', '40' ) . 'px';
        $width = mdc_get_option( 'width', 'mdc_scroll_to_top_style', '40' ) . 'px';
        $padding = mdc_get_option( 'padding', 'mdc_scroll_to_top_style', '40' ) . 'px';
        $position = mdc_get_option( 'position', 'mdc_scroll_to_top_style', 'right' );
        $cursor = 'cursor';
        $custom_css = "
        .scroll-to-top{
            background: {$background};
            bottom: {$bottom};
            {$position}: {$padding};
            height: {$height};
            width: {$width};
            cursor: {$cursor};
        }";
        wp_add_inline_style( 'mdc-scroll-to-top', $custom_css );

        wp_enqueue_script( 'mdc-scroll-to-top', plugins_url( '/assets/js/script.js', MDC_SCROLL_TO_TOP ), array(), '1.0', true );
        $time_to_scroll = mdc_get_option( 'time_to_scroll', 'mdc_scroll_to_top_style', '1000' );
        $show_after_px = mdc_get_option( 'show_after_px', 'mdc_scroll_to_top_style', '100' );
        $custom_js = "
            var time_to_scroll = {$time_to_scroll};
            var show_after_px = {$show_after_px};
        ";
        wp_add_inline_script( 'mdc-scroll-to-top', $custom_js );
    }

    public function admin_enqueue_scripts() {
        if( isset( $_GET['page'] ) && $_GET['page'] == 'scroll-settings' ) :
        wp_enqueue_style( 'mdc-scroll-to-top-admin', plugins_url( '/assets/css/admin.css', MDC_SCROLL_TO_TOP ) );
        wp_enqueue_script( 'mdc-scroll-to-top-admin', plugins_url( '/assets/js/admin.js', MDC_SCROLL_TO_TOP ), array(), '1.0', true );
        endif;
    }

    public function show_icon() {
        $html = '<img title="Scroll to Top" class="scroll-to-top" src="' . mdc_get_option( mdc_get_option( 'icon_type', 'mdc_scroll_to_top_icon' ), 'mdc_scroll_to_top_icon', plugins_url( 'assets/icons/arrow23.png', MDC_SCROLL_TO_TOP ) ) . '" />';
        echo $html;
    }

    /**
     * Instantiate the plugin
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}
endif;
MDC_Scroll_to_Top::instance();