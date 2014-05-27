<?php
require_once('../../functions/connect.php');
require_once('../../classes/Users.php');

$create = new Users(
						$_COOKIE['username'],
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
                        NULL
                    );

$data = $create->userinfo();

header("content-type: application/json");
print(json_encode($data));
?>
