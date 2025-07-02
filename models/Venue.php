<?php
class Venue {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getVenues() {
        $query = "SELECT * FROM venue ORDER BY RAND()";
        return $this->conn->query($query);
    }

    public function getVenueById($id) {
        $query = "SELECT * FROM venue WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>