<?php
class Event
{
    private $conn;

    public function __construct($db)
    {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong Event model: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu trong Event model.");
        }
        $this->conn = $db;
    }

    public function getUpcomingEvents($limit = 0)
    {
        $query = "SELECT e.*, v.venue 
              FROM events e 
              LEFT JOIN venue v ON v.id = e.venue_id 
              WHERE e.schedule >= NOW() 
              AND e.type = 1 
              ORDER BY e.schedule ASC";
        if ($limit > 0) {
            $query .= " LIMIT ?";
        }
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi chuẩn bị truy vấn trong getUpcomingEvents: " . $this->conn->error);
            return false;
        }
        if ($limit > 0) {
            $stmt->bind_param("i", $limit);
        }
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn trong getUpcomingEvents: " . $stmt->error);
            return false;
        }
        $result = $stmt->get_result();
        if ($result === false) {
            error_log("Lỗi lấy kết quả truy vấn trong getUpcomingEvents: " . $this->conn->error);
            return false;
        }
        error_log("getUpcomingEvents trả về " . $result->num_rows . " bản ghi");
        return $result;
    }

    public function getEventById($id)
    {
        // Kiểm tra và chuyển $id thành số nguyên để tránh SQL Injection
        $id = (int)$id;
        if ($id <= 0) {
            error_log("Lỗi: ID sự kiện không hợp lệ: $id");
            return false;
        }

        $query = "SELECT e.*, v.venue 
                  FROM events e 
                  LEFT JOIN venue v ON v.id = e.venue_id 
                  WHERE e.id = $id AND e.type = 1";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Không thể lấy sự kiện với ID $id: " . $this->conn->error);
            return false;
        }
        if ($result->num_rows === 0) {
            error_log("Không tìm thấy sự kiện với ID $id và type = 1");
            return false;
        }
        return $result->fetch_assoc();
    }

    public function getTotalEvents()
    {
        $query = "SELECT COUNT(*) as count FROM events WHERE type = 1";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getTotalEvents thất bại: " . $this->conn->error);
            return 0;
        }
        return $result->fetch_assoc()['count'];
    }

    public function getAllEvents()
    {
        $query = "SELECT e.*, v.venue 
              FROM events e 
              LEFT JOIN venue v ON v.id = e.venue_id 
              WHERE e.type = 1 
              ORDER BY e.schedule DESC";  // Có thể sửa ASC nếu muốn cũ -> mới
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Không thể lấy tất cả sự kiện: " . $this->conn->error);
            return false;
        }
        return $result;
    }
}