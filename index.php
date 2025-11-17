<?php
    include 'db.php';
    session_start();
    if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $filterKategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $kategoriList = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

    $where = [];

    if($filterKategori != '') {
        $where[] = "barang.kategori_id =  '" . mysqli_escape_string($conn, $filterKategori) . "'";
    }
    

    if($search != '') {
        $where[] = "barang.nama_barang LIKE '%" . mysqli_escape_string($conn, $search) . "%'";
    }

     $whereSQL = '';
    if(count($where) > 0) {
        $whereSQL = "WHERE " . implode(' AND ', $where);
    }

    $totalDataQuery = "SELECT COUNT(*) AS total FROM barang $whereSQL";
    $totalDataResult = mysqli_query($conn, $totalDataQuery);
    $totalDataRow = mysqli_fetch_assoc($totalDataResult);
    $totalData =  $totalDataRow['total'];
    $totalPage = ceil($totalData / $limit);

    

    $sql = "SELECT barang.*,
            kategori.nama_kategori FROM barang
            INNER JOIN kategori ON
            barang.kategori_id = kategori.id
            $whereSQL
            ORDER BY barang.id ASC LIMIT $limit OFFSET $offset";

    $query = mysqli_query($conn, $sql);

    if(!$query) {
        $error_message = mysqli_error($conn);
        die('<strong>Terjadi Kesalahan Saat Menghubungkan Tabel: </strong>
            <strong>'. $error_message .'</strong>');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Inventaris Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Poppins, sans-serif;
            background: #fff;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #1a1f27;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            transition: .4s;
            padding: 25px;
            box-shadow: 0 8 20px rgba(0,0,0,0.25);
            z-index: 999;
        }

        .sidebar .logo {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            color: #1db954;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            text-decoration: none;
            background: rgba(255,255,255,0.05);
            color: #dce3ce;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,.015);
            color: #1db954;
            transform: translateX(5px);
        }

        .main-container {
            margin-left: 260px;
            padding: 40px 20px;
        }

        .table-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4 20px rgba(0,0,0,0.5);
        }

        .judul {
            width: 100%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
            border-radius: 8px;
            padding: 20px 10px;
            text-align: center;
            font-weight: 600;
            font-size: 20px;
            color: #1db954;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-5px);
        }



        input[type=text], select {
            transition: all 0.3s ease;
        }

        input[type=text]:hover, select:hover {
            border: 1px solid #1db954;
        }

        #popupDelete {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: rgba(0,0,0,0.25);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        #popupDelete .popup-content-delete {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            cursor: pointer;
            width: 320px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease;
        }

        .delete-container {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 1;
                transform: scale(0.8);
            }
            to {
                opacity: 0;
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="sidebar">
        <div class="logo">INVENTARIS</div>
        <a href="index.php">Manajemen Inventaris</a>
        <a href="kategori.php">Manajemen Kategori</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-container">
        <div class="judul mb-4">MANAJEMEN INVENTARIS BARANG</div> 

        <form action="" class="row mb-3" id="filterForm">
            <div class="col-md-4">
                <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari Nama Barang...." value="<?= htmlentities($search) ?>">
            </div>

            <div class="col-md-4">
                <select name="kategori" id="kategori" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Semua Kategori --</option>
                    <?php while($k = mysqli_fetch_assoc($kategoriList)): ?>
                        <option value="<?= $k['id'] ?>"<?= $filterKategori == $k['id'] ? 'selected' : '' ?>>
                            <?= $k['nama_kategori'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-4 text-align-end">
                <a href="tambah.php" class="btn btn-success btn-add">Tambah Data</a>
            </div>
        </form>
        <div class="table-container">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Barang</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        while($b = mysqli_fetch_assoc($query)): 
                     ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $b['nama_barang']  ?></td>
                        <td><?= $b['nama_kategori'] ?></td>
                        <td><?= number_format($b['stok'],0 ,',' , '.')?></td>
                        <td>Rp. <?= number_format($b['harga'],0 ,',' , '.') ?></td>
                        <td><?= $b['tanggal_masuk'] ?></td>
                        <td>
                            <a href="edit-data.php?&id=<?= $b['id'] ?>" class="btn btn-success btn-sm">Edit</a> 
                            <a href="#" class="btn btn-danger btn-sm" onclick="ConfirmDelete('hapus-data.php?id=<?= $b['id']; ?>')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&kategori=<?= $filterKategori ?>" class="page-link">Previous</a>
                </li>

                <?php for($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item" <?= ($page == $i) ? 'active' : '' ?>>
                    <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&kategori=<?= $filterKategori ?>" class="page-link"><?= $i ?></a>
                </li>
                <?php endfor ?>

                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : 'active' ?>">
                    <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&kategori=<?= $filterKategori ?>" class="page-link">Next</a>
                </li>
            </ul>
        </nav>

        <div class="popup" id="popupDelete">
            <div class="popup-content-delete">
                <h3>Konfirmasi Hapus</h3>
                <p>Apa Anda Yakin Ingin Menghapus Data Ini?</p>

                <div class="delete-container">
                    <button id="btnCancel" class="btn btn-secondary">Batal</button>
                    <button id="btnConfirmDelete" class="btn btn-danger">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let DeleteURL = "";

        function ConfirmDelete(url) {
            DeleteURL = url;
            document.getElementById("popupDelete").style.display = "flex";
        }

        document.getElementById("btnCancel").addEventListener('click', function() {
            document.getElementById("popupDelete").style.display = "none";
        })

        document.getElementById("btnConfirmDelete").addEventListener('click', function() {
            window.location.href = DeleteURL;
        })

    </script>
</body>
</html>