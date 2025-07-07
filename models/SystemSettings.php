<?php
class SystemSetting {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSettings() {
        $query = "SELECT * FROM system_settings LIMIT 1";
        $result = $this->conn->query($query);
        $row = $result ? $result->fetch_array() : null;
        $settings = [];
        if ($row) {
            foreach ($row as $key => $value) {
                if (!is_numeric($key)) {
                    $settings[$key] = $value;
                }
            }
        }
        return $settings;
    }
}
?>