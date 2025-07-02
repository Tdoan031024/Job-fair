<?php

require_once __DIR__ . '/../models/Contact.php';

class ContactController {
    private $contactModel;

    public function __construct($db) {
        $this->contactModel = new Contact($db);
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = $_POST['full_name'];
            $organization = $_POST['organization'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $contact_method = $_POST['contact_method'];
            $message = $_POST['message'];

            if ($this->contactModel->saveContact($full_name, $organization, $email, $contact_method, $message)) {
                header("Location: index.php?page=contact&success=1");
                exit;
            } else {
                echo "<script>alert('Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại.');</script>";
            }
        }
        include_once '../views/contact/index.php';
    }

    public function submit() {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = $_POST['fullName'];
            $organization = $_POST['organization'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $contact_method = $_POST['contactMethod'];
            $message = $_POST['message'];

            if (empty($full_name) || empty($organization) || empty($email) || empty($contact_method) || empty($message)) {
                $response['message'] = 'Vui lòng điền đầy đủ thông tin.';
            } else {
                if ($this->contactModel->saveContact($full_name, $organization, $email, $contact_method, $message)) {
                    $response['success'] = true;
                    $response['message'] = 'Cảm ơn bạn đã gửi góp ý! Chúng tôi sẽ liên hệ sớm.';
                } else {
                    $response['message'] = 'Có lỗi khi lưu dữ liệu.';
                }
            }
        } else {
            $response['message'] = 'Phương thức không hợp lệ.';
        }

        echo json_encode($response);
    }
}
?>