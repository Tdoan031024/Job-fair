<?php
class CompanyController {
    private $companyModel;

    public function __construct($db) {
        $this->companyModel = new Company($db);
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $linh_vuc = isset($_GET['linh_vuc']) ? $_GET['linh_vuc'] : '';
        $quy_mo = isset($_GET['quy_mo']) ? $_GET['quy_mo'] : '';
        $page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        $perPage = 8;

        $total = $this->companyModel->countCompanies($search, $linh_vuc, $quy_mo);
        $total_pages = ceil($total / $perPage);

        if ($page > $total_pages && $total_pages > 0) {
            header('Location: ?' . http_build_query(array_merge($_GET, ['page' => 1])));
            exit;
        }

        $doanh_nghiep = $this->companyModel->getCompaniesByPage($page, $perPage, $search, $linh_vuc, $quy_mo);
        $linh_vuc_list = $this->companyModel->getIndustries();

        include_once '../views/company/index.php';
    }

    public function view($id) {
        $company = $this->companyModel->getCompanyById($id);
        if (!$company) {
            include_once '../views/errors/404.php';
            return;
        }
        $jobs = $this->companyModel->getJobsByCompanyId($id);
        include_once '../views/company/view.php';
    }

    public function viewJob($id) {
        $job = $this->companyModel->getJobById($id);
        if (!$job) {
            include_once '../views/errors/404.php';
            return;
        }
        // Lấy các việc làm tương tự (cùng chuyên ngành, loại trừ chính nó)
        $similar_jobs = $this->companyModel->getSimilarJobs($job['chuyen_nganh'], $job['id']);
        include_once '../views/company/view_job.php';
    }
}
?>