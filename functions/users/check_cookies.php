<?php
$data = array(
				'username' => $_COOKIE['username'],
				'remember' => $_COOKIE['remember']
				);

header("content-type: application/json");
print(json_encode($data));
?>