<?php
class CompanyController {
    private $companyModel;

    public function __construct($db) {
        require_once '../models/Company.php';
        $this->companyModel = new Company($db);
    }

    public function index() {
        try {
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $linh_vuc = isset($_GET['linh_vuc']) ? trim($_GET['linh_vuc']) : '';
            $quy_mo = isset($_GET['quy_mo']) ? trim($_GET['quy_mo']) : '';
            $doanh_nghiep = $this->companyModel->getTopCompanies();
            $linh_vuc_list = $this->companyModel->getIndustries();
            if ($doanh_nghiep === false || $linh_vuc_list === false) {
                error_log("Lỗi: Không thể lấy dữ liệu trong index");
                include_once '../views/errors/500.php';
                return;
            }
            include_once '../views/company/index.php';
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::index: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function view($id) {
        try {
            $company = $this->companyModel->getCompanyById($id);
            if (!$company) {
                error_log("Không tìm thấy công ty: id=$id");
                include_once '../views/errors/404.php';
                return;
            }
            $jobs = $this->companyModel->getJobsByCompanyId($id);
            if ($jobs === false) {
                error_log("Lỗi: Không thể lấy danh sách việc làm cho công ty: id=$id");
            }
            include_once '../views/company/view.php';
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::view: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function viewJob($id) {
        try {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
                $_SESSION['error_message'] = "Vui lòng đăng nhập để xem chi tiết việc làm.";
                header('Location: index.php?page=login');
                exit;
            }

            $doanh_nghiep_id = $_SESSION['user_role'] === 'doanh_nghiep' ? $_SESSION['user_id'] : null;
            $job = $this->companyModel->getJobById($id, $doanh_nghiep_id);

            if (isset($job['status']) && $job['status'] === 'error') {
                error_log("Không tìm thấy việc làm: job_id=$id, doanh_nghiep_id=" . ($doanh_nghiep_id ?? 'null'));
                include_once '../views/errors/404.php';
                return;
            }

            include_once '../views/company/view_job.php';
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::viewJob: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function addJob() {
        try {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'doanh_nghiep') {
                $_SESSION['error_message'] = "Vui lòng đăng nhập với vai trò doanh nghiệp để thêm việc làm.";
                header('Location: index.php?page=login');
                exit;
            }

            $doanh_nghiep_id = $_SESSION['user_id'];
            $error = null;
            $success = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'tieu_de' => trim($_POST['tieu_de'] ?? ''),
                    'mo_ta' => trim($_POST['mo_ta'] ?? ''),
                    'yeu_cau' => trim($_POST['yeu_cau'] ?? ''),
                    'chuyen_nganh' => trim($_POST['chuyen_nganh'] ?? ''),
                    'kinh_nghiem' => trim($_POST['kinh_nghiem'] ?? ''),
                    'dia_diem' => trim($_POST['dia_diem'] ?? ''),
                    'luong' => trim($_POST['luong'] ?? ''),
                    'han_nop' => trim($_POST['han_nop'] ?? ''),
                    'so_luong' => trim($_POST['so_luong'] ?? ''),
                    'trang_thai' => trim($_POST['trang_thai'] ?? '')
                ];

                // Server-side validation
                if (empty($data['tieu_de'])) {
                    $error = 'Tiêu đề là bắt buộc.';
                } elseif (strlen($data['tieu_de']) > 255) {
                    $error = 'Tiêu đề không được vượt quá 255 ký tự.';
                } elseif (!empty($data['luong']) && strlen($data['luong']) > 100) {
                    $error = 'Lương không được vượt quá 100 ký tự.';
                } elseif (!empty($data['dia_diem']) && strlen($data['dia_diem']) > 100) {
                    $error = 'Địa điểm không được vượt quá 100 ký tự.';
                } elseif (!empty($data['so_luong']) && (!is_numeric($data['so_luong']) || $data['so_luong'] < 1)) {
                    $error = 'Số lượng phải là số nguyên dương.';
                } elseif (!empty($data['han_nop']) && !strtotime($data['han_nop'])) {
                    $error = 'Hạn nộp không hợp lệ. Định dạng phải là Y-m-d (ví dụ: 2025-08-01).';
                } else {
                    $result = $this->companyModel->addJob($doanh_nghiep_id, $data);
                    if ($result['status'] === 'success') {
                        header('Location: index.php?page=profile&success=' . urlencode($result['message']));
                        exit;
                    } else {
                        $error = $result['message'];
                    }
                }
                error_log("addJob POST data: " . print_r($data, true));
            }

            include_once '../views/company/add_job.php';
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::addJob: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function editJob($job_id) {
        try {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'doanh_nghiep') {
                $_SESSION['error_message'] = "Vui lòng đăng nhập với vai trò doanh nghiệp để chỉnh sửa việc làm.";
                header('Location: index.php?page=login');
                exit;
            }

            $doanh_nghiep_id = $_SESSION['user_id'];
            $job = $this->companyModel->getJobById($job_id, $doanh_nghiep_id);

            if (isset($job['status']) && $job['status'] === 'error') {
                error_log("Không tìm thấy việc làm: job_id=$job_id, doanh_nghiep_id=$doanh_nghiep_id");
                include_once '../views/errors/404.php';
                return;
            }

            $error = null;
            $success = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'tieu_de' => trim($_POST['tieu_de'] ?? ''),
                    'mo_ta' => trim($_POST['mo_ta'] ?? ''),
                    'yeu_cau' => trim($_POST['yeu_cau'] ?? ''),
                    'chuyen_nganh' => trim($_POST['chuyen_nganh'] ?? ''),
                    'kinh_nghiem' => trim($_POST['kinh_nghiem'] ?? ''),
                    'dia_diem' => trim($_POST['dia_diem'] ?? ''),
                    'luong' => trim($_POST['luong'] ?? ''),
                    'han_nop' => trim($_POST['han_nop'] ?? ''),
                    'so_luong' => trim($_POST['so_luong'] ?? ''),
                    'trang_thai' => trim($_POST['trang_thai'] ?? '')
                ];

                // Server-side validation
                if (empty($data['tieu_de'])) {
                    $error = 'Tiêu đề là bắt buộc.';
                } elseif (strlen($data['tieu_de']) > 255) {
                    $error = 'Tiêu đề không được vượt quá 255 ký tự.';
                } elseif (!empty($data['luong']) && strlen($data['luong']) > 100) {
                    $error = 'Lương không được vượt quá 100 ký tự.';
                } elseif (!empty($data['dia_diem']) && strlen($data['dia_diem']) > 100) {
                    $error = 'Địa điểm không được vượt quá 100 ký tự.';
                } elseif (!empty($data['so_luong']) && (!is_numeric($data['so_luong']) || $data['so_luong'] < 1)) {
                    $error = 'Số lượng phải là số nguyên dương.';
                } elseif (!empty($data['han_nop']) && !strtotime($data['han_nop'])) {
                    $error = 'Hạn nộp không hợp lệ. Định dạng phải là Y-m-d (ví dụ: 2025-08-01).';
                } else {
                    $result = $this->companyModel->updateJob($job_id, $doanh_nghiep_id, $data);
                    if ($result['status'] === 'success') {
                        header('Location: index.php?page=profile&success=' . urlencode($result['message']));
                        exit;
                    } else {
                        $error = $result['message'];
                    }
                }
                error_log("editJob POST data: " . print_r($data, true));
            }

            include_once '../views/company/edit_job.php';
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::editJob: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }

    public function deleteJob($job_id) {
        try {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'doanh_nghiep') {
                $_SESSION['error_message'] = "Vui lòng đăng nhập với vai trò doanh nghiệp để xóa việc làm.";
                header('Location: index.php?page=login');
                exit;
            }

            $doanh_nghiep_id = $_SESSION['user_id'];
            $result = $this->companyModel->deleteJob($job_id, $doanh_nghiep_id);

            header('Location: index.php?page=profile' . ($result['status'] === 'success' ? '&success=' . urlencode($result['message']) : '&error=' . urlencode($result['message'])));
            exit;
        } catch (Exception $e) {
            error_log("Lỗi trong CompanyController::deleteJob: " . $e->getMessage());
            include_once '../views/errors/500.php';
        }
    }
}
?>