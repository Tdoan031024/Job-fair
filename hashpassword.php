<?php
$password = 'admin123'; // Thay bằng mật khẩu gốc, ví dụ: 'admin123'
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>