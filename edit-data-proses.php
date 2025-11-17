<?php
    include 'db.php';

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $id_barang = mysqli_real_escape_string($conn, $_POST['id_barang']);
        $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
        $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
        $stok = str_replace('.', '', $_POST['stok']);
        $harga_barang = str_replace('.', '', $_POST['harga_barang']);
        $tanggal_masuk =  $_POST['tgl_msk'];

        $update = "UPDATE barang SET
                  nama_barang = '$nama_barang',
                  kategori_id = '$kategori',
                  stok = '$stok',
                  harga = '$harga_barang',
                  tanggal_masuk ='$tanggal_masuk'
                  WHERE id = '$id_barang'";

        $query = mysqli_query($conn, $update);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
                font-family: Arial;
                padding: 40px;
            }

            .berhasil, .gagal {
                padding: 20px;
                margin: 5px;
                border-radius: 10px;
                margin-bottom: 20px;
                color: #fff;
                width: 350px;
            }

            .berhasil {
                background: #4CAF50;
            }

            .gagal {
                background: #e74c3c;
            }

            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(0,0,0,0.4);
                animation: fadeIn 0.3s ease-out;
            }

            .popup-box {
                background: #fff;
                width: 400px;
                padding: 10px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 0 20px rgba(0,0,0,0.2);
                animation: popUp 0.3s ease-out;
            }

            .success {
                color: #2ecc71;
            }

            .error {
                color: #e74c3c;
            }

            .popup-box h3 {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .timer {
                font-size: 16px;
                margin-top: 5px;
                font-weight: bold;
                color: #555;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes popUp {
                from {
                    transform: scale(0.6);
                    opacity: 0;
                }
                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }
    </style>
</head>
<body>
    <div class="popup-overlay">
        <div class="popup-box">
            <?php if ($query) { ?>
            <div class="berhasil">
                <h3>Data Berhasil Diubah!</h3>
            </div>
            <?php } else { ?>
            <div class="gagal">
                <h3>Terjadi Kesalahan Saat Mengubah Data!</h3>
                <strong><?= $error_message ?></strong>
            </div>
            <?php } ?>
            <div class="timer">
                <p>Anda Akan Dialihkan Ke Halaman Utama Dalam
                    <strong id="countdown">3</strong>
                </p>
            </div>
        </div>
    </div>
</body>
<script>
    let timer = 3;

    const countdown = document.getElementById('countdown');

    const interval = setInterval(() => {
        timer--;

        countdown.textContent = timer;

        if(timer <= 0) {
            clearInterval(interval);
            window.location.href = 'index.php';
        }
    }, 1000);
</script>
</html>
<?php } ?>