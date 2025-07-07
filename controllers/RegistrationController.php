<?php
class RegistrationController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index($event_id = null) {
        include_once '../views/booking/index.php';
    }

    public function submit() {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = mysqli_real_escape_string($this->conn, $_POST['full_name']);
            $address = mysqli_real_escape_string($this->conn, $_POST['address']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $contact = mysqli_real_escape_string($this->conn, $_POST['contact']);
            $event_schedule = mysqli_real_escape_string($this->conn, $_POST['event_schedule']);
            $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;

            if (empty($full_name) || empty($address) || empty($email) || empty($contact) || empty($event_schedule)) {
                $response['message'] = 'Vui lòng điền đầy đủ thông tin.';
            } else {
                $query = "INSERT INTO registrations (event_id, full_name, address, email, contact, event_schedule) 
                          VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("isssss", $event_id, $full_name, $address, $email, $contact, $event_schedule);
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Cảm ơn bạn đã đăng ký! Chúng tôi sẽ liên hệ sớm.';
                } else {
                    $response['message'] = 'Có lỗi khi lưu dữ liệu: ' . $this->conn->error;
                }
                $stmt->close();
            }
        } else {
            $response['message'] = 'Phương thức không hợp lệ.';
        }

        echo json_encode($response);
    }
}
?>