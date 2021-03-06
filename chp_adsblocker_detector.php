<?php

/**
 * Plugin Name:       CHP Ads Block Detector
 * Description:       This plugin detect if user is using the ads blocker.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Suresh Chand
 * Author URI:        https://codehelppro.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       chp_adsblocker_detector
 * Domain Path:       /languages
 */

if( !defined('ABSPATH') ) exit(1);

/****************************************
PLUGIN VERSION
*****************************************/ 
if(!defined('CHP_ADSB_VERSION'))
   define('CHP_ADSB_VERSION', '1.0');

/****************************************
PLUGIN DIRECTORY PATH CONSTANT
*****************************************/ 
if(!defined('CHP_ADSB_DIR'))
   define('CHP_ADSB_DIR', plugin_dir_path( __FILE__ ));

/****************************************
PLUGIN URL CONSTANT
*****************************************/  
if(!defined('CHP_ADSB_URL'))
   define('CHP_ADSB_URL', plugin_dir_url( __FILE__ ));


/****************************************
CHECK Whether class already exists
*****************************************/
if( ! class_exists( 'chp_adsblocker_detector' ) ){

    /****************************************
    Main Class Start
    *****************************************/ 
    class chp_adsblocker_detector{

        /****************************************
        Constructor Class
        *****************************************/
        public function __construct(){

            /****************************************
            Adding Scripts to footer
            *****************************************/
            add_action( 'wp_footer',  [$this, 'js'], 100);
            

            /****************************************
            Adding required scripts to footer
            *****************************************/
            add_action( 'wp_enqueue_scripts',  [$this, 'scripts'], 1);


            /****************************************
            Adding scripts for admin dashboard
            *****************************************/
            add_action( 'admin_enqueue_scripts',  [$this, 'admin_scripts']);


            /****************************************
            Adding styles to header
            *****************************************/
            add_action( 'wp_head',  [$this, 'css'], 100);


            /****************************************
            Adding Administartive menus under settings
            *****************************************/
            add_action( 'admin_menu', [$this, 'admin_menu'] );


            /****************************************
            Adding settings label
            *****************************************/
            add_filter('plugin_action_links', [$this, 'plugin_links'], 10, 2  );


            /****************************************
            Adding settings for changes
            *****************************************/
            add_action('admin_init', [$this, 'settings']);


            /****************************************
            Handling ajax from admin
            *****************************************/
            add_action("wp_ajax_chp_abd_action", [$this, 'chp_abd_action']);
            
        }


        /****************************************
        Registering settings for changes
        *****************************************/    
        public function settings(){
            register_setting('chp_abd_settings', 'registred_chp_abd_settings');
            add_settings_section(
                'chp_abd_settings_section',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings'
            );

            add_settings_field(
                'chp_adb_plugin_enable',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings',
                'chp_abd_settings_section'
            );

            add_settings_field(
                'chp_adb_plugin_title',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings',
                'chp_abd_settings_section'
            );

            add_settings_field(
                'chp_adb_plugin_content',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings',
                'chp_abd_settings_section'
            );

            add_settings_field(
                'chp_adb_plugin_btn1_show',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings',
                'chp_abd_settings_section'
            );

            add_settings_field(
                'chp_adb_plugin_btn2_show',
                '',
                [$this, 'ofs_null'],
                'chp_abd_settings',
                'chp_abd_settings_section'
            );
        }


        /****************************************
        Null function
        *****************************************/   
        public function ofs_null(){
            return false;
        }


        /****************************************
        Handle ajax request from admin
        *****************************************/   
        public function chp_abd_action( ){

            /****************************************
            Save All the settings
            *****************************************/ 
            if( isset( $_POST['settings'] ) ){
                $settings = $_POST['settings'];
                if( is_array ( $settings ) && ! empty ( $settings ) ){
                   
                    /****************************************
                    update settings of plugin
                    *****************************************/
                    $enable = sanitize_text_field($settings['enable']);
                    $title = sanitize_text_field($settings['title']);
                    $btn1_show = sanitize_text_field($settings['btn1_show']);
                    $btn2_show = sanitize_text_field($settings['btn2_show']);
                    $content = wp_kses_post($settings['content']);

                    if( !is_bool($enable) )
                        update_option( 'chp_adb_plugin_enable', $enable );

                    if( !empty($title) )
                        update_option( 'chp_adb_plugin_title', $title );

                    if( !empty($content) )
                        update_option( 'chp_adb_plugin_content', $content );
                    
                    if( !is_bool($btn1_show) )
                        update_option( 'chp_adb_plugin_btn1_show', $btn1_show );
                    
                    if( !is_bool($btn2_show) )
                        update_option( 'chp_adb_plugin_btn2_show', $btn2_show );
                    
                    echo 'Settings save successfully';
                }else{
                    echo 'We got some issue on updating settings.';
                }
            }


            /****************************************
            Reset All the settings
            *****************************************/ 
            if( isset( $_POST['reset'] ) ){
                $options = chp_ads_block_defaults();
                update_option( 'chp_adb_plugin_enable', $options->enable );
                update_option( 'chp_adb_plugin_title', $options->title );
                update_option( 'chp_adb_plugin_content', $options->content );
                update_option( 'chp_adb_plugin_btn1_show', $options->btn1_show );
                update_option( 'chp_adb_plugin_btn1_show', $options->btn2_show );
                echo 'Settings reset successfully';
            }

            /****************************************
            End ajax request
            *****************************************/ 
            die();
        }


        /****************************************
        Adding Administartive menus under settings
        *****************************************/   
        public function admin_menu( ){
            add_options_page(
                __( 'Ads Block Detector', 'textdomain' ),
                __( 'Ads Block Detector', 'textdomain' ),
                'manage_options',
                'chp-adsblocker-detector',
                [$this, 'setting_page']
            );
        }


        /****************************************
        Setting HTML Template
        *****************************************/   
        public function setting_page( ){

            if( file_exists ( CHP_ADSB_DIR . 'settings.php' ) )
                require_once CHP_ADSB_DIR . 'settings.php';

        }

        /****************************************
        Adding settings label
        *****************************************/
        function plugin_links($links, $file){

            /****************************************
            Insert Settings link
            *****************************************/
            $links[] = '<a href="options-general.php?page=chp-adsblocker-detector">'.__('Settings','chp_adsblocker_detector').'</a>';
            return $links;

        }


       /****************************************
        Adding script to website
        *****************************************/  
        public function scripts(){

            wp_enqueue_script( 'chp-ads-handler', CHP_ADSB_URL . 'js/chp-ads.js', array(), '1.0', true );

        }


        /****************************************
        Adding scripts for admin dashboard
        *****************************************/  
        public function admin_scripts(){

            //color picker scripts
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );

            //plugin css and js code
            wp_enqueue_script( 'chp-ads-admin-js', CHP_ADSB_URL . 'js/admin.js', array(), 
            '1.0', true );
            wp_enqueue_style( 'chp-ads-admin-css', CHP_ADSB_URL . 'css/admin.css', array() );
            wp_localize_script( 'chp-ads-admin-js', 'chpadb', array(
                'plugin_path' => CHP_ADSB_URL
            ) );
        }

        
        /****************************************
        Adding JS Code To Footer
        *****************************************/  
        public function js(){

            /****************************************
            Get user settings
            *****************************************/ 
            $settings = array(
                'enable' => empty(get_option( 'chp_adb_plugin_enable' )) ? true : get_option( 'chp_adb_plugin_enable' ),
                'title' => empty(get_option( 'chp_adb_plugin_title' )) ? 'Ads Blocker Detected!!!' : get_option( 'chp_adb_plugin_title' ),
                'content' => empty(get_option( 'chp_adb_plugin_content' )) ? '<p>We have detected that you are using extensions to block ads. Please support us by disabling these ads blocker.</p>' : get_option( 'chp_adb_plugin_content' ),
                'btn1_show' => empty(get_option( 'chp_adb_plugin_btn1_show' )) ? true : get_option( 'chp_adb_plugin_btn1_show' ),
                'btn2_show' => empty(get_option( 'chp_adb_plugin_btn2_show' )) ? false : get_option( 'chp_adb_plugin_btn2_show' )           
            );

            /****************************************
            Check Whether plugin is active
            *****************************************/ 
            if( filter_var( $settings['enable'], FILTER_VALIDATE_BOOLEAN ) ):

            ?>
<div class="chp_ads_blocker-overlay" id="chp_ads_blocker-overlay" tabindex="-1"></div>
<div class="chp_ads_blocker_detector chp_ads_blocker_detector-hide" id="chp_ads_blocker-modal"><img class="chp_ads_blocker_detector-icon" src="<?php echo CHP_ADSB_URL; ?>img/icon.png" alt="Ads Blocker Image Powered by Code Help Pro"><div class="chp_ads_blocker_detector-title"><?php echo $settings['title']; ?></div><div class="chp_ads_blocker_detector-content"><?php echo str_replace('<p', '<p class="chp_ads_blocker_detector-message"', $settings['content']); ?></div><div class="chp_ads_blocker_detector-action"><?php if( filter_var( $settings['btn2_show'], FILTER_VALIDATE_BOOLEAN ) ): ?><a class="chp_ads_blocker_detector-action-btn-close" onclick="chp_ads_blocker_detector(false)">Close</a><?php endif; ?><?php if( filter_var( $settings['btn1_show'], FILTER_VALIDATE_BOOLEAN ) ): ?><a class="chp_ads_blocker_detector-action-btn-ok" onclick="reload()">Refresh</a><?php endif; ?></div></div>

<script>function reload(){window.location.href = window.location.href;}function hasClass(ele, cls) {return !!ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));}function addClass(ele, cls) {if (!hasClass(ele, cls)) ele.className += " " + cls;}function removeClass(ele, cls) {if (hasClass(ele, cls)) {var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');ele.className = ele.className.replace(reg, ' ');}}function chp_ads_blocker_detector(enable){var chpabd_overlay = document.getElementById('chp_ads_blocker-overlay');var chpabd_modal = document.getElementById('chp_ads_blocker-modal');if ( enable ) {if(chpabd_overlay !== null)addClass(chpabd_overlay, 'active');addClass(chpabd_modal, 'chp_ads_blocker_detector-show');removeClass(chpabd_modal, 'chp_ads_blocker_detector-hide');} else {if(chpabd_overlay !== null)removeClass(chpabd_overlay, 'active');removeClass(chpabd_modal, 'chp_ads_blocker_detector-show');addClass(chpabd_modal, 'chp_ads_blocker_detector-hide');}}</script>
        <?php endif; ?>
            <?php

        }



        /****************************************
        Adding CSS code to header
        *****************************************/  
        public function css( ){

            /****************************************
            Get user settings
            *****************************************/ 
            $settings = array(
                'enable' => empty(get_option( 'chp_adb_plugin_enable' )) ? true : get_option( 'chp_adb_plugin_enable' ),
                'title' => empty(get_option( 'chp_adb_plugin_title' )) ? 'Ads Blocker Detected!!!' : get_option( 'chp_adb_plugin_title' ),
                'content' => empty(get_option( 'chp_adb_plugin_content' )) ? '<p>We have detected that you are using extensions to block ads. Please support us by disabling these ads blocker.</p>' : get_option( 'chp_adb_plugin_content' ),
                'btn1_show' => empty(get_option( 'chp_adb_plugin_btn1_show' )) ? true : get_option( 'chp_adb_plugin_btn1_show' ),
                'btn2_show' => empty(get_option( 'chp_adb_plugin_btn2_show' )) ? false : get_option( 'chp_adb_plugin_btn2_show' )           
            );

            /****************************************
            Check Whether plugin is active
            *****************************************/ 
            if( filter_var( $settings['enable'], FILTER_VALIDATE_BOOLEAN ) ):

            ?>
<style>.chp_ads_blocker-overlay {position: fixed;background-color: #000;z-index: 1060;height: 100%;width: 100%;left: 0;right: 0;top: 0;bottom: 0;opacity: 0;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";-webkit-transition: opacity 0.45s cubic-bezier(0.23, 1, 0.32, 1);-o-transition: opacity 0.45s cubic-bezier(0.23, 1, 0.32, 1);transition: opacity 0.45s cubic-bezier(0.23, 1, 0.32, 1);}.chp_ads_blocker-overlay.active {opacity: 0.6;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)";}.chp_ads_blocker-overlay:not(.active),.chp_ads_blocker_detector:not(.chp_ads_blocker_detector-show){display:none;}.chp_ads_blocker_detector {color: #1b1919;position: fixed;z-index: 1061;border-radius: 2px;width: 400px;margin-left: -200px;background-color: #fff;-webkit-box-shadow: 0px 11px 15px -7px rgba(0, 0, 0, 0.2), 0px 24px 38px 3px rgba(0, 0, 0, 0.14), 0px 9px 46px 8px rgba(0, 0, 0, 0.12);box-shadow: 0px 11px 15px -7px rgba(0, 0, 0, 0.2), 0px 24px 38px 3px rgba(0, 0, 0, 0.14), 0px 9px 46px 8px rgba(0, 0, 0, 0.12);font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;left: 50%;top: 30%;font-size: 16px;text-align: center; }.chp_ads_blocker_detector-show {-webkit-animation: bounceIn .35s ease;-o-animation: bounceIn .35s ease;animation: bounceIn .35s ease;}.chp_ads_blocker_detector-hide {-webkit-animation: bounceOut .35s ease;-o-animation: bounceOut .35s ease;animation: bounceOut .35s ease;}.chp_ads_blocker_detector-title {padding: 24px 24px 20px;font-size: 20px;color: #1b1919;line-height: 1;padding-top: 0;}.chp_ads_blocker_detector-content {text-align: justify;padding: 24px;padding-top: 0;}.chp_ads_blocker_detector-message {margin: 0;padding: 0;color: #1b1919;font-size: 13px;line-height: 1.5;}.chp_ads_blocker_detector-action {padding: 8px;text-align: right;}.chp_ads_blocker_detector-action-btn-ok,.chp_ads_blocker_detector-action-btn-close {margin-left: 3px;cursor: pointer;height: 36px;line-height: 36px;min-width: 70px;text-align: center;outline: none !important;background-color: transparent;display: inline-block;border-radius: 2px;-webkit-tap-highlight-color: rgba(0, 0, 0, 0.12);-webkit-transition: all 0.45s cubic-bezier(0.23, 1, 0.32, 1);-o-transition: all 0.45s cubic-bezier(0.23, 1, 0.32, 1);transition: all 0.45s cubic-bezier(0.23, 1, 0.32, 1);}.chp_ads_blocker_detector-action-btn-ok{color:red;}.chp_ads_blocker_detector-action-btn-close{color:#1e8cbe;}.chp_ads_blocker_detector-action-btn-ok:hover,.chp_ads_blocker_detector-action-btn-close:hover {background-color: #ececec;}.chp_ads_blocker_detector-icon {width: 100px;padding: 1rem;}
</style>
        <?php endif; ?>
            <?php

        }

   }

    /****************************************
    Creating object of Class
    *****************************************/
    $chp_adsblocker_detector_main_obj = new chp_adsblocker_detector();


    /****************************************
    Default settings
    *****************************************/ 
    function chp_ads_block_defaults(){
        return (object) array(
            'enable' => true,
            'content' => '<p>We have detected that you are using extensions to block ads. Please support us by disabling these ads blocker.</p>',
            'title' => 'Ads Blocker Detected!!!',
            'btn1_show' => true,
            'btn2_show' => false
        );
    }

    /****************************************
    Run on installation hook
    *****************************************/ 
    register_activation_hook( __FILE__, 'chp_ads_block_detector_on_install' );

    /****************************************
    Check Installation Function Already Exists
    *****************************************/ 
    if( ! function_exists ( 'chp_ads_block_detector_on_install' ) ){

        function chp_ads_block_detector_on_install(  ){

            /****************************************
            Setup default settings
            *****************************************/
            $options = chp_ads_block_defaults();
            update_option( 'chp_adb_plugin_enable', $options->enable );
            update_option( 'chp_adb_plugin_title', $options->title );
            update_option( 'chp_adb_plugin_content', $options->content );
            update_option( 'chp_adb_plugin_btn1_show', $options->btn1_show );
            update_option( 'chp_adb_plugin_btn1_show', $options->btn2_show );

        }

    }

    /****************************************
    Run uninstall hook
    *****************************************/ 
    register_deactivation_hook( __FILE__, 'chp_ads_block_detector_on_uninstall' );

    /****************************************
    Check Uninstall Function Already Exists
    *****************************************/ 
    if( ! function_exists ( 'chp_ads_block_detector_on_uninstall' ) ){

        function chp_ads_block_detector_on_uninstall(  ){

            /****************************************
            Do Something
            *****************************************/
            $options = chp_ads_block_defaults();
            update_option( 'chp_adb_plugin_enable', $options->enable );
            update_option( 'chp_adb_plugin_title', $options->title );
            update_option( 'chp_adb_plugin_content', $options->content );
            update_option( 'chp_adb_plugin_btn1_show', $options->btn1_show );
            update_option( 'chp_adb_plugin_btn1_show', $options->btn2_show );

        }

    }

}

/****************************************
PLUGIN Code End
*****************************************/ 
