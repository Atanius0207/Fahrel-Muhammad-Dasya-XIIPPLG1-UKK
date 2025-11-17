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

        
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card header bg-success text-white text-center">
            <h3>Login</h3>
        </div>
        <form action="proses-login.php" method="POST" class="form-container">
            <div class="mb-3">
            <label for="" class="form-label">Username: </label>
            <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Password: </label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type=submit name="login" class="btn btn-success w-100">Login</button>
            <div class="link">
            <p>Belum Punya Akun? <a href="register.php">Register</a> Di Sini!</p>
            </div>
        </form>
    </div>
</body>
</html>