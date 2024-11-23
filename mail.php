<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
include_once "./config/dbconnect.php";
$order_id = $_POST["order_id"];
$action = $_POST["action"];

$sql = $sql="SELECT * from orders 
INNER Join users on orders.user_id = users.user_id
where orders.order_id = $order_id
";

$result=$conn-> query($sql);

try{
    if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()){
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;             // Bật gỡ lỗi
            $mail->isSMTP();                                   // Gửi qua SMTP
            $mail->Host       = 'smtp.gmail.com';              // Máy chủ SMTP
            $mail->SMTPAuth   = true;                          // Bật xác thực SMTP
            $mail->Username   = 'turgn123@gmail.com';          // Gmail của bạn
            $mail->Password   = 'tqasifkmnscnozxe';          // Mật khẩu ứng dụng
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// TLS encryption
            $mail->Port       = 587;                           // Cổng SMTP

            //Recipients
            $mail->setFrom('turgn123@gmail.com', 'Mailer');
            $mail->addAddress('thanhbacvinh2002@gmail.com', 'Customer'); // Người nhận

            //Content
            $mail->isHTML(true);                                // Email HTML
            $mail->Subject = 'Notification';
            $mail->Body = 'this is a notification';
            
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        }
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
