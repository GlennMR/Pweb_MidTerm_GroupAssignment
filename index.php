<?php
$pageTitle = 'Dashboard';
include('includes/header.php');

$notification = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'add_success':
            $notification = '<div class="alert alert-success">Data mahasiswa berhasil ditambahkan.</div>';
            break;
        case 'edit_success':
            $notification = '<div class="alert alert-success">Data mahasiswa berhasil diperbarui.</div>';
            break;
        case 'delete_success':
            $notification = '<div class="alert alert-success">Data mahasiswa berhasil dihapus.</div>';
            break;
        case 'delete_error':
            $notification = '<div class="alert alert-danger">Gagal menghapus data mahasiswa.</div>';
            break;
    }
}

// Sorting logic
$sort_by = isset($_GET['sort']) && in_array($_GET['sort'], ['NRP', 'nama', 'jurusan', 'asal']) ? $_GET['sort'] : 'NRP';
$order = isset($_GET['order']) && in_array(strtoupper($_GET['order']), ['ASC', 'DESC']) ? strtoupper($_GET['order']) : 'ASC';

// Search logic
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM mahasiswa";
$count_query_base = "SELECT COUNT(*) as total FROM mahasiswa";

if (!empty($search)) {
    $query .= " WHERE NRP LIKE ? OR nama LIKE ?";
    $count_query_base .= " WHERE NRP LIKE ? OR nama LIKE ?";
}

// Pagination logic
$records_per_page = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get total number of records for pagination
$count_stmt = mysqli_prepare($conn, $count_query_base);
if (!empty($search)) {
    $searchTerm = "%{$search}%";
    mysqli_stmt_bind_param($count_stmt, 'ss', $searchTerm, $searchTerm);
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $records_per_page);


$query .= " ORDER BY $sort_by $order LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $query);

if (!empty($search)) {
    $searchTerm = "%{$search}%";
    mysqli_stmt_bind_param($stmt, 'ssii', $searchTerm, $searchTerm, $offset, $records_per_page);
} else {
    mysqli_stmt_bind_param($stmt, 'ii', $offset, $records_per_page);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<?php echo $notification; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Mahasiswa</h5>
                <a href="add.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Mahasiswa</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <form action="index.php" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan Nama atau NRP..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-success"><i class="bi bi-search"></i> Cari</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <?php
                                function print_sortable_header($column, $display_text, $current_sort, $current_order, $current_search) {
                                    $order = ($current_sort == $column && $current_order == 'ASC') ? 'DESC' : 'ASC';
                                    $arrow = '';
                                    if ($current_sort == $column) {
                                        $arrow = ($current_order == 'ASC') ? ' <i class="bi bi-caret-up-fill"></i>' : ' <i class="bi bi-caret-down-fill"></i>';
                                    }
                                    $search_param = !empty($current_search) ? '&search=' . urlencode($current_search) : '';
                                    echo '<th><a href="?sort=' . $column . '&order=' . $order . $search_param . '" class="text-white text-decoration-none">' . $display_text . $arrow . '</a></th>';
                                }
                                print_sortable_header('NRP', 'NRP', $sort_by, $order, $search);
                                print_sortable_header('nama', 'Nama', $sort_by, $order, $search);
                                print_sortable_header('jurusan', 'Jurusan', $sort_by, $order, $search);
                                print_sortable_header('asal', 'Asal', $sort_by, $order, $search);
                                ?>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['NRP']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['asal']); ?></td>
                                    <td>
                                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> View</a>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                 <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1) : ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $order; ?>&search=<?php echo urlencode($search); ?>">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $order; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages) : ?>
                            <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $order; ?>&search=<?php echo urlencode($search); ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>