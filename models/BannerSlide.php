<?php
class BannerSlide {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getActiveSlides() {
        $query = "SELECT * FROM banner_slides WHERE is_active = 1 ORDER BY sort_order ASC";
        return $this->conn->query($query);
    }
}
?>