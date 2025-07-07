<?php
class Profile {
    public $conn;

    public function __construct($db) {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong Profile: " . ($db->connect_error ?? 'No connection'));
            die("Lỗi: Không thể kết nối cơ sở dữ liệu.");
        }
        $this->conn = $db;
    }

    public function getUserProfile($user_id, $role) {
        if ($role === 'sinh_vien') {
            $query = "SELECT ho_ten, email, so_dien_thoai, truong_hoc, chuyen_nganh, dia_chi, avatar, cv_pdf FROM sinh_vien WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong getUserProfile (sinh_vien): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $stmt->bind_param("i", $user_id);
        } elseif ($role === 'doanh_nghiep') {
            $query = "SELECT ten_cong_ty, email, so_dien_thoai, dia_chi, mo_ta, logo, linh_vuc, quy_mo, website, linh_vuc_id FROM doanh_nghiep WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong getUserProfile (doanh_nghiep): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }
            $stmt->bind_param("i", $user_id);
        } else {
            return ['status' => 'error', 'message' => 'Vai trò không hợp lệ.'];
        }

        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong getUserProfile ($role): " . $stmt->error);
            $stmt->close();
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $profile = $result->fetch_assoc();
            $stmt->close();
            return $profile;
        }

        $stmt->close();
        return ['status' => 'error', 'message' => 'Không tìm thấy thông tin hồ sơ.'];
    }

    public function updateUserProfile($user_id, $role, $data, $avatar = null, $cv = null) {
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        $allowed_pdf_types = ['application/pdf'];
        $upload_dir_avatar = '../Assets/images/profile/';
        $upload_dir_cv = '../Assets/images/profile/';

        // Initialize variables
        $avatar_filename = null;
        $cv_filename = null;

        // Handle avatar upload
        if ($avatar && $avatar['error'] === UPLOAD_ERR_OK) {
            if (!in_array($avatar['type'], $allowed_image_types)) {
                return ['status' => 'error', 'message' => 'Avatar phải là định dạng JPEG, PNG hoặc GIF.'];
            }
            if ($avatar['size'] > 5 * 1024 * 1024) { // 5MB limit
                return ['status' => 'error', 'message' => 'Avatar không được vượt quá 5MB.'];
            }
            $avatar_filename = $this->getUniqueFilename($avatar['name'], $upload_dir_avatar);
            if (!move_uploaded_file($avatar['tmp_name'], $upload_dir_avatar . $avatar_filename)) {
                return ['status' => 'error', 'message' => 'Lỗi khi tải lên avatar.'];
            }
        }

        // Handle CV upload (only for sinh_vien)
        if ($role === 'sinh_vien' && $cv && $cv['error'] === UPLOAD_ERR_OK) {
            if (!in_array($cv['type'], $allowed_pdf_types)) {
                return ['status' => 'error', 'message' => 'CV phải là định dạng PDF.'];
            }
            if ($cv['size'] > 10 * 1024 * 1024) { // 10MB limit
                return ['status' => 'error', 'message' => 'CV không được vượt quá 10MB.'];
            }
            $cv_filename = $this->getUniqueFilename($cv['name'], $upload_dir_cv);
            if (!move_uploaded_file($cv['tmp_name'], $upload_dir_cv . $cv_filename)) {
                return ['status' => 'error', 'message' => 'Lỗi khi tải lên CV.'];
            }
        }

        // Sanitize input data
        $data = array_map(function($value) {
            return htmlspecialchars(trim($value));
        }, $data);

        if ($role === 'sinh_vien') {
            $query = "UPDATE sinh_vien SET ho_ten = ?, email = ?, so_dien_thoai = ?, truong_hoc = ?, chuyen_nganh = ?, dia_chi = ?" .
                     ($avatar_filename ? ", avatar = ?" : "") .
                     ($cv_filename ? ", cv_pdf = ?" : "") .
                     " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong updateUserProfile (sinh_vien): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }

            $params = [
                $data['ho_ten'],
                $data['email'],
                $data['so_dien_thoai'],
                $data['truong_hoc'],
                $data['chuyen_nganh'],
                $data['dia_chi']
            ];
            $types = "ssssss";
            if ($avatar_filename) {
                $params[] = $avatar_filename;
                $types .= "s";
            }
            if ($cv_filename) {
                $params[] = $cv_filename;
                $types .= "s";
            }
            $params[] = $user_id;
            $types .= "i";

            $stmt->bind_param($types, ...$params);
        } elseif ($role === 'doanh_nghiep') {
            $query = "UPDATE doanh_nghiep SET ten_cong_ty = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, website = ?, quy_mo = ?, linh_vuc = ?" .
                     ($avatar_filename ? ", logo = ?" : "") .
                     " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong updateUserProfile (doanh_nghiep): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
            }

            $params = [
                $data['ten_cong_ty'],
                $data['email'],
                $data['so_dien_thoai'],
                $data['dia_chi'],
                $data['website'],
                $data['quy_mo'],
                $data['linh_vuc']
            ];
            $types = "sssssss";
            if ($avatar_filename) {
                $params[] = $avatar_filename;
                $types .= "s";
            }
            $params[] = $user_id;
            $types .= "i";

            $stmt->bind_param($types, ...$params);
        } else {
            return ['status' => 'error', 'message' => 'Vai trò không hợp lệ.'];
        }

        if (!$stmt->execute()) {
            error_log("Lỗi: Thực thi truy vấn thất bại trong updateUserProfile ($role): " . $stmt->error);
            $stmt->close();
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }

        $stmt->close();
        return ['status' => 'success', 'message' => 'Cập nhật hồ sơ thành công.'];
    }

    private function getUniqueFilename($filename, $directory) {
        $pathInfo = pathinfo($filename);
        $base = $pathInfo['filename'];
        $ext = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
        $counter = 1;
        $newFilename = $filename;

        while (file_exists($directory . $newFilename)) {
            $newFilename = $base . '_' . $counter . $ext;
            $counter++;
        }

        return $newFilename;
    }
}
?>