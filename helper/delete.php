<?php
include_once("../connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if (empty($id)) {
        echo json_encode(array('status' => false, 'message' => 'ID buku tidak valid.'));
        exit;
    }
    
    $id     = mysqli_real_escape_string($mysqli, $id);
    $query  = "DELETE FROM books WHERE id = '$id'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        echo json_encode(array('status' => true, 'message' => 'Buku berhasil dihapus.'));
    } else {
        echo json_encode(array('status' => false, 'message' => 'Terjadi kesalahan saat menghapus buku.'));
    }
} else {
    echo json_encode(array('status' => false, 'message' => 'Metode permintaan tidak valid.'));
}
?>
