<?php
class AuthController {
    private $authModel;


    public function __construct($db) {
        require_once '../models/Auth.php'; 
        $this->authModel = new AuthModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $result = $this->authModel->authenticate($email, $password);
            
            if (isset($result['status']) && $result['status'] === 'error') {
                $error = $result['message'];
                include_once '../views/auth/login.php';
            } else {
                // Đăng nhập thành công
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['user_role'] = $result['role'];
                $_SESSION['user_email'] = $result['email'];
                $_SESSION['user_name'] = $result['name'];
                header('Location: index.php?page=profile');
                exit;
            }
        } else {
            include_once '../views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? '';
            $data = [
                'ho_ten' => htmlspecialchars(trim($_POST['ho_ten'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'mat_khau' => $_POST['password'] ?? '',
                'so_dien_thoai' => htmlspecialchars(trim($_POST['so_dien_thoai'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'dia_chi' => htmlspecialchars(trim($_POST['dia_chi'] ?? ''), ENT_QUOTES, 'UTF-8'),
            ];

            if ($role === 'sinh_vien') {
                $data['truong_hoc'] = htmlspecialchars(trim($_POST['truong_hoc'] ?? ''), ENT_QUOTES, 'UTF-8');
                $data['chuyen_nganh'] = htmlspecialchars(trim($_POST['chuyen_nganh'] ?? ''), ENT_QUOTES, 'UTF-8');
            } elseif ($role === 'doanh_nghiep') {
                $data['ten_cong_ty'] = htmlspecialchars(trim($_POST['ten_cong_ty'] ?? ''), ENT_QUOTES, 'UTF-8');
                $data['website'] = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_URL);
                $data['quy_mo'] = htmlspecialchars(trim($_POST['quy_mo'] ?? ''), ENT_QUOTES, 'UTF-8');
                $data['linh_vuc_id'] = filter_input(INPUT_POST, 'linh_vuc_id', FILTER_SANITIZE_NUMBER_INT);
            }

            $result = $this->authModel->register($data, $role);
            if ($result['status'] === 'success') {
                $_SESSION['success_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: index.php?page=login');
                exit;
            } else {
                $error = $result['message'];
                $linh_vuc_list = $this->authModel->getIndustries();
                include_once '../views/auth/register.php';
            }
        } else {
            $linh_vuc_list = $this->authModel->getIndustries();
            include_once '../views/auth/register.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }
}
?>