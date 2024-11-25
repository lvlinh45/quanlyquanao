<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
include_once "./config/dbconnect.php";

// Check if order_id is passed via POST
if (isset($_POST["order_id"]) && !empty($_POST["order_id"])) {
    $order_id = $conn->real_escape_string($_POST["order_id"]); // Protect from SQL Injection
    $action = $_POST["action"];

    // Get user email from database
    $sql = "SELECT * FROM orders 
            INNER JOIN users ON orders.user_id = users.user_id 
            INNER Join order_details on order_details.order_id = orders.order_id
            Inner Join product_size_variation on order_details.variation_id = product_size_variation.variation_id
            inner join product on product.product_id = product_size_variation.product_id
            WHERE orders.order_id = $order_id
            ";
    $result = $conn->query($sql);

    try {
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Server settings
                $email = $row['email'];
                // Bật gỡ lỗi
                $mail->isSMTP();                                     // Gửi qua SMTP
                $mail->Host = 'smtp.gmail.com';                // Máy chủ SMTP
                $mail->SMTPAuth = true;                            // Bật xác thực SMTP
                $mail->Username = 'turgn123@gmail.com';            // Gmail của bạn
                $mail->Password = 'tqasifkmnscnozxe';              // Mật khẩu ứng dụng
                $mail->SMTPSecure = 'tls';  // TLS encryption
                $mail->Port = 587;                             // Cổng SMTP

                // Recipients
                $mail->setFrom('turgn123@gmail.com', 'PHP Clother Company');
                $mail->addAddress("$email", 'Customer'); // Người nhận

                // Content
                $mail->isHTML(true);                                // Email HTML
                $mail->Subject = 'Order Confirmation';

                $mail->Body = '
                    <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Order Confirmation</title>
                    <style>
                        .email-container {
                            font-family: Arial, sans-serif;
                            color: #333333;
                            background-color: #f4f4f4;
                            padding: 20px;
                        }
                        .email-header {
                            background-color: #007bff;
                            color: #ffffff;
                            padding: 20px;
                            text-align: center;
                        }
                        .email-content {
                            background-color: #ffffff;
                            padding: 30px;
                            margin-top: 20px;
                        }
                        .email-footer {
                            text-align: center;
                            color: #888888;
                            font-size: 12px;
                            margin-top: 30px;
                        }
                        .order-details {
                            margin-top: 20px;
                            text-align: center;
                        }
                        .order-details th, .order-details td {
                            padding: 10px;
                            border-bottom: 1px solid #dddddd;

                        }
                        .btn {
                            display: inline-block;
                            background-color: #99ffff;
                            color: #ffffff;
                            padding: 10px 20px;
                            margin-top: 20px;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                    </style>
                </head>
                <body>

                    <div class="email-container">
                        <div class="email-header">
                            <h1>PHP Clother Company</h1>
                        </div>
                        <div class="email-content">
                            <p>Dear Customer,</p>
                            <p>Thank you for trusting and ordering from <strong>PHP Clother Company</strong>. Your order is being processed.</p>
                            <h3>Order Details (#' . $order_id . '):</h3>
                            <table class="order-details" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                                <tr>
                                    <td> ' . $row["product_name"] . ' </td>
                                    <td>' . $row["quantity"] . '</td>
                                    <td>' . $row["price"] . '.000 VND</td>
                                </tr>
                            </table>
                            <p>If you have any questions, please contact us via email or support phone number.</p>
                            <a href="http://localhost/quanlyquanao" class="btn">Visit Website</a>
                        </div>
                        <div class="email-footer">
                            &copy; ' . date("Y") . ' PHP Clother Company. All rights reserved.
                        </div>
                    </div>
                </body>
                </html>
                ';
                $mail->AltBody = 'This is the plain text message.';

                // Gửi email
                $mail->send();
                echo '<script>
                    alert("Email sent successfully");
                    window.location.href = "index.php";
                    </script>';
                exit; // Dừng thực thi sau khi gửi email và chuyển hướng
            }

        } else {
            echo 'No email found for the given order_id.';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Nếu `order_id` không có hoặc rỗng
    echo 'Order ID is required.';
}
?>