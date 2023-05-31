<?php
/**
* Plugin Name: Panel Plugin
* Plugin URI: https://www.aone.pl/
* Description: Plugin z Panelem Admina.
* Version: 1.0
* Author: aone.pl
* Author URI: https://aone.pl/
**/


$shortcode_name = get_option( 'panel_plugin_shortcode_name' );
    add_shortcode($shortcode_name, 'shortcode_render');

add_action( 'init',  function() {

});
function shortcode_render() {
    $shortcode_text = get_option( 'panel_plugin_shortcode_textarea' );
    return $shortcode_text;
}

function panel_plugin_menu() {
    add_menu_page(
        __( 'Panel Plugin', 'my-textdomain' ),
        __( 'Panel Plugin', 'my-textdomain' ),
        'manage_options',
        'panel-plugin-page',
        'panel_plugin_page_content',
        'dashicons-schedule',
        3
    );
}
function panel_plugin_page_content() {
    $value = get_option( 'panel_plugin_shortcode_name' );
    echo '
    <div class="wrap">
        <h1>'.get_admin_page_title().'</h1>
        <p>['.$value.']</p>
        '.do_shortcode( "[test]" ).'
        <form method="post" action="options.php">
    ';
            settings_fields( 'panel_plugin_settings' );
            do_settings_sections( 'panel_plugin' );
            submit_button();
    echo '
        </form>
    </div>
    ';
}
add_action( 'admin_menu', 'panel_plugin_menu' );



add_action( 'admin_init',  function() {
    $page_slug = 'panel_plugin';
    $page_section_id = 'panel_plugin_section_id';
    $option_group = 'panel_plugin_settings';

    add_settings_section(
        $page_section_id,
        '',
        '',
        $page_slug
    );

    add_settings_field(
       'panel_plugin_shortcode_name',
       __( 'Shortcode name', 'my-textdomain' ),
       'panel_plugin_shortcode_name_render',
       $page_slug,
       $page_section_id
    );
    register_setting( $option_group, 'panel_plugin_shortcode_name');

    add_settings_field(
           'panel_plugin_shortcode_textarea',
           __( 'Shortcode text', 'my-textdomain' ),
           'panel_plugin_shortcode_textarea_render',
           $page_slug,
           $page_section_id
    );
    register_setting( $option_group, 'panel_plugin_shortcode_textarea');
});


function panel_plugin_shortcode_name_render() {
    $value = get_option( 'panel_plugin_shortcode_name' );
    echo '<input type="text" id="panel_plugin_shortcode_name" name="panel_plugin_shortcode_name" value="'.$value.'" required />';
}

function panel_plugin_shortcode_textarea_render() {
    $value = get_option( 'panel_plugin_shortcode_textarea' );
    echo '<textarea id="panel_plugin_shortcode_textarea" name="panel_plugin_shortcode_textarea" required>'.$value.'</textarea>';
}