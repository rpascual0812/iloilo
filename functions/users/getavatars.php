<?php
require_once('../../functions/connect.php');
require_once('../../classes/Avatars.php');

$class = new Avatars(
						NULL,
                        NULL
                    );

$data = $class->get();

header("content-type: application/json");
print(json_encode($data));
?>
