<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("../connection.php");

    $id         = isset($_POST['id']) ? $_POST['id'] : '';
    $book_title = isset($_POST['book-title']) ? $_POST['book-title'] : '';
    $author     = isset($_POST['author']) ? $_POST['author'] : '';

    $result['status']   = false;
    $result['message']  = 'Data gagal disimpan!';

    if(!empty($id)) {
        $query = "UPDATE books SET title = '$book_title', author = '$author' WHERE id = '$id'";
        $update = mysqli_query($mysqli, $query);

        if($update) {
            $result['status']   = true;
            $result['message']  = 'Data berhasil diperbarui!';                
        }
    } else {
        $query = "INSERT INTO books (title, author) VALUES (?, ?)";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ss", $book_title, $author);
        
        if (mysqli_stmt_execute($stmt)) {
            $result['status']   = true;
            $result['message']  = 'Data berhasil disimpan!';
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);    
    }

    echo json_encode($result);    
} else {
    http_response_code(405);
}
?>
