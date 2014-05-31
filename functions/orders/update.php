<?php
require_once('../../functions/connect.php');
require_once('../../classes/Orders.php');

$date = explode(' - ',$_POST['fields'][5]);

$_POST['fields'][9] = $_POST['fields'][8];
$_POST['fields'][8] = $_POST['fields'][7];
$_POST['fields'][7] = $_POST['fields'][6];

$_POST['fields'][5] = $date[0];
$_POST['fields'][6] = $date[1];

$create = new Orders(
						$_POST['fields'][0],
						$_POST['fields'][1],
						$_POST['fields'][2],
						$_POST['fields'][3],
						$_POST['fields'][4],
						$_POST['fields'][5],
						$_POST['fields'][6],
						NULL,
						$_COOKIE['username'],
						NULL,
						$_POST['fields'][7],
						$_POST['fields'][8]
                    );

$return = $create->update($_POST['fields'][9]);

header("content-type: application/json");
print(json_encode($return));
?>
