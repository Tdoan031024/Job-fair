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
        $doanh_nghiep = $this->companyModel->getTopCompanies();
        $linh_vuc_list = $this->companyModel->getIndustries();
        include_once '../views/company/index.php';
    }

    public function view($id) {
        $company = $this->companyModel->getCompanyById($id);
        include_once '../views/company/view.php';
    }
}
?>