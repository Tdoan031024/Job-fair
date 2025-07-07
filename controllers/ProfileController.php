<?php
class ProfileController
{
    private $profileModel;
    private $companyModel;

    public function __construct($db)
    {
        require_once '../models/Profile.php';
        require_once '../models/Company.php';
        $this->profileModel = new Profile($db);
        $this->companyModel = new Company($db);
    }

    public function index()
    {
        try {
            error_log("Kiểm tra session: user_id=" . ($_SESSION['user_id'] ?? 'null') . ", user_role=" . ($_SESSION['user_role'] ?? 'null'));
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

            // Fetch jobs for doanh_nghiep
            $jobs = null;
            if ($role === 'doanh_nghiep') {
                $jobs = $this->companyModel->getJobsByCompanyId($user_id);
                if ($jobs === false) {
                    error_log("Lỗi: Không thể lấy danh sách việc làm cho doanh_nghiep_id: $user_id");
                    $jobs = null;
                }
            }

            // Truyền dữ liệu vào view
            include_once '../views/profile/index.php';
        } catch (Exception $e) {
            error_log("Lỗi trong ProfileController::index: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function edit()
    {
        try {
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

            $error = null;
            $success = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $role === 'sinh_vien' ? [
                    'ho_ten' => $_POST['ho_ten'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'so_dien_thoai' => $_POST['so_dien_thoai'] ?? '',
                    'truong_hoc' => $_POST['truong_hoc'] ?? '',
                    'chuyen_nganh' => $_POST['chuyen_nganh'] ?? '',
                    'dia_chi' => $_POST['dia_chi'] ?? ''
                ] : [
                    'ten_cong_ty' => $_POST['ten_cong_ty'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'so_dien_thoai' => $_POST['so_dien_thoai'] ?? '',
                    'dia_chi' => $_POST['dia_chi'] ?? '',
                    'website' => $_POST['website'] ?? '',
                    'quy_mo' => $_POST['quy_mo'] ?? '',
                    'linh_vuc' => $_POST['linh_vuc'] ?? ''
                ];

                $avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
                $cv = ($role === 'sinh_vien' && isset($_FILES['cv_pdf'])) ? $_FILES['cv_pdf'] : null;

                $result = $this->profileModel->updateUserProfile($user_id, $role, $data, $avatar, $cv);

                if ($result['status'] === 'success') {
                    $success = $result['message'];
                    header('Location: index.php?page=profile&success=' . urlencode($result['message']));
                    exit;
                } else {
                    $error = $result['message'];
                }
            }

            include_once '../views/profile/edit_profile.php';
        } catch (Exception $e) {
            error_log("Lỗi trong ProfileController::edit: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }
}
?>