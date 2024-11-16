<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 10px;
            font-weight: bold;
            font-size: 17px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
            font-size: 16px;
        }

        input:focus {
            border-color: #66afe9;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .message {
            color: green;
            text-align: center;
            margin-top: 15px;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Đăng Nhập</h2>

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
                $error = "Username or password incorrect!";
            }
        }
        ?>

        <form method="POST" action="">
            <div>
                <label for="username">Username:</label>
                <input placeholder="Nhập tên đăng nhập" type="text" name="username"
                    value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div>
                <label for="password">Mật khẩu:</label>
                <input placeholder="Nhập mật khẩu" type="password" name="password" required>
            </div>
            <div>
                <button type="submit">Đăng Nhập</button>
            </div>
        </form>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

</body>

</html>