<?php
require_once('../../functions/connect.php');
require_once('../../classes/Orders.php');

$create = new Orders(
						NULL,
						$_POST['keyword'],
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						NULL,
						NULL
                    );

$return = $create->get_unique_customer($_POST['fields'][6]);

header("content-type: application/json");
print(json_encode($return));
?>
