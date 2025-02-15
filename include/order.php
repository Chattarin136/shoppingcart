<?php

$query = mysqli_query($conn, "SELECT 
    o.id,
    o.fullname,
    o.email,
    o.tel,
    o.address,
    o.grand_total,
    (SELECT GROUP_CONCAT(CONCAT(p.product_name, ' (', od2.quantity, ')') SEPARATOR '<br/> ')  
     FROM order_details od2 
     JOIN products p ON od2.product_id = p.id 
     WHERE od2.order_id = o.id) as product_details
FROM orders o
GROUP BY o.id, o.fullname, o.email, o.tel, o.address, o.grand_total");
$rows = mysqli_num_rows($query);
$DATE_TIME = date('YmdHis');

if (isset($_POST['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Orders_' . $DATE_TIME . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($output, array('Id', 'Full Name', 'Email', 'Tel', 'Products', 'Total', 'Address'));

    $query = mysqli_query($conn, "SELECT 
    o.id,
    o.fullname,
    o.email,
    o.tel,
    o.address,
    o.grand_total,
    (SELECT GROUP_CONCAT(CONCAT(p.product_name, ' (', od2.quantity, ')') SEPARATOR ', ')  
     FROM order_details od2 
     JOIN products p ON od2.product_id = p.id 
     WHERE od2.order_id = o.id) as product_details
FROM orders o
GROUP BY o.id, o.fullname, o.email, o.tel, o.address, o.grand_total");

    while ($data = mysqli_fetch_array($query)) {
        fputcsv($output, array(
            $data['id'],
            $data['fullname'],
            $data['email'],
            sprintf(
                "%s-%s-%s",
                substr($data['tel'], 0, 3),
                substr($data['tel'], 3, 3),
                substr($data['tel'], 6)
            ),
            $data['product_details'],
            number_format($data['grand_total'], 2),
            $data['address']
        ));
    }

    fclose($output);
    exit;
}

?>