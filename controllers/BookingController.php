<?php
class BookingController {
    public function __construct($db) {
        // Khởi tạo model nếu cần
    }

    public function index() {
        include_once '../views/booking/index.php';
    }
}
?>