<?php
// development
$base_url = 'http://localhost/shoppingcart';

// production
// $base_url = 'https://shoppingcart.mydevhub.dev/shoppingcart';

// var database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'root123456';
$db_name = 'shoppingcart';

// conenct db
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die('connection failed');