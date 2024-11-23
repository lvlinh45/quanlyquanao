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
    $sql = "SELECT users.email FROM orders 
            INNER JOIN users ON orders.user_id = users.user_id 
            WHERE orders.order_id = $order_id";

    $result = $conn->query($sql);

    try {
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Server settings
                $email = $row['email'];
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;               // Bật gỡ lỗi
                $mail->isSMTP();                                     // Gửi qua SMTP
                $mail->Host       = 'smtp.gmail.com';                // Máy chủ SMTP
                $mail->SMTPAuth   = true;                            // Bật xác thực SMTP
                $mail->Username   = 'turgn123@gmail.com';            // Gmail của bạn
                $mail->Password   = 'tqasifkmnscnozxe';              // Mật khẩu ứng dụng
                $mail->SMTPSecure = 'tls';  // TLS encryption
                $mail->Port       = 587;                             // Cổng SMTP

                // Recipients
                $mail->setFrom('turgn123@gmail.com', 'Mailer');
                $mail->addAddress("$email", 'Customer'); // Người nhận

                // Content
                $mail->isHTML(true);                                // Email HTML
                $mail->Subject = 'Notification';
                $mail->Body = 'This is a notification message.';
                $mail->AltBody = 'This is the plain text message.';

                // Gửi email
                $mail->send();
                echo 'Message has been sent';
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
