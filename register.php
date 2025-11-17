<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .form-container {
            box-shadow: 0 0 14px rgba(0,0,0,0.1);
            padding: 30px;
            border-radius: 8px;
            width: 50%;
            margin-left: 300px;
        }

        input[type=text],
        input[type=password],
        input[type=email] {
            transition: all 0.3s ease;
        }

        input[type=text]:hover,
        input[type=password]:hover,
        input[type=email]:hover {
            border: 1px solid #1db954;
        }

        .link {
            padding-left: 115px;
            margin-top: 20px;
        }

        .card {
            width: 50%;
            margin-left: 300px;
            padding-top: 10px;
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
<body>
    <div class="container mt-5">
        <div class="card header bg-success text-white text-center">
            <h3>Register</h3>
        </div>
        <form action="proses-register.php" method="POST" class="form-container" id="formLogin">
            <div class="mb-3">
            <label for="" class="form-label">Username: </label>
            <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="mb-3">
            <label for="" class="form-label">Nama Lengkap: </label>
            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
            </div>
            <div class="mb-3">
            <label for="" class="form-label">Password: </label>
            <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email: </label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <button type=submit name="register" class="btn btn-success w-100">Register</button>
            <div class="link">
            <p>Sudah Punya Akun? <a href="login.php">Login</a> Di Sini!</p>
            </div>
        </form>
        <div class="popup" id="popup">
            <div class="popup-content">
                <h3 id="popup-title"></h3>
                <p id="popup-message"></p>
                <button id="popup-close">OK</button>
            </div>
        </div>
    </div>
    <script>

        const popup = document.getElementById('popup');
        const popupMessage = document.getElementById('popup-message');

        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();

            let username = document.getElementById('username').value.trim();
            let password = document.getElementById('password').value.trim();
            let nama_lengkap = document.getElementById('nama_lengkap').value.trim();
            let email = document.getElementById('email').value.trim();

            if (username === "") {
                showPopup('Username Harus Diisi!');
                return;
            }

            if (password === "") {
                showPopup('Password Harus Diisi!');
                return;
            }

            if (nama_lengkap === "") {
                showPopup('Nama Lengkap Harus Diisi!');
                return;
            }

            if (email === "") {
                showPopup('Email Harus Diisi!');
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
</body>
</html>