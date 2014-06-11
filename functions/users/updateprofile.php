<?php
require_once('../../functions/connect.php');
require_once('../../classes/Users.php');

$password = "";
$pattern = '/(\s)/i';
if(preg_replace($pattern, '', $_POST['profile'][4]) == "" && preg_replace($pattern, '', $_POST['profile'][5]) == ""){
	$password = 'NULL';
}
else {
	$password = $_POST['profile'][4];
}

$create = new Users(
						$_POST['profile'][0],
						$password,
						$_POST['profile'][1],
						$_POST['profile'][2],
						NULL,
                        NULL,
						$_POST['profile'][3]
                    );

$data = $create->update($_COOKIE['username']);

header("content-type: application/json");
print(json_encode($data));
?>
