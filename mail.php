<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
include_once "./config/dbconnect.php";

// Kiểm tra xem có truyền `order_id` qua POST không
if (isset($_POST["order_id"]) && !empty($_POST["order_id"])) {
    $order_id = $conn->real_escape_string($_POST["order_id"]); // Bảo vệ SQL Injection
    $action = $_POST["action"];

    // Lấy email người dùng từ cơ sở dữ liệu
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
                $mail->Host       = 'smtp.gmail.com';                // Máy chủ SMTP
                $mail->SMTPAuth   = true;                            // Bật xác thực SMTP
                $mail->Username   = 'turgn123@gmail.com';            // Gmail của bạn
                $mail->Password   = 'tqasifkmnscnozxe';              // Mật khẩu ứng dụng
                $mail->SMTPSecure = 'tls';  // TLS encryption
                $mail->Port       = 587;                             // Cổng SMTP

                // Recipients
                $mail->setFrom('turgn123@gmail.com', 'PHP Clother Company');
                $mail->addAddress("$email", 'Customer'); // Người nhận

                // Content
                $mail->isHTML(true);                                // Email HTML
                $mail->Subject = 'Notification';
           
                $mail->Body = '
                    <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Xác nhận đơn hàng</title>
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
                            <p>Chào quý khách,</p>
                            <p>Cảm ơn bạn đã tin tưởng và đặt hàng tại <strong>PHP Clother Company</strong>. Đơn hàng của bạn đang được chúng tôi xử lý.</p>
                            <h3>Chi tiết đơn hàng (#' . $order_id . '):</h3>
                            <!-- Bạn có thể thêm bảng chi tiết sản phẩm ở đây -->
                            <table class="order-details" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                </tr>
                                <!-- Ví dụ về một dòng sản phẩm -->
                                <tr>
                                    <td> '. $row["product_name"] .' </td>
                                    <td>'. $row["quantity"] .'</td>
                                    <td>'. $row["price"] .'.000 VND</td>
                                </tr>
                                <!-- Thêm các sản phẩm khác nếu cần -->
                            </table>
                            <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.</p>
                            <a href="http://localhost/quanlyquanao" class="btn">Truy cập website</a>
                        </div>
                        <div class="email-footer">
                            &copy; ' . date("Y") . ' PHP Clother Company. Mọi quyền được bảo lưu.
                        </div>
                    </div>
                </body>
                </html>
                ';
                $mail->AltBody = 'This is the plain text message.';

                // Gửi email
                $mail->send();
                echo '<script>
                    alert("Đã gửi mail thành công");
                    window.location.href = "index.php"; // Thay "index.php" bằng đường dẫn trang chủ của bạn
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
