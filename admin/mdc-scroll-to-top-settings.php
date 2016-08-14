<?php
if( ! defined( 'ABSPATH' ) ) exit();

require_once dirname( __FILE__ ) . '/class.mdc-settings-api.php';

if ( ! class_exists( 'MDC_Scroll_to_Top_Settings' ) ) :

class MDC_Scroll_to_Top_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new MDC_Settings_API;

        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 51 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_menu_page( 'Scroll to Top Settings', 'Scroll to Top', 'manage_options', 'scroll-settings', array( $this, 'option_page' ), 'dashicons-arrow-up-alt' );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'mdc_scroll_to_top_icon',
                'title' => 'Choose Icon',
            ),
            array(
                'id' => 'mdc_scroll_to_top_style',
                'title' => 'Appearance',
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(

            'mdc_scroll_to_top_icon' => array(
                array(
                    'name'    =>  'icon_type',
                    'label'   =>  'Icon Type',
                    'type'    =>   'radio',
                    'options' => array('preset'=>'Preset', 'upload'=>'Upload'),
                    'default' =>  'preset',
                ),
                array(
                    'name'    =>  'upload',
                    'label'   =>  'Upload your own Icon',
                    'desc'    => 'If \'Icon Type\' is set to \'Upload\'',
                    'type'    =>   'file',
                    'default' => plugins_url( 'assets/icons/arrow23.png', MDC_SCROLL_TO_TOP )
                ),
                array(
                    'name'    =>  'preset',
                    'label'   =>  'Choose from preset Icons',
                    'desc'    => 'If \'Icon Type\' is set to \'Preset\'',
                    'type'    =>   'radio',
                    'options' => $this->preset_icons(),
                    'default' => plugins_url( 'assets/icons/arrow23.png', MDC_SCROLL_TO_TOP )
                ),
            ),
            
            'mdc_scroll_to_top_style' => array(
                // array(
                //     'name'    =>  'background',
                //     'label'   =>  'Background Color',
                //     'type'    =>   'color',
                //     'desc'    =>  '',
                //     'default' =>  '#fff',
                // ),
                array(
                    'name'    =>  'position',
                    'label'   =>  'Position of the Icon',
                    'type'    =>   'radio',
                    'default' =>  'right',
                    'options' => array( 'right' => 'Right', 'left' => 'Left' )
                ),
                array(
                    'name'    =>  'height',
                    'label'   =>  'Icon Height (px)',
                    'type'    =>   'number',
                    'default' =>  '40',
                ),
                array(
                    'name'    =>  'width',
                    'label'   =>  'Icon Width (px)',
                    'type'    =>   'number',
                    'default' =>  '40',
                ),
                array(
                    'name'    =>  'bottom',
                    'label'   =>  'Padding from Bottom (px)',
                    'type'    =>   'number',
                    'default' =>  '40',
                ),
                array(
                    'name'    =>  'padding',
                    'label'   =>  'Padding from Side (px)',
                    'type'    =>   'number',
                    'desc'    =>  'Padding from left or right, based on your settings.',
                    'default' =>  '40',
                ),
                array(
                    'name'    =>  'time_to_scroll',
                    'label'   =>  'Time to Scroll (mili second)',
                    'type'    =>   'number',
                    'desc'    =>  'Time to reach to top of the page after clicking the icon. (1 second = 1000 mili seconds)',
                    'default' =>  '1000',
                ),
                array(
                    'name'    =>  'show_after_px',
                    'label'   =>  'Scroll down to show (px)',
                    'type'    =>   'number',
                    'desc'    =>  'Icon will be shown up after scrolling down of this amount of pixels of the webpage',
                    'default' =>  '100',
                ),
            ),

        );

        return $settings_fields;
    }

    function option_page() {
        echo '<div class="wrap">';
        ?>
        
            <div class="scroll-to-up-setting-page-title">
                <h1><i>Scroll to Top</i> Settings</h1>
            </div>

        <div class="stp-col-left">
            <?php 
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms(); ?>
        </div>


    <?php echo '</div>';
    }

    public function preset_icons() {
        $icons = [];
        for( $i=1; $i<=80; $i++){
            $icons[plugins_url( 'assets/icons/arrow' . $i . '.png', MDC_SCROLL_TO_TOP )] = '<img src="' . plugins_url( 'assets/icons/arrow' . $i . '.png', MDC_SCROLL_TO_TOP ) . '" />';
        }
        return $icons;
    }

}

new MDC_Scroll_to_Top_Settings;
endif;

if( ! function_exists( 'mdc_get_option' ) ) :
function mdc_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}
endif;
