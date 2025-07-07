<?php
class Profile {
    private $conn;

    public function __construct($db) {
        if (!$db instanceof mysqli || $db->connect_error) {
            error_log("Lỗi: Kết nối cơ sở dữ liệu không hợp lệ trong Profile: " . ($db->connect_error ?? 'No connection'));
            throw new Exception("Không thể kết nối cơ sở dữ liệu.");
        }
        $this->conn = $db;
    }

    public function getUserProfile($user_id, $role) {
        try {
            $query = $role === 'sinh_vien' 
                ? "SELECT ho_ten, email, so_dien_thoai, truong_hoc, chuyen_nganh, dia_chi, avatar, cv_pdf FROM sinh_vien WHERE id = ?"
                : "SELECT ten_cong_ty, email, so_dien_thoai, dia_chi, mo_ta, logo, linh_vuc, quy_mo, website, linh_vuc_id FROM doanh_nghiep WHERE id = ?";
            
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                error_log("Lỗi: Không thể chuẩn bị truy vấn trong getUserProfile ($role): " . $this->conn->error);
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi lấy thông tin hồ sơ.'];
            }

            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong getUserProfile ($role): " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi lấy thông tin hồ sơ.'];
            }

            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                error_log("Không tìm thấy hồ sơ cho user_id: $user_id, role: $role");
                $stmt->close();
                return ['status' => 'error', 'message' => 'Không tìm thấy thông tin hồ sơ.'];
            }

            $profile = $result->fetch_assoc();
            $stmt->close();
            return $profile;
        } catch (Exception $e) {
            error_log("Lỗi trong getUserProfile ($role): " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }
    }

    public function updateUserProfile($user_id, $role, $data, $avatar = null, $cv = null) {
        try {
            $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
            $allowed_pdf_types = ['application/pdf'];
            $upload_dir_avatar = '../Assets/images/profile/';
            $upload_dir_cv = '../Assets/files/cv/';

            // Get current profile to delete old files
            $current_profile = $this->getUserProfile($user_id, $role);
            if (isset($current_profile['status']) && $current_profile['status'] === 'error') {
                return $current_profile;
            }

            // Handle avatar upload
            $avatar_filename = null;
            if ($avatar && $avatar['error'] === UPLOAD_ERR_OK) {
                if (!in_array($avatar['type'], $allowed_image_types)) {
                    error_log("Lỗi: Avatar không đúng định dạng (user_id: $user_id, type: {$avatar['type']})");
                    return ['status' => 'error', 'message' => 'Avatar phải là JPEG, PNG hoặc GIF.'];
                }
                if ($avatar['size'] > 5 * 1024 * 1024) {
                    error_log("Lỗi: Avatar vượt quá 5MB (user_id: $user_id, size: {$avatar['size']})");
                    return ['status' => 'error', 'message' => 'Avatar không được vượt quá 5MB.'];
                }
                $avatar_filename = $this->getUniqueFilename($avatar['name'], $upload_dir_avatar);
                if (!move_uploaded_file($avatar['tmp_name'], $upload_dir_avatar . $avatar_filename)) {
                    error_log("Lỗi: Không thể di chuyển file avatar (user_id: $user_id, file: {$avatar['name']})");
                    return ['status' => 'error', 'message' => 'Lỗi khi tải lên avatar.'];
                }
                // Delete old avatar/logo
                $old_file = $role === 'sinh_vien' ? ($current_profile['avatar'] ?? null) : ($current_profile['logo'] ?? null);
                if ($old_file && file_exists($upload_dir_avatar . $old_file)) {
                    unlink($upload_dir_avatar . $old_file);
                }
            }

            // Handle CV upload (only for sinh_vien)
            $cv_filename = null;
            if ($role === 'sinh_vien' && $cv && $cv['error'] === UPLOAD_ERR_OK) {
                if (!in_array($cv['type'], $allowed_pdf_types)) {
                    error_log("Lỗi: CV không đúng định dạng (user_id: $user_id, type: {$cv['type']})");
                    return ['status' => 'error', 'message' => 'CV phải là PDF.'];
                }
                if ($cv['size'] > 10 * 1024 * 1024) {
                    error_log("Lỗi: CV vượt quá 10MB (user_id: $user_id, size: {$cv['size']})");
                    return ['status' => 'error', 'message' => 'CV không được vượt quá 10MB.'];
                }
                $cv_filename = $this->getUniqueFilename($cv['name'], $upload_dir_cv);
                if (!move_uploaded_file($cv['tmp_name'], $upload_dir_cv . $cv_filename)) {
                    error_log("Lỗi: Không thể di chuyển file CV (user_id: $user_id, file: {$cv['name']})");
                    return ['status' => 'error', 'message' => 'Lỗi khi tải lên CV.'];
                }
                // Delete old CV
                if (!empty($current_profile['cv_pdf']) && file_exists($upload_dir_cv . $current_profile['cv_pdf'])) {
                    unlink($upload_dir_cv . $current_profile['cv_pdf']);
                }
            } elseif ($role === 'sinh_vien' && $cv && $cv['error'] !== UPLOAD_ERR_OK) {
                error_log("Lỗi upload CV (user_id: $user_id, error code: {$cv['error']})");
                return ['status' => 'error', 'message' => 'Lỗi khi tải lên CV: Mã lỗi ' . $cv['error']];
            }

            // Sanitize input data
            $data = array_map(function($value) {
                return htmlspecialchars(trim($value));
            }, $data);

            // Prepare SQL query
            if ($role === 'sinh_vien') {
                $query = "UPDATE sinh_vien SET ho_ten = ?, email = ?, so_dien_thoai = ?, truong_hoc = ?, chuyen_nganh = ?, dia_chi = ?" .
                         ($avatar_filename ? ", avatar = ?" : "") .
                         ($cv_filename ? ", cv_pdf = ?" : "") .
                         " WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                if ($stmt === false) {
                    error_log("Lỗi: Không thể chuẩn bị truy vấn trong updateUserProfile (sinh_vien): " . $this->conn->error);
                    return ['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật hồ sơ.'];
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
            } else {
                $query = "UPDATE doanh_nghiep SET ten_cong_ty = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, website = ?, quy_mo = ?, linh_vuc = ?" .
                         ($avatar_filename ? ", logo = ?" : "") .
                         " WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                if ($stmt === false) {
                    error_log("Lỗi: Không thể chuẩn bị truy vấn trong updateUserProfile (doanh_nghiep): " . $this->conn->error);
                    return ['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật hồ sơ.'];
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
            }

            $stmt->bind_param($types, ...$params);
            if (!$stmt->execute()) {
                error_log("Lỗi: Thực thi truy vấn thất bại trong updateUserProfile ($role): " . $stmt->error);
                $stmt->close();
                return ['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật hồ sơ.'];
            }

            $stmt->close();
            return ['status' => 'success', 'message' => 'Cập nhật hồ sơ thành công.'];
        } catch (Exception $e) {
            error_log("Lỗi trong updateUserProfile ($role): " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Lỗi hệ thống. Vui lòng thử lại sau.'];
        }
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