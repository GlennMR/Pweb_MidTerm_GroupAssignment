<?php
$pageTitle = 'Tambah Mahasiswa';
include('includes/header.php');

if (isset($_POST['submit'])) {
    $nrp = mysqli_real_escape_string($conn, $_POST['NRP']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $asal = mysqli_real_escape_string($conn, $_POST['asal']);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO mahasiswa (NRP, nama, jurusan, asal, created_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssi', $nrp, $nama, $jurusan, $asal, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?status=add_success');
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Tambah Mahasiswa</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">NRP</label>
                        <input type="text" name="NRP" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asal</label>
                        <textarea name="asal" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>