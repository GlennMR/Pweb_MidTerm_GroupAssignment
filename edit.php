<?php
$pageTitle = 'Edit Mahasiswa';
include('includes/header.php');

$id = mysqli_real_escape_string($conn, $_GET['id']);

if (isset($_POST['submit'])) {
    $nrp = mysqli_real_escape_string($conn, $_POST['NRP']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $asal = mysqli_real_escape_string($conn, $_POST['asal']);

    $query = "UPDATE mahasiswa SET NRP=?, nama=?, jurusan=?, asal=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nrp, $nama, $jurusan, $asal, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?status=edit_success');
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Fetch existing data
$query = "SELECT * FROM mahasiswa WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$edit_data = mysqli_fetch_assoc($result);

if (!$edit_data) {
    die('Data tidak ditemukan!');
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Edit Mahasiswa</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">NRP</label>
                        <input type="text" name="NRP" class="form-control" value="<?php echo htmlspecialchars($edit_data['NRP']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($edit_data['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="<?php echo htmlspecialchars($edit_data['jurusan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asal</label>
                        <textarea name="asal" class="form-control" required><?php echo htmlspecialchars($edit_data['asal']); ?></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>