<?php
class Art {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getArtById($id) {
        $query = "SELECT a.*, u.name as aname 
                  FROM arts a 
                  INNER JOIN users u ON u.id = a.artist_id 
                  WHERE a.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getArtForSale($art_id) {
        $query = "SELECT * FROM arts_fs WHERE art_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $art_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>