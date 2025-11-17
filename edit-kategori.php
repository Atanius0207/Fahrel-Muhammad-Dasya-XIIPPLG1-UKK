<?php
    require "db.php";

    $id = $_GET['id'] ?? null;

    if(!$id) {
        $error_message = mysqli_error($conn);
        die('<strong>Terjadi Kesalahan Saat Mencari ID: </strong>
            <strong>'. $error_message .'</strong>');
    }

    $sql = "SELECT * FROM kategori WHERE id = '$id'";
    $kategori = mysqli_query($conn, $sql);

    if(!$kategori || mysqli_num_rows($kategori) < 0) {
        $error_message = mysqli_error($conn);
        die('<strong>Terjadi Kesalahan Saat Menghubungkan Tabel: </strong>
            <strong>'. $error_message .'</strong>');
    }
    
    $k = mysqli_fetch_assoc($kategori);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #fff;
            padding: 30px;
        }

       
        .form-container {
            box-shadow: 0 0 14px rgba(0,0,0,0.1);
            padding: 30px;
            border-radius: 8px;
        }

        input[type=text],
        input[type=date],
        select {
            transition: all 0.3s ease;
        }

        input[type=text]:hover,
        input[type=date]:hover,
        select:hover {
            border: 1px solid #17a348;
        }

        .form-control:focus, .form-select:focus {
            border-color: #17a348;
            box-shadow: 0 0 5px rgba(13,110,253,0.4);
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins';
        }

        .popup-content {
            background: #fff;
            padding: 25px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.3s ease;
            width: 320px;
        }

        .popup-content h3 {
            margin-bottom: 10px;
            color: #17a348;
        }

        .popup-content p {
            color: #333;
            font-size: 15px;
        }

        .popup-content button {
            margin-top: 15px;
            background: #1db954;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2 ease;
        }

        .popup-content button:hover {
            background-color: #17a348;
            transform: scale(1.05);
        }

        .popup-content i {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .icon-warning {
            color: #f39c12;
        }

        .icon-success {
            color: #17a348;
        }

        .icon-error {
            color: #e74c3c;
        }

        #popup-close {
            background-color: #17a348;
            color: #fff;
            border: none;
            padding: 8px 18px;
            margin-top: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        #popup-close:hover {
            background-color: #1db954;
            transform: scale(1.05);
        }

        .popup-show {
            display: flex;
            opacity: 1;
        }

        .popup.hide {
            opacity: 0;
            transition: opacity 0.6s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card-header bg-success text-white text-center">
            <h2>Tambah Data Inventaris</h2>
        </div>
        <div>
            <form class="form-container" action="edit-kategori-proses.php" id="formBarang" method="POST">
            <input type="hidden" name="id_kategori" value="<?= $k['id'] ?>">
            <div class="mb-3">
                <label  class="form-label">Nama Kategori: </label>
                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="<?= $k['nama_kategori'] ?>">
            </div>
            <button type="submit" name="update" class="btn btn-success w-100">Update Data</button>
            </form>
        </div>

        <div class="popup" id="popup">
            <div class="popup-content">
                <h3 id="popup-title"></h3>
                <p id="popup-message"></p>
                <button id="popup-close">OK</button>
            </div>
        </div>
    </div>
</body>
<script>

    const popup = document.getElementById('popup');
    const popupMessage = document.getElementById('popup-message');
    const icon = document.getElementById('popup-icon');

    document.getElementById("formBarang").addEventListener('submit', function(e) {
        e.preventDefault();

        let nama = document.getElementById('nama_kategori').value.trim();

        if (nama === "") {
            showPopup('Nama Kategori Tidak Boleh Kosong!')
            return;
        }

        this.submit();
    });

    function showPopup(message) {
        popupMessage.textContent = message;
        popup.style.display = 'flex';
        popup.classList.remove('hide');
        popup.classList.add('show');

        setTimeout(() => {
            popup.classList.remove('show');
            popup.classList.add('hide');
            setTimeout(() => {
                popup.style.display = 'none';
            }, 600);
        }, 2500);
    }

    document.getElementById('popup-close').addEventListener('click', ()  => {
        popup.classList.remove('show');
        popup.classList.add('hide');
        setTimeout(() => {
            popup.style.display = 'none'
        }, 600);
    });
</script>
</html>