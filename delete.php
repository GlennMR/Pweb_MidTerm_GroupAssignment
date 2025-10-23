<?php
include('includes/config.php');

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM mahasiswa WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?status=delete_success');
        exit();
    } else {
        header('Location: index.php?status=delete_error');
        exit();
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php');
    exit();
}
?>