<?php
require_once('../../functions/connect.php');
require_once('../../classes/Users.php');

$username = $_POST['username'];
$password = $_POST['password'];
$rememberme = $_POST['rememberme'];

$create = new Users(
						$username,
						$password,
						NULL,
						NULL,
						NULL,
						NULL,
                        NULL
                    );

$data = $create->login();
print_r($data);
if(count($data['data'])>0){
	setcookie(
            'username',
            $username,
            time() + (365 * 24 * 60 * 60),
            '/'
        );

	setcookie(
            'remember',
            $rememberme,
            time() + (365 * 24 * 60 * 60),
            '/'
        );
}

header("content-type: application/json");
print(json_encode($data));
?>
