<?php
class Company
{
    private $conn;

    public function __construct($db)
    {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong Company model: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu trong Company model.");
        }
        $this->conn = $db;
    }

    public function getCompanies($search = '', $linh_vuc = '', $quy_mo = '', $limit = 0)
    {
        $query = "SELECT d.*, l.ten_linh_vuc 
                  FROM doanh_nghiep d 
                  LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id";
        $types = "";
        $params = [];

        if (!empty($search)) {
            $query .= " WHERE d.ten_cong_ty LIKE ?";
            $types .= "s";
            $params[] = "%$search%";
        } else {
            $query .= " WHERE 1=1";
        }
        if (!empty($linh_vuc)) {
            $query .= " AND d.linh_vuc_id = ?";
            $types .= "i";
            $params[] = $linh_vuc;
        }
        if (!empty($quy_mo)) {
            $query .= " AND d.quy_mo = ?";
            $types .= "s";
            $params[] = $quy_mo;
        }
        $query .= " ORDER BY d.ten_cong_ty ASC";
        if ($limit > 0) {
            $query .= " LIMIT ?";
            $types .= "i";
            $params[] = $limit;
        }

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi: Không thể chuẩn bị truy vấn trong getCompanies: " . $this->conn->error);
            return false;
        }
        if (!empty($types)) {
            if (!$stmt->bind_param($types, ...$params)) {
                error_log("Lỗi: Bind param thất bại trong getCompanies: " . $stmt->error);
                return false;
            }
        }
        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong getCompanies: " . $stmt->error);
            return false;
        }
        $result = $stmt->get_result();
        error_log("getCompanies trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
        return $result;
    }

    public function getCompanyById($id)
    {
        $query = "SELECT d.*, l.ten_linh_vuc 
                  FROM doanh_nghiep d 
                  LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id 
                  WHERE d.id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi: Không thể chuẩn bị truy vấn trong getCompanyById: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong getCompanyById: " . $stmt->error);
            return false;
        }
        return $stmt->get_result()->fetch_assoc();
    }

    public function getJobsByCompanyId($id)
    {
        $query = "SELECT * FROM viec_lam WHERE doanh_nghiep_id = ? AND trang_thai = 1 ORDER BY ngay_tao DESC";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi: Không thể chuẩn bị truy vấn trong getJobsByCompanyId: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong getJobsByCompanyId: " . $stmt->error);
            return false;
        }
        $result = $stmt->get_result();
        error_log("getJobsByCompanyId trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
        return $result;
    }

    public function getIndustries()
    {
        $query = "SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getIndustries thất bại: " . $this->conn->error);
            return false;
        }
        return $result;
    }

    public function getTotalCompanies()
    {
        $query = "SELECT COUNT(*) as count FROM doanh_nghiep";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getTotalCompanies thất bại: " . $this->conn->error);
            return 0;
        }
        return $result->fetch_assoc()['count'];
    }

    public function getTotalJobs()
    {
        $query = "SELECT COUNT(*) as count FROM viec_lam WHERE trang_thai = 1";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getTotalJobs thất bại: " . $this->conn->error);
            return 0;
        }
        return $result->fetch_assoc()['count'];
    }

    public function getTopCompanies()
    {
        $query = "SELECT d.*, l.ten_linh_vuc 
              FROM doanh_nghiep d 
              LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id 
              WHERE d.trang_thai = 1 
              ORDER BY d.id ASC 
              LIMIT 3";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getTopCompanies thất bại: " . $this->conn->error);
            return false;
        }
        error_log("getTopCompanies trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
        return $result;
    }

    public function getJobById($id)
    {
        $query = "SELECT v.*, d.ten_cong_ty, d.logo, d.linh_vuc_id, d.quy_mo, d.website, d.dia_chi, d.email, d.so_dien_thoai, l.ten_linh_vuc
                  FROM viec_lam v
                  JOIN doanh_nghiep d ON v.doanh_nghiep_id = d.id
                  LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id
                  WHERE v.id = ? AND v.trang_thai = 1";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi: Không thể chuẩn bị truy vấn trong getJobById: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong getJobById: " . $stmt->error);
            return false;
        }
        return $stmt->get_result()->fetch_assoc();
    }

    public function getSimilarJobs($chuyen_nganh, $exclude_id, $limit = 4)
    {
        $query = "SELECT v.*, d.ten_cong_ty, d.logo
                  FROM viec_lam v
                  JOIN doanh_nghiep d ON v.doanh_nghiep_id = d.id
                  WHERE v.chuyen_nganh = ? AND v.id != ? AND v.trang_thai = 1
                  ORDER BY v.ngay_tao DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log('Lỗi: Không thể chuẩn bị truy vấn trong getSimilarJobs: ' . $this->conn->error);
            return false;
        }
        $stmt->bind_param('sii', $chuyen_nganh, $exclude_id, $limit);
        if (!$stmt->execute()) {
            error_log('Lỗi: Thực thi truy vấn thất bại trong getSimilarJobs: ' . $stmt->error);
            return false;
        }
        return $stmt->get_result();
    }

    public function getAllCompanies() {
        $sql = "SELECT * FROM doanh_nghiep WHERE trang_thai = 1 ORDER BY ten_cong_ty ASC";
        $result = $this->conn->query($sql);
        $companies = [];
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }
        return $companies;
    }

    public function getCompaniesByPage($page = 1, $perPage = 8, $search = '', $linh_vuc = '', $quy_mo = '') {
        $offset = ($page - 1) * $perPage;
        $where = "WHERE trang_thai = 1";
        if ($search) {
            $search = $this->conn->real_escape_string($search);
            $where .= " AND ten_cong_ty LIKE '%$search%'";
        }
        if ($linh_vuc) {
            $where .= " AND linh_vuc_id = " . intval($linh_vuc);
        }
        if ($quy_mo) {
            $quy_mo = $this->conn->real_escape_string($quy_mo);
            $where .= " AND quy_mo = '$quy_mo'";
        }
        $sql = "SELECT * FROM doanh_nghiep $where ORDER BY ten_cong_ty ASC LIMIT $perPage OFFSET $offset";
        $result = $this->conn->query($sql);
        $companies = [];
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }
        return $companies;
    }

    public function countCompanies($search = '', $linh_vuc = '', $quy_mo = '') {
        $where = "WHERE trang_thai = 1";
        if ($search) {
            $search = $this->conn->real_escape_string($search);
            $where .= " AND ten_cong_ty LIKE '%$search%'";
        }
        if ($linh_vuc) {
            $where .= " AND linh_vuc_id = " . intval($linh_vuc);
        }
        if ($quy_mo) {
            $quy_mo = $this->conn->real_escape_string($quy_mo);
            $where .= " AND quy_mo = '$quy_mo'";
        }
        $sql = "SELECT COUNT(*) as total FROM doanh_nghiep $where";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>