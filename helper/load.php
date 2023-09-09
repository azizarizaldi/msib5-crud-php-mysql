<?php
include_once("../connection.php");

$keywords   = isset($_GET['keywords']) ? $_GET['keywords'] : '';
$query      = "SELECT * FROM books";

if (!empty($keywords)) {
    $keywords = mysqli_real_escape_string($mysqli, $keywords);
    $query .= " WHERE title LIKE '%$keywords%' OR author LIKE '%$keywords%'";
}

$query_result   = mysqli_query($mysqli, $query);
$books_data     = array();

if ($query_result) {
    $get_books = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    if (!empty($get_books)) {
        $books_data = $get_books;
    }
}

$response = array('books_data' => $books_data);
header('Content-Type: application/json');
echo json_encode($response);
?>
