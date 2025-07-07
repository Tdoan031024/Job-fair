<?php
class ProfileController
{
    private $profileModel;

    public function __construct($db)
    {
        require_once '../models/Profile.php';
        $this->profileModel = new Profile($db);
    }

    public function index()
    {
        error_log("Kiểm tra session trong controller: user_id=" . ($_SESSION['user_id'] ?? 'null') . ", user_role=" . ($_SESSION['user_role'] ?? 'null'));
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để xem thông tin cá nhân.";
            header('Location: index.php?page=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        $user_info = $this->profileModel->getUserProfile($user_id, $role);

        if (!$user_info) {
            error_log("Không tìm thấy dữ liệu cho user_id: $user_id, role: $role");
            include_once '../views/errors/404.php';
            return;
        }

        // Truyền dữ liệu vào view
        include_once '../views/profile/index.php';
    }
}