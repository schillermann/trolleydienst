<?php
define('APPLICATION_NAME', 'Öffentliches Zeugnisgeben');
define('CONGREGATION_NAME', 'Installation');
define('REQUIRE_INPUT_FIELDS', 9);

spl_autoload_register();

if(Tables\Database::exists_database()) {
    header('location: /');
    return;
}


$placeholder = array();

if(isset($_POST['install'])) {
    $filter_post_input = include 'modules/filter_post_input.php';
    $input_list = $filter_post_input();

    if($_POST['password'] != $_POST['password_repeat']) {
        $placeholder['message']['error'] = 'Passwörter stimmen nicht überein!';
    }
    else if(count($input_list) === REQUIRE_INPUT_FIELDS) {

        $user = new Models\User(
            1,
            $input_list['firstname'],
            $input_list['lastname'],
            $input_list['email'],
            $input_list['username'],
            $_POST['password'],
            true
        );

        $pdo = Tables\Database::get_connection();
        $write_config_file = include 'modules/write_config_file.php';
        $config = array(
            'EMAIL_ADDRESS_FROM' => $input_list['email_address_from'],
            'EMAIL_ADDRESS_REPLY' => $input_list['email_address_reply'],
            'CONGREGATION_NAME' => $input_list['congregation_name'],
            'APPLICATION_NAME' => $input_list['application_name'],
            'TEAM_NAME' => $input_list['team_name'],
            'UPLOAD_SIZE_MAX_IN_MEGABYTE' => 5
        );

        if(
            Tables\Database::create_tables($pdo) &&
            Tables\Users::insert($pdo, $user) &&
            $write_config_file($config)
        ) {
            header('location: /');
            return;
        }

        $placeholder['message']['error'] = 'Bei der Installation ist ein Fehler aufgetreten!';
    }
}

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);