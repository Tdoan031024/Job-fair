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

        if (isset($user_info['status']) && $user_info['status'] === 'error') {
            error_log("Không tìm thấy dữ liệu cho user_id: $user_id, role: $role");
            include_once '../views/errors/404.php';
            return;
        }

        // Truyền dữ liệu vào view
        include_once '../views/profile/index.php';
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            $_SESSION['error_message'] = "Vui lòng đăng nhập để chỉnh sửa thông tin.";
            header('Location: index.php?page=login');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['user_role'];
        $user_info = $this->profileModel->getUserProfile($user_id, $role);

        if (isset($user_info['status']) && $user_info['status'] === 'error') {
            error_log("Không tìm thấy dữ liệu cho user_id: $user_id, role: $role");
            include_once '../views/errors/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
            $data = [];
            if ($role === 'sinh_vien') {
                $data = [
                    'ho_ten' => $_POST['ho_ten'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'so_dien_thoai' => $_POST['so_dien_thoai'] ?? '',
                    'truong_hoc' => $_POST['truong_hoc'] ?? '',
                    'chuyen_nganh' => $_POST['chuyen_nganh'] ?? '',
                    'dia_chi' => $_POST['dia_chi'] ?? ''
                ];
            } elseif ($role === 'doanh_nghiep') {
                $data = [
                    'ten_cong_ty' => $_POST['ten_cong_ty'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'so_dien_thoai' => $_POST['so_dien_thoai'] ?? '',
                    'dia_chi' => $_POST['dia_chi'] ?? '',
                    'website' => $_POST['website'] ?? '',
                    'quy_mo' => $_POST['quy_mo'] ?? '',
                    'linh_vuc' => $_POST['linh_vuc'] ?? ''
                ];
            }

            // Handle file uploads
            $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
            $cv = ($role === 'sinh_vien' && isset($_FILES['cv_pdf'])) ? $_FILES['cv_pdf'] : null;

            // Update profile
            $result = $this->profileModel->updateUserProfile($user_id, $role, $data, $avatar, $cv);

            // Redirect with success/error message
            if ($result['status'] === 'success') {
                header('Location: index.php?page=profile&success=' . urlencode($result['message']));
            } else {
                header('Location: index.php?page=edit_profile&error=' . urlencode($result['message']));
            }
            exit;
        }

        // Display edit form
        include_once '../views/profile/edit.php';
    }

    private function getUniqueFilename($filename, $directory)
    {
        $pathInfo = pathinfo($filename);
        $base = $pathInfo['filename'];
        $ext = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
        $counter = 1;
        $newFilename = $filename;

        while (file_exists($directory . $newFilename)) {
            $newFilename = $base . '_' . $counter . $ext;
            $counter++;
        }

        return $newFilename;
    }
}
?>