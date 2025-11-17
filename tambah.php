<?php
    require "db.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Inventaris</title>
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
            <form class="form-container" action="tambah-data.php" id="formBarang" method="POST">
            <div class="mb-3">
                <label  class="form-label">Nama Barang: </label>
                <input type="text" class="form-control" name="nama_barang" id="nama_barang">
            </div>
            <div class="mb-3">
                <label  class="form-label">Kategori: </label>
                <select name="kategori" id="kategori" class="form-control">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC"); 
                        while($k = mysqli_fetch_assoc($query)):
                    ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                    <?php endwhile ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Stok: </label>
                <input type="text" class="form-control" name="stok" id="stok">
            </div>
            <div class="mb-3">
                <label  class="form-label">Harga Barang:</label>
                <input type="text" class="form-control" name="harga_barang" id="harga_barang">
            </div>
            <div class="mb-3">
                <label  class="form-label">Tanggal Masuk</label>
                <input type="date" class="form-control" name="tgl_msk" id="tgl_msk">
            </div>
            <button type="submit" name="simpan" class="btn btn-success w-100">Simpan Data</button>
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

        let nama = document.getElementById('nama_barang').value.trim();
        let kategori = document.getElementById('kategori').value.trim();
        let stok = document.getElementById('stok').value.trim();
        let harga_barang = document.getElementById('harga_barang').value.trim();
        let tgl_msk = document.getElementById('tgl_msk').value.trim();

        if (nama === "") {
            showPopup('Nama Barang Tidak Boleh Kosong!')
            return;
        }

        if (kategori === "") {
            showPopup('Kategori Harus Diisi!')
            return;
        }

        if (stok === "") {
            showPopup('Stok Harus Diisi!');
            return;
        }


        if (isNaN(stok)) {
            showPopup('Stok Harus Berupa Angka!');
            return;
        }

        if (stok < 0) {
            showPopup('Stok Tidak Boleh Negatif!');
            return;
        }

        if(harga_barang === "") {
            showPopup('Harga barang Harus Diisi!');
            return;
        }

        if(isNaN(harga_barang)) {
            showPopup('Harga Barang Harus Berupa Angka!');
        }

        if(harga_barang < 0) {
            showPopup('Harga Barang Tidak Boleh Negatif');
        }

        const today = new Date().toISOString().split('T')[0];
        if (tgl_msk > today) {
            showPopup('Tanggal Masuk Tidak Boleh Melebihi Hari Ini!');
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