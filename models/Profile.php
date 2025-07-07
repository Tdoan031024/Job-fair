<?php
class Profile
{
    private $conn;

    public function __construct($db)
    {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu.");
        }
        $this->conn = $db;
    }

    public function getUserProfile($user_id, $role)
    {
        error_log("Bắt đầu truy vấn cho user_id: $user_id, role: $role");
        if (empty($user_id) || empty($role)) {
            error_log("Lỗi: user_id hoặc role không hợp lệ: user_id=$user_id, role=$role");
            return false;
        }

        $user_info = [];
        if ($role === 'sinh_vien') {
            $query = "SELECT ho_ten, email, so_dien_thoai, truong_hoc, chuyen_nganh, dia_chi, avatar, cv FROM sinh_vien WHERE id = ? AND trang_thai = 1";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi chuẩn bị truy vấn (sinh_vien): " . $this->conn->error);
                return false;
            }
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_info = $result->fetch_assoc();
            error_log("Kết quả truy vấn sinh_vien: " . json_encode($user_info));
            $stmt->close();
        } elseif ($role === 'doanh_nghiep') {
            $query = "SELECT ten_cong_ty, email, so_dien_thoai, dia_chi, website, quy_mo, linh_vuc_id, logo, cv FROM doanh_nghiep WHERE id = ? AND trang_thai = 1";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi chuẩn bị truy vấn (doanh_nghiep): " . $this->conn->error);
                return false;
            }
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_info = $result->fetch_assoc();
            if ($user_info && $user_info['linh_vuc_id']) {
                $query = "SELECT ten_linh_vuc FROM linh_vuc WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("i", $user_info['linh_vuc_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_info['linh_vuc'] = $result->fetch_assoc()['ten_linh_vuc'] ?? 'Không xác định';
                $stmt->close();
            }
            error_log("Kết quả truy vấn doanh_nghiep: " . json_encode($user_info));
        }

        if (!$user_info) {
            error_log("Không tìm thấy thông tin cho user_id: $user_id, role: $role");
            return false;
        }
        return $user_info;
    }
}