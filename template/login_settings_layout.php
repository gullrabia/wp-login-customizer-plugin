<form action="options.php" method="post">
    <?php

    settings_fields("wp_login_page_settings_fields_group");

    do_settings_sections("wp-login-page-customizer");

    submit_button("Save Settings");



    ?>
</form>