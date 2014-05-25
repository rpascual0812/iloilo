<?php
require_once('../../functions/connect.php');
require_once('../../classes/Orders.php');

$date = explode(' - ',$_POST['fields'][4]);

$_POST['fields'][6] = $_POST['fields'][5];
$_POST['fields'][4] = $date[0];
$_POST['fields'][5] = $date[1];

$create = new Orders(
						NULL,
						$_POST['fields'][0],
						$_POST['fields'][1],
						$_POST['fields'][2],
						$_POST['fields'][3],
						$_POST['fields'][4],
						$_POST['fields'][5],
						NULL,
						'rpascual0812',
						NULL,
						NULL
                    );

$return = $create->create($_POST['fields'][6]);

header("content-type: application/json");
print(json_encode($return));
?>
