<?php
$pageTitle = 'Detail Mahasiswa';
include('includes/header.php');

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// Fetch student data
$query = "SELECT * FROM mahasiswa WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

// If student not found, redirect
if (!$student) {
    header('Location: index.php');
    exit();
}
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Mahasiswa: <?php echo htmlspecialchars($student['nama']); ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">NRP</th>
                        <td><?php echo htmlspecialchars($student['NRP']); ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?php echo htmlspecialchars($student['nama']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td><?php echo htmlspecialchars($student['jurusan']); ?></td>
                    </tr>
                    <tr>
                        <th>Asal</th>
                        <td><?php echo htmlspecialchars($student['asal']); ?></td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td><?php echo htmlspecialchars($student['no_hp']); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo nl2br(htmlspecialchars($student['alamat'])); ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-end">
                <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
