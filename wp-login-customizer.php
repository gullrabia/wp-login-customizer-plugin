<?php
/**
 * Plugin Name: WP Login Page Customizer
 * Description: Customize WordPress login page logo, text color, background color, form, button and checkbox colors.
 * Author: Rabia Gull
 * Version: 1.9
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*--------------------------------------------------------------
# Admin Menu
--------------------------------------------------------------*/
add_action( 'admin_menu', 'wp_login_page_add_menu' );
function wp_login_page_add_menu() {
    add_submenu_page(
        'options-general.php',
        'WP Login Page Customizer',
        'Login Page Customizer',
        'manage_options',
        'wp-login-page-customizer',
        'wp_login_page_settings_page'
    );
}

/*--------------------------------------------------------------
# Settings Page
--------------------------------------------------------------*/
function wp_login_page_settings_page() { ?>
    <div class="wrap">
        <h1>WP Login Page Customizer</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'wp_login_page_settings_group' );
            do_settings_sections( 'wp-login-page-customizer' );
            submit_button();
            ?>
        </form>
    </div>
<?php }

/*--------------------------------------------------------------
# Register Settings
--------------------------------------------------------------*/
add_action( 'admin_init', 'wp_login_page_register_settings' );
function wp_login_page_register_settings() {

    $fields = [
        'wp_login_page_text_color',
        'wp_login_page_background_color',
        'wp_login_page_form_color',
        'wp_login_page_button_color',
        'wp_login_page_button_text_color',
        'wp_login_page_checkbox_color'
    ];

    foreach ( $fields as $field ) {
        register_setting( 'wp_login_page_settings_group', $field, 'sanitize_text_field' );
    }

    register_setting( 'wp_login_page_settings_group', 'wp_login_page_logo', 'esc_url_raw' );

    add_settings_section(
        'wp_login_page_section',
        'Login Page Settings',
        null,
        'wp-login-page-customizer'
    );

    add_settings_field( 'wp_login_page_text_color', 'Text Color', 'wp_login_page_text_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_background_color', 'Page Background Color', 'wp_login_page_background_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_form_color', 'Form Background Color', 'wp_login_page_form_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_button_color', 'Button Background Color', 'wp_login_page_button_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_button_text_color', 'Button Text Color', 'wp_login_page_button_text_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_checkbox_color', 'Checkbox Color', 'wp_login_page_checkbox_color_field', 'wp-login-page-customizer', 'wp_login_page_section' );
    add_settings_field( 'wp_login_page_logo', 'Logo URL', 'wp_login_page_logo_field', 'wp-login-page-customizer', 'wp_login_page_section' );
}

/*--------------------------------------------------------------
# Fields
--------------------------------------------------------------*/
function wp_login_page_text_color_field() {
    echo '<input type="text" name="wp_login_page_text_color" value="' . esc_attr( get_option('wp_login_page_text_color') ) . '" placeholder="#ffffff">';
}
function wp_login_page_background_color_field() {
    echo '<input type="text" name="wp_login_page_background_color" value="' . esc_attr( get_option('wp_login_page_background_color') ) . '" placeholder="#000000">';
}
function wp_login_page_form_color_field() {
    echo '<input type="text" name="wp_login_page_form_color" value="' . esc_attr( get_option('wp_login_page_form_color') ) . '" placeholder="#111111">';
}
function wp_login_page_button_color_field() {
    echo '<input type="text" name="wp_login_page_button_color" value="' . esc_attr( get_option('wp_login_page_button_color') ) . '" placeholder="#2271b1">';
}
function wp_login_page_button_text_color_field() {
    echo '<input type="text" name="wp_login_page_button_text_color" value="' . esc_attr( get_option('wp_login_page_button_text_color') ) . '" placeholder="#ffffff">';
}
function wp_login_page_checkbox_color_field() {
    echo '<input type="text" name="wp_login_page_checkbox_color" value="' . esc_attr( get_option('wp_login_page_checkbox_color') ) . '" placeholder="#2271b1">';
}
function wp_login_page_logo_field() {
    echo '<input type="text" name="wp_login_page_logo" value="' . esc_attr( get_option('wp_login_page_logo') ) . '" placeholder="Logo URL">';
}

/*--------------------------------------------------------------
# Apply Styles (LOGIN PAGE)
--------------------------------------------------------------*/
add_action( 'login_enqueue_scripts', 'wp_login_page_apply_styles' );
function wp_login_page_apply_styles() {

    $text     = get_option( 'wp_login_page_text_color' );
    $bg       = get_option( 'wp_login_page_background_color' );
    $form     = get_option( 'wp_login_page_form_color' );
    $btn      = get_option( 'wp_login_page_button_color' );
    $btn_text = get_option( 'wp_login_page_button_text_color' );
    $checkbox = get_option( 'wp_login_page_checkbox_color' );
    $logo     = get_option( 'wp_login_page_logo' );
    ?>

<style>

<?php if ( $bg ) : ?>
body.login { background-color: <?php echo esc_attr( $bg ); ?>; }
<?php endif; ?>

<?php if ( $form ) : ?>
body.login #login form { background-color: <?php echo esc_attr( $form ); ?>; }
<?php endif; ?>

<?php if ( $text ) : ?>
body.login,
body.login label,
body.login #login form input,
body.login #login form input::placeholder,
body.login p#nav a,
body.login p#backtoblog a {
    color: <?php echo esc_attr( $text ); ?>;
}
<?php endif; ?>

<?php if ( $btn ) : ?>
body.login .button-primary {
    background-color: <?php echo esc_attr( $btn ); ?>;
    border-color: <?php echo esc_attr( $btn ); ?>;
}
<?php endif; ?>

<?php if ( $btn_text ) : ?>
body.login .button-primary {
    color: <?php echo esc_attr( $btn_text ); ?>;
}
<?php endif; ?>

<?php if ( $checkbox ) : ?>
body.login input[type="checkbox"]:checked::before {
    color: <?php echo esc_attr( $checkbox ); ?>;
}
<?php endif; ?>

<?php if ( $logo ) : ?>
body.login h1 a {
    background-image: url('<?php echo esc_url( $logo ); ?>');
    background-size: contain;
    background-repeat: no-repeat;
    width: 100%;
}
<?php endif; ?>

</style>
<?php
}
