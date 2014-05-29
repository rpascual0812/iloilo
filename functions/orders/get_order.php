<?php
require_once('../../functions/connect.php');
require_once('../../classes/Orders.php');

$create = new Orders(
						$_POST['pk'],
						NULL,
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

$return = $create->get_one();

header("content-type: application/json");
print(json_encode($return));
?>
