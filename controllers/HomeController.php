<?php
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Company.php';
require_once __DIR__ . '/../models/BannerSlide.php';
require_once __DIR__ . '/../models/SystemSettings.php';

class HomeController {
    private $eventModel;
    private $companyModel;
    private $bannerSlideModel;
    private $systemSettingModel;

    public function __construct($db) {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong HomeController: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu.");
        }
        $this->eventModel = new Event($db);
        $this->companyModel = new Company($db);
        $this->bannerSlideModel = new BannerSlide($db);
        $this->systemSettingModel = new SystemSetting($db);
    }

    public function index() {
        $banner_slides = $this->bannerSlideModel->getActiveSlides();
        $events = $this->eventModel->getAllEvents();
        $featured_companies = $this->companyModel->getTopCompanies();
        $total_events = $this->eventModel->getTotalEvents();
        $total_companies = $this->companyModel->getTotalCompanies();
        $total_jobs = $this->companyModel->getTotalJobs();
        $_SESSION['system'] = $this->systemSettingModel->getSettings();
        
        include_once '../views/home/index.php';
    }
}
?>