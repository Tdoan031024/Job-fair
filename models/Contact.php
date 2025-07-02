<?php
class Contact {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveContact($full_name, $organization, $email, $contact_method, $message) {
        $query = "INSERT INTO contact (full_name, organization, email, contact_method, message) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $full_name, $organization, $email, $contact_method, $message);
        return $stmt->execute();
    }
}
?>