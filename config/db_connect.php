<?php
$conn = new mysqli('localhost', 'root', '', 'event_db');

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}
?>