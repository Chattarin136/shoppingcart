<?php

// Get all categories for the filter
$categories_sql = "SELECT * FROM categories ORDER BY id ASC";
$categories_query = mysqli_query($conn, $categories_sql);

// Get products with category filter
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sql = "SELECT p.*, c.display_name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category = c.name 
        WHERE 1=1";

if ($category != 'all') {
    $sql .= " AND p.category = '" . mysqli_real_escape_string($conn, $category) . "'";
}

$sql .= " ORDER BY p.id DESC";
$query = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($query);

?>