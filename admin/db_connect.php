<?php
$conn = new mysqli('localhost', 'root', '', 'event_db');

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    // Nếu là API, trả về JSON lỗi và dừng
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error', 'message'=>'Kết nối CSDL thất bại']);
    exit;
}

?>