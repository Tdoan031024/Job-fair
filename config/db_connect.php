<?php
$conn = new mysqli('localhost', 'root', '123456', 'event_db');

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}
?>