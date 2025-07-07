<?php
class AboutController {
    private $systemSettingModel;
    private $db;

    public function __construct($db) {
        require_once '../models/SystemSettings.php'; 
        $this->systemSettingModel = new SystemSetting($db);
        $this->db = $db;
    }

    public function index() {
        try {
            if (!$this->db) {
                error_log('Kết nối DB bị lỗi!');
            }

            $result = $this->db->query("SELECT DATABASE() as dbname");
            $row = $result->fetch_assoc();
            error_log('Đang kết nối tới database: ' . $row['dbname']);

            $settings = $this->systemSettingModel->getSettings();
            $_SESSION['system'] = is_array($settings) ? $settings : [
                'about_content' => 'Nội dung giới thiệu mặc định',
                'contact' => '+84 123 456 789',
                'email' => 'email@default.com'
            ];

            // Lấy số doanh nghiệp
            require_once '../models/Company.php';
            $companyModel = new Company($this->db);
            $partners_count = $companyModel->getTotalCompanies();

            // Lấy số dự án/sự kiện
            require_once '../models/Event.php';
            $eventModel = new Event($this->db);
            $projects_count = $eventModel->getTotalEvents();

            // Lấy số sinh viên
            $students_count = 0;
            $result = $this->db->query("SELECT COUNT(*) as count FROM sinh_vien WHERE trang_thai = 1");
            if ($result) {
                $students_count = $result->fetch_assoc()['count'];
            }

            // Tỷ lệ thành công (giả sử có trường status trong bảng events)
            $success_count = 0;
            $result = $this->db->query("SELECT COUNT(*) as count FROM events WHERE type = 1");
            if ($result) {
                $success_count = $result->fetch_assoc()['count'];
            }
            $success_rate = $projects_count > 0 ? round($success_count / $projects_count * 100) : 0;

            // Truyền sang view
            $stats = [
                'students_count' => $students_count,
                'partners_count' => $partners_count,
                'projects_count' => $projects_count,
                'success_rate' => $success_rate
            ];

        } catch (Exception $e) {
            error_log("Lỗi trong AboutController::index: " . $e->getMessage());
            $_SESSION['system'] = [
                'about_content' => 'Nội dung giới thiệu mặc định',
                'contact' => '+84 123 456 789',
                'email' => 'email@default.com'
            ];
            $stats = [
                'students_count' => 0,
                'partners_count' => 0,
                'projects_count' => 0,
                'success_rate' => 0
            ];
        }
        include_once '../views/about/index.php';
    }
}
?>