<?php
require_once('../../functions/connect.php');
require_once('../../classes/Orders.php');

$date = explode(' - ',$_POST['date']);

$create = new Orders(
						NULL,
						NULL,
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

$return = $create->report($date[0],$date[1]);

header("content-type: application/json");
print(json_encode($return));
?>
