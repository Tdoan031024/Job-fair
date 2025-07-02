<?php
class AboutController {
    private $systemSettingModel;

    public function __construct($db) {
        require_once '../models/SystemSettings.php'; 
        $this->systemSettingModel = new SystemSetting($db);
    }

    public function index() {
        try {
            $settings = $this->systemSettingModel->getSettings();
            $_SESSION['system'] = is_array($settings) ? $settings : [
                'about_content' => 'Nội dung giới thiệu mặc định',
                'contact' => '+84 123 456 789',
                'email' => 'email@default.com'
            ];
        } catch (Exception $e) {
            error_log("Lỗi trong AboutController::index: " . $e->getMessage());
            $_SESSION['system'] = [
                'about_content' => 'Nội dung giới thiệu mặc định',
                'contact' => '+84 123 456 789',
                'email' => 'email@default.com'
            ];
        }
        include_once '../views/about/index.php';
    }
}
?>