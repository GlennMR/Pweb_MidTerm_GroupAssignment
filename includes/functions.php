<?php
// Security functions
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Validation functions
function validate_nrp($nrp) {
    return preg_match('/^[0-9]{10}$/', $nrp);
}

function validate_nama($nama) {
    return preg_match('/^[a-zA-Z\s]{2,100}$/', $nama);
}

// Database functions
function get_mahasiswa($id = null) {
    global $conn;
    if ($id) {
        $id = clean_input($id);
        $query = "SELECT * FROM mahasiswa WHERE id = '$id'";
        return mysqli_query($conn, $query);
    }
    return mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY NRP");
}

function add_mahasiswa($data) {
    global $conn;
    $nrp = clean_input($data['NRP']);
    $nama = clean_input($data['nama']);
    $jurusan = clean_input($data['jurusan']);
    $asal = clean_input($data['asal']);
    $user_id = $_SESSION['user_id'];

    if (!validate_nrp($nrp)) {
        return ["error" => "NRP harus 10 digit angka"];
    }

    if (!validate_nama($nama)) {
        return ["error" => "Nama hanya boleh huruf dan spasi, minimal 2 karakter"];
    }

    $query = "INSERT INTO mahasiswa (NRP, nama, jurusan, asal, created_by) 
              VALUES ('$nrp', '$nama', '$jurusan', '$asal', '$user_id')";
    
    if (mysqli_query($conn, $query)) {
        return ["success" => true];
    }
    return ["error" => mysqli_error($conn)];
}

// Session functions
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}