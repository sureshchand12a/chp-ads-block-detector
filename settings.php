<div class="chp_ads_blocker_detector chp_ads_blocker_detector-about-wrap"> <div class="chp_ads_blocker_detector-top-section"> <img class="chp_ads_blocker_detector-logo" src="<?php echo CHP_ADSB_URL . 'img/icon.png'; ?>"> <div class="chp_ads_blocker_detector-content"> <h1>CHP ADS Block Detector!</h1> <span>#The Best ads block detector wordpress plugin</span> </div> <div class="chp_ads_blocker_detector-version">Version: <b><?php echo CHP_ADSB_VERSION; ?></b> </div> </div> <div class="chp_ads_blocker_detector-nav-tab-wrapper"> <a href="https://codehelppro.com/product/chp-ads-block-detector/" target="_blank" class="chp_ads_blocker_detector-nav-tab">Buy PRO Version</a> </div></div><div class="chp_ads_blocker_detector chp_ads_blocker_detector-about-wrap"> </div><?php $settings = array(
    'enable' => empty(get_option( 'chp_adb_plugin_enable' )) ? true : sanitize_text_field ( get_option( 'chp_adb_plugin_enable' ) ),
    'title' => empty(get_option( 'chp_adb_plugin_title' )) ? 'Ads Blocker Detected!!!' : sanitize_text_field( get_option( 'chp_adb_plugin_title' ) ),
    'content' => empty(get_option( 'chp_adb_plugin_content' )) ? '<p>We have detected that you are using extensions to block ads. Please support us by disabling these ads blocker.</p>' : wp_kses_post( get_option( 'chp_adb_plugin_content' ) ),
    'btn1_show' => empty(get_option( 'chp_adb_plugin_btn1_show' )) ? true : sanitize_text_field( get_option( 'chp_adb_plugin_btn1_show' ) ),
    'btn2_show' => empty(get_option( 'chp_adb_plugin_btn2_show' )) ? false : sanitize_text_field( get_option( 'chp_adb_plugin_btn2_show' )  )         
); ?><div class=" chp_ads_blocker_detector-content-setion"> <table class="table" id="chp_ads_block_table"> <thead> <tr> <th colspan="2">Settings</th> </tr> </thead> <tbody> <tr> <td> Enable </td> <td> <label class="checkbox_container"> <input type="checkbox" <?php echo filter_var($settings['enable'], FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?> name="enable" class="chpabd_form_settings include"> <span class="checkmark"></span> </label> </td> </tr> <tr> <td> Title </td> <td> <input type="text" value="<?php echo $settings['title']; ?>" class="chpabd_form_settings include" name="title" placeholder="Title"> </td> </tr> <tr> <td> Content </td> <td> <?php echo wp_editor( $settings['content'] , 'chp_ads_content', array( 'tinymce' => array( 'toolbar1' => 'bold,italic,underline,link,unlink,undo,redo', 'toolbar2' => '', 'toolbar3' => '', ), 'media_buttons' => false, 'textarea_rows' => 4, ) ); ?> </td> </tr> <tr> <td> Show Refesh Button </td> <td> <label class="checkbox_container"> <input type="checkbox" <?php echo filter_var($settings['btn1_show'], FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?> name="btn1_show" class="chpabd_form_settings include"> <span class="checkmark"></span> </label> </td> </tr> <tr> <td> Show Close Button </td> <td> <label class="checkbox_container"> <input type="checkbox" <?php echo filter_var($settings['btn2_show'], FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?> name="btn2_show" class="chpabd_form_settings include"> <span class="checkmark"></span> </label> </td> </tr> </tbody> </table> <div class="chp_ads_button_row"> <button class="button button-primary" type="button" id="chp_ads_save_settings">Save Changes</button> <button class="button button-secondary" type="button" id="chp_ads_reset_settings">Reset Changes</button> </div> </div>
