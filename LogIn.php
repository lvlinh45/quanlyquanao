<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container {
        max-width: 400px;
        width: 90%;
        padding: 0;
    }

    .login-card {
        background: white;
        padding: 40px 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header i {
        font-size: 50px;
        color: #5cb85c;
        margin-bottom: 15px;
    }

    .login-header h2 {
        color: #333;
        font-size: 24px;
        font-weight: 600;
    }

    .form-group label {
        font-weight: 500;
        color: #555;
        font-size: 14px;
    }

    .form-control {
        height: 45px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #5cb85c;
        box-shadow: 0 0 0 0.2rem rgba(92, 184, 92, 0.25);
    }

    .btn-login {
        height: 45px;
        font-size: 16px;
        font-weight: 500;
        background: #5cb85c;
        border: none;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .btn-login:hover {
        background: #4cae4c;
        transform: translateY(-1px);
    }

    .error {
        color: #dc3545;
        text-align: center;
        margin-top: 15px;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="login-header">
                <i class="fa fa-user-circle"></i>
                <h2>Admin Login</h2>
            </div>

            <?php
            session_start();
            $message = '';
            $error = '';
            $username = '';

            include './config/dbconnect.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);

                $sql = "SELECT * FROM staff WHERE email='$username' AND password='$password'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['login'] = $row;
                    header("Location: index.php");
                } else {
                    $error = "Username or Password incorrect!";
                }
            }
            ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Enter your username"
                            value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login btn-block text-white">
                    Sign in <i class="fa fa-sign-in ml-2"></i>
                </button>
            </form>

            <?php if ($error): ?>
            <div class="error">
                <i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>