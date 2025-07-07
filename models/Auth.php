<?php
class AuthModel {
    private $conn;

    public function __construct($db) {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong AuthModel: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu.");
        }
        $this->conn = $db;
    }

    public function authenticate($email, $password) {
        $email = trim($email);
        $password = trim($password);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Email không hợp lệ.'];
        }

        $tables = [
            'sinh_vien' => ['id', 'ho_ten AS name', 'email', 'mat_khau AS password', '\'sinh_vien\' AS role'],
            'doanh_nghiep' => ['id', 'ten_cong_ty AS name', 'email', 'mat_khau AS password', '\'doanh_nghiep\' AS role']
        ];

        foreach ($tables as $table => $columns) {
            $query = "SELECT " . implode(', ', $columns) . " FROM $table WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong authenticate ($table): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong authenticate ($table): " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $stmt->close();
                    return $user;
                } else {
                    $stmt->close();
                    return ['status' => 'error', 'message' => 'Mật khẩu không đúng.'];
                }
            }
            $stmt->close();
        }
        return ['status' => 'error', 'message' => 'Email không tồn tại.'];
    }

    public function register($data, $role) {
        $data = array_map('trim', $data);

        // Kiểm tra các trường bắt buộc chung
        if (empty($data['email']) || empty($data['mat_khau'])) {
            return ['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc (email, mật khẩu).'];
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'error', 'message' => 'Email không hợp lệ.'];
        }

        if (strlen($data['mat_khau']) < 6) {
            return ['status' => 'error', 'message' => 'Mật khẩu phải có ít nhất 6 ký tự.'];
        }

        // Mã hóa mật khẩu
        $hashed_password = password_hash($data['mat_khau'], PASSWORD_DEFAULT);

        if ($role === 'sinh_vien') {
            if (empty($data['ho_ten'])) {
                return ['status' => 'error', 'message' => 'Vui lòng điền họ và tên.'];
            }
            $query = "INSERT INTO sinh_vien (ho_ten, email, mat_khau, so_dien_thoai, truong_hoc, chuyen_nganh, dia_chi) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong register (sinh_vien): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $stmt->bind_param("sssssss", 
                $data['ho_ten'], 
                $data['email'], 
                $hashed_password, 
                $data['so_dien_thoai'], 
                $data['truong_hoc'], 
                $data['chuyen_nganh'], 
                $data['dia_chi']
            );
        } elseif ($role === 'doanh_nghiep') {
            if (empty($data['ten_cong_ty']) || empty($data['dia_chi']) || empty($data['so_dien_thoai'])) {
                return ['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc (tên công ty, địa chỉ, số điện thoại).'];
            }
            $query = "INSERT INTO doanh_nghiep (ten_cong_ty, email, mat_khau, so_dien_thoai, dia_chi, website, quy_mo, linh_vuc_id) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong register (doanh_nghiep): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $stmt->bind_param("sssssssi", 
                $data['ten_cong_ty'], 
                $data['email'], 
                $hashed_password, 
                $data['so_dien_thoai'], 
                $data['dia_chi'], 
                $data['website'], 
                $data['quy_mo'], 
                $data['linh_vuc_id']
            );
        } else {
            return ['status' => 'error', 'message' => 'Vai trò không hợp lệ.'];
        }

        if (!$stmt->execute()) {
            if ($this->conn->errno === 1062) {
                $stmt->close();
                return ['status' => 'error', 'message' => 'Email đã được sử dụng.'];
            }
            error_log("Lỗi: Thực thi truy vấn thất bại trong register ($role): " . $stmt->error);
            $stmt->close();
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }

        $stmt->close();
        return ['status' => 'success', 'message' => 'Đăng ký thành công!'];
    }

    public function getIndustries() {
        $query = "SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC";
        $result = $this->conn->query($query);
        if (!$result) {
            error_log("Lỗi: Truy vấn getIndustries thất bại: " . $this->conn->error);
            return false;
        }
        return $result;
    }
}