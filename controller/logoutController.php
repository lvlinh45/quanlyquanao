<?php
session_start();
session_destroy(); // Hủy toàn bộ session
session_write_close(); // Đảm bảo session được đóng
setcookie(session_name(), '', 0, '/'); // Xóa cookie session
session_regenerate_id(true); // Tạo session ID mới để tránh session fixation
exit();
?>