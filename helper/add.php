<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("../connection.php");

    $book_title  = $_POST['book-title'];
    $author      = $_POST['author'];

    $query = "INSERT INTO books (title, author) VALUES (?, ?)";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "ss", $book_title, $author);

    $result['status']   = false;
    $result['message']  = 'Data gagal disimpan!';

    if (mysqli_stmt_execute($stmt)) {
        $result['status']   = true;
        $result['message']  = 'Data berhasil disimpan!';
    }

    echo json_encode($result);    
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
} else {
    http_response_code(405);
}
?>
