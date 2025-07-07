<?php
class Company
{
    private $conn;

    public function __construct($db)
    {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong Company model: " . ($db->connect_error ?? 'No connection'));
            throw new Exception("Không thể kết nối cơ sở dữ liệu trong Company model.");
        }
        $this->conn = $db;
    }

    public function getCompanies($search = '', $linh_vuc = '', $quy_mo = '', $limit = 0)
    {
        try {
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
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong getCompanies: " . $stmt->error);
                $stmt->close();
                return false;
            }
            $result = $stmt->get_result();
            $stmt->close();
            error_log("getCompanies trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong getCompanies: " . $e->getMessage());
            return false;
        }
    }

    public function getCompanyById($id)
    {
        try {
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
                $stmt->close();
                return false;
            }
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong getCompanyById: " . $e->getMessage());
            return false;
        }
    }

    public function getJobsByCompanyId($id)
    {
        try {
            $query = "SELECT id, tieu_de, mo_ta, yeu_cau, chuyen_nganh, kinh_nghiem, dia_diem, luong, han_nop, so_luong, trang_thai, ngay_tao 
                      FROM viec_lam WHERE doanh_nghiep_id = ? ORDER BY ngay_tao DESC";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong getJobsByCompanyId: " . $this->conn->error);
                return false;
            }
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong getJobsByCompanyId: " . $stmt->error);
                $stmt->close();
                return false;
            }
            $result = $stmt->get_result();
            $stmt->close();
            error_log("getJobsByCompanyId trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong getJobsByCompanyId: " . $e->getMessage());
            return false;
        }
    }

    public function getJobById($id, $doanh_nghiep_id = null)
    {
        try {
            $query = "SELECT id, tieu_de, mo_ta, yeu_cau, chuyen_nganh, kinh_nghiem, dia_diem, luong, han_nop, so_luong, trang_thai, ngay_tao 
                      FROM viec_lam WHERE id = ?";
            $types = "i";
            $params = [$id];

            if ($doanh_nghiep_id !== null) {
                $query .= " AND doanh_nghiep_id = ?";
                $types .= "i";
                $params[] = $doanh_nghiep_id;
            }

            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong getJobById: " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi lấy thông tin việc làm.'];
            }
            $stmt->bind_param($types, ...$params);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong getJobById: " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi lấy thông tin việc làm.'];
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                error_log("Không tìm thấy việc làm: job_id=$id, doanh_nghiep_id=" . ($doanh_nghiep_id ?? 'null'));
                $stmt->close();
                return ['status' => 'error', 'message' => 'Không tìm thấy việc làm.'];
            }
            $job = $result->fetch_assoc();
            $stmt->close();
            return $job;
        } catch (Exception $e) {
            error_log("Lỗi trong getJobById: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }
    }

    public function addJob($doanh_nghiep_id, $data)
    {
        try {
            $data = array_map(function($value) {
                return htmlspecialchars(trim($value ?? ''));
            }, $data);

            // Đảm bảo các trường không null có giá trị mặc định
            $data['yeu_cau'] = $data['yeu_cau'] ?? '';
            $data['chuyen_nganh'] = $data['chuyen_nganh'] ?? '';
            $data['kinh_nghiem'] = $data['kinh_nghiem'] ?? '';
            $data['dia_diem'] = $data['dia_diem'] ?? '';
            $data['luong'] = $data['luong'] ?? '';
            $data['han_nop'] = $data['han_nop'] ? date('Y-m-d', strtotime($data['han_nop'])) : date('Y-m-d', strtotime('+30 days'));
            $data['so_luong'] = isset($data['so_luong']) && is_numeric($data['so_luong']) ? (int)$data['so_luong'] : 1;
            $data['trang_thai'] = isset($data['trang_thai']) && is_numeric($data['trang_thai']) ? (int)$data['trang_thai'] : 1;

            $query = "INSERT INTO viec_lam (doanh_nghiep_id, tieu_de, mo_ta, yeu_cau, chuyen_nganh, kinh_nghiem, dia_diem, luong, han_nop, so_luong, trang_thai, ngay_tao) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong addJob: " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi thêm việc làm: Truy vấn không hợp lệ.'];
            }
            $stmt->bind_param("issssssssis", 
                $doanh_nghiep_id, 
                $data['tieu_de'], 
                $data['mo_ta'], 
                $data['yeu_cau'], 
                $data['chuyen_nganh'], 
                $data['kinh_nghiem'], 
                $data['dia_diem'], 
                $data['luong'], 
                $data['han_nop'], 
                $data['so_luong'], 
                $data['trang_thai']
            );
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong addJob: " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi thêm việc làm: ' . $stmt->error];
            }
            $stmt->close();
            return ['status' => 'success', 'message' => 'Thêm việc làm thành công.'];
        } catch (Exception $e) {
            error_log("Lỗi trong addJob: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau: ' . $e->getMessage()];
        }
    }

    public function updateJob($job_id, $doanh_nghiep_id, $data)
    {
        try {
            $data = array_map(function($value) {
                return htmlspecialchars(trim($value ?? ''));
            }, $data);

            // Đảm bảo các trường không null có giá trị mặc định
            $data['yeu_cau'] = $data['yeu_cau'] ?? '';
            $data['chuyen_nganh'] = $data['chuyen_nganh'] ?? '';
            $data['kinh_nghiem'] = $data['kinh_nghiem'] ?? '';
            $data['dia_diem'] = $data['dia_diem'] ?? '';
            $data['luong'] = $data['luong'] ?? '';
            $data['han_nop'] = $data['han_nop'] ? date('Y-m-d', strtotime($data['han_nop'])) : date('Y-m-d', strtotime('+30 days'));
            $data['so_luong'] = isset($data['so_luong']) && is_numeric($data['so_luong']) ? (int)$data['so_luong'] : 1;
            $data['trang_thai'] = isset($data['trang_thai']) && is_numeric($data['trang_thai']) ? (int)$data['trang_thai'] : 1;

            $query = "UPDATE viec_lam SET tieu_de = ?, mo_ta = ?, yeu_cau = ?, chuyen_nganh = ?, kinh_nghiem = ?, dia_diem = ?, luong = ?, han_nop = ?, so_luong = ?, trang_thai = ? 
                      WHERE id = ? AND doanh_nghiep_id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong updateJob: " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật việc làm: Truy vấn không hợp lệ.'];
            }
            $stmt->bind_param("ssssssssisii", 
                $data['tieu_de'], 
                $data['mo_ta'], 
                $data['yeu_cau'], 
                $data['chuyen_nganh'], 
                $data['kinh_nghiem'], 
                $data['dia_diem'], 
                $data['luong'], 
                $data['han_nop'], 
                $data['so_luong'], 
                $data['trang_thai'], 
                $job_id, 
                $doanh_nghiep_id
            );
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong updateJob: " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật việc làm: ' . $stmt->error];
            }
            if ($stmt->affected_rows === 0) {
                error_log("Không tìm thấy việc làm để cập nhật: job_id=$job_id, doanh_nghiep_id=$doanh_nghiep_id");
                $stmt->close();
                return ['status' => 'error', 'message' => 'Không tìm thấy việc làm hoặc bạn không có quyền chỉnh sửa.'];
            }
            $stmt->close();
            return ['status' => 'success', 'message' => 'Cập nhật việc làm thành công.'];
        } catch (Exception $e) {
            error_log("Lỗi trong updateJob: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau: ' . $e->getMessage()];
        }
    }

    public function deleteJob($job_id, $doanh_nghiep_id)
    {
        try {
            $query = "DELETE FROM viec_lam WHERE id = ? AND doanh_nghiep_id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong deleteJob: " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi xóa việc làm: Truy vấn không hợp lệ.'];
            }
            $stmt->bind_param("ii", $job_id, $doanh_nghiep_id);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong deleteJob: " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi xóa việc làm: ' . $stmt->error];
            }
            if ($stmt->affected_rows === 0) {
                error_log("Không tìm thấy việc làm để xóa: job_id=$job_id, doanh_nghiep_id=$doanh_nghiep_id");
                $stmt->close();
                return ['status' => 'error', 'message' => 'Không tìm thấy việc làm hoặc bạn không có quyền xóa.'];
            }
            $stmt->close();
            return ['status' => 'success', 'message' => 'Xóa việc làm thành công.'];
        } catch (Exception $e) {
            error_log("Lỗi trong deleteJob: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau: ' . $e->getMessage()];
        }
    }

    public function getIndustries()
    {
        try {
            $query = "SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC";
            $result = $this->conn->query($query);
            if (!$result) {
                error_log("Lỗi: Truy vấn getIndustries thất bại: " . $this->conn->error);
                return false;
            }
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong getIndustries: " . $e->getMessage());
            return false;
        }
    }

    public function getTotalCompanies()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM doanh_nghiep";
            $result = $this->conn->query($query);
            if (!$result) {
                error_log("Lỗi: Truy vấn getTotalCompanies thất bại: " . $this->conn->error);
                return 0;
            }
            return $result->fetch_assoc()['count'];
        } catch (Exception $e) {
            error_log("Lỗi trong getTotalCompanies: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalJobs()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM viec_lam";
            $result = $this->conn->query($query);
            if (!$result) {
                error_log("Lỗi: Truy vấn getTotalJobs thất bại: " . $this->conn->error);
                return 0;
            }
            return $result->fetch_assoc()['count'];
        } catch (Exception $e) {
            error_log("Lỗi trong getTotalJobs: " . $e->getMessage());
            return 0;
        }
    }

    public function getTopCompanies()
    {
        try {
            $query = "SELECT d.*, l.ten_linh_vuc 
                      FROM doanh_nghiep d 
                      LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id 
                      ORDER BY d.id ASC";
            $result = $this->conn->query($query);
            if (!$result) {
                error_log("Lỗi: Truy vấn getTopCompanies thất bại: " . $this->conn->error);
                return false;
            }
            error_log("getTopCompanies trả về " . ($result ? $result->num_rows : 0) . " bản ghi");
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi trong getTopCompanies: " . $e->getMessage());
            return false;
        }
    }
}
?>