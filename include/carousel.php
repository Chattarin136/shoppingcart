<?php

$query = mysqli_query($conn, "SELECT * FROM carousel ORDER BY id DESC");
$rows = mysqli_num_rows($query);
?>