<?php

$sql = "SELECT od.order_id, od.product_id, p.profile_image, p.detail, od.product_name, od.price, 
    od.quantity, od.total FROM order_details od 
    JOIN products p ON p.id=od.product_id 
    WHERE od.order_id = " . $_GET['id'];
$result = mysqli_query($conn, $sql);

?>