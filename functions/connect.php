<?php
if($_SERVER['HTTP_HOST'] == "localhost"){
	pg_connect("host=localhost port=5432 dbname=photobooth user=photobooth password=photobooth")
	or die('Unable to connect to database');
}
else{
    pg_connect("host=ec2-54-83-33-14.compute-1.amazonaws.com port=5432 dbname=d33di4fo1astkk user=zezrzwlldxwnpd password=Mlg2l9Xi62x8RJ9tvQwG-wUEhs sslmode=require options='--client_encoding=UTF8'") 
    or die('Could not connect: ' . pg_last_error());
}