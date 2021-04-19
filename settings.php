<div class="chp_ads_blocker_detector chp_ads_blocker_detector-about-wrap">
    <div class="chp_ads_blocker_detector-top-section">
        <img class="chp_ads_blocker_detector-logo" src="<?php echo CHP_ADSB_URL . 'img/icon.png'; ?>">
        <div class="chp_ads_blocker_detector-content">
            <h1>CHP ADS Block Detector!</h1>
            <span>#The Best ads block detector wordpress plugin</span>
        </div>
        <div class="chp_ads_blocker_detector-version">Version: <b><?php echo CHP_ADSB_VERSION; ?></b>
        </div>
    </div>
    <div class="chp_ads_blocker_detector-nav-tab-wrapper">
        <a target="_blank" href="https://codehelppro.com/product/wordpress/plugin/chp-ads-block-detector/"
            class="chp_ads_blocker_detector-nav-tab pro">Check Pro Version</a>
    </div>
</div>

<div class=" chp_ads_blocker_detector-content-setion">

    <div style="display: flex;">
        <table class="table" id="chp_ads_block_table">
            <thead>
                <tr>
                    <th colspan="2">Settings</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Enable
                    </td>
                    <td>
                        <label class="checkbox_container">
                            <input type="checkbox"
                                <?php echo filter_var(get_option( 'chp_adb_plugin_enable' ), FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?>
                                name="enable" class="chpabd_form_settings include">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        Title
                    </td>
                    <td>
                        <input type="text"
                            value="<?php echo empty(get_option( 'chp_adb_plugin_title' )) ? null : get_option( 'chp_adb_plugin_title' ); ?>"
                            class="chpabd_form_settings include" name="title" placeholder="Title">
                    </td>
                </tr>
                <tr>
                    <td>
                        Content
                    </td>
                    <td>
                        <?php echo wp_editor( get_option( 'chp_adb_plugin_content' ) , 'chp_ads_content', array(
                                    'tinymce'       => array(
                                        'toolbar1'      => 'bold,italic,underline,link,unlink,undo,redo',
                                        'toolbar2'      => '',
                                        'toolbar3'      => '',
                                    ),
                                    'media_buttons' => false,
                                    'textarea_rows' => 4,
                                ) ); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Width (in %)
                    </td>
                    <td>
                        <input type="number" value="<?php echo get_option( 'chp_adb_plugin_width' ); ?>"
                            class="chpabd_form_settings include" name="width" placeholder="Width in pixel">
                    </td>
                </tr>
                <tr>
                    <td>
                        Position (in %)
                    </td>
                    <td>
                        <label>From Left : </label>
                        <input type="number" value="<?php echo get_option( 'chp_adb_plugin_from_left' ); ?>"
                            style="width:20%; display:inline-block;margin-right:10px;"
                            class="chpabd_form_settings include" name="left" placeholder="From Left">

                        <label>From Top : </label>
                        <input type="number" value="<?php echo get_option( 'chp_adb_plugin_from_right' ); ?>"
                            style="width:20%; display:inline-block;margin-right:10px;"
                            class="chpabd_form_settings include" name="top" placeholder="From Top">
                    </td>
                </tr>

                <tr>
                    <td>
                        Show Refesh Button
                    </td>
                    <td>
                        <label class="checkbox_container">
                            <input type="checkbox"
                                <?php echo filter_var(get_option( 'chp_adb_plugin_btn1_show' ), FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?>
                                name="btn1_show" class="chpabd_form_settings include">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>
                        Refesh Button ( Text )
                    </td>
                    <td>
                        <input type="text" value="<?php echo get_option( 'chp_adb_plugin_btn1_text' ); ?>"
                            class="chpabd_form_settings include" name="btn1_text" placeholder="Button Text">
                    </td>
                </tr>

                <tr>
                    <td>
                        Show Close Button
                    </td>
                    <td>
                        <label class="checkbox_container">
                            <input type="checkbox"
                                <?php echo filter_var(get_option( 'chp_adb_plugin_btn2_show' ), FILTER_VALIDATE_BOOLEAN) ? 'checked' : null; ?>
                                name="btn2_show" class="chpabd_form_settings include">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>
                        Close Button ( Text )
                    </td>
                    <td>
                        <input type="text" value="<?php echo get_option( 'chp_adb_plugin_btn2_text' ); ?>"
                            class="chpabd_form_settings include" name="btn2_text" placeholder="Button Text">
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table" id="chp_ads_block_table" style="width:23%;margin-left:2%;">
            <thead>
                <tr>
                    <th>Pro Version Capability</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>
                    <img src="<?php echo CHP_ADSB_URL . 'img/banner.png'; ?>" style="width:109.5%;margin:-10px;height:100%;">
                </td></tr>
                <tr>
                    <td>Button Text Customizable</td>
                </tr>
                <tr>
                    <td>Overlay Effect Customizable</td>
                </tr>
                <tr>
                    <td>Theme</td>
                </tr>
                <tr>
                    <td>Control Body Scroll</td>
                </tr>
                <tr>
                    <td>Disable plugin for Pages</td>
                </tr>
                <tr>
                    <td>Disable for Woocommerce Pages</td>
                </tr>
                <tr>
                    <td><strong>And Many More...</strong></td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th style="background:#ff0000;text-align:center;"><a target="_blank" href="https://codehelppro.com/product/wordpress/plugin/chp-ads-block-detector/" style="    padding: 0;border: none;outline: none;box-shadow: none;background: transparent;color: #fff;text-align: center;text-decoration:none;">Check Pro Version</a></th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="chp_ads_button_row">
        <button class="button button-primary" type="button" id="chp_ads_save_settings">Save Changes</button>
        <button class="button button-secondary" type="button" id="chp_ads_reset_settings">Reset Changes</button>
    </div>
</div>