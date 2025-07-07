CREATE DATABASE IF NOT EXISTS `event_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `event_db`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Bảng sinh_vien (bảng mới)
CREATE TABLE `sinh_vien` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ho_ten` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mat_khau` TEXT NOT NULL COMMENT 'Mật khẩu được mã hóa (bcrypt)',
  `so_dien_thoai` VARCHAR(20),
  `truong_hoc` VARCHAR(255),
  `chuyen_nganh` VARCHAR(100),
  `dia_chi` TEXT,
  `avatar` VARCHAR(255) COMMENT 'Đường dẫn đến ảnh đại diện',
  `trang_thai` TINYINT(1) DEFAULT 0 COMMENT '0=pending, 1=active, 2=disabled',
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


-- Bảng audience
CREATE TABLE `audience` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` TEXT NOT NULL,
  `contact` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `event_id` INT NOT NULL,
  `sinh_vien_id` INT,
  `payment_status` TINYINT(1) DEFAULT 0 COMMENT '0=pending, 1=Paid',
  `attendance_status` TINYINT(1) DEFAULT 0 COMMENT '1=present',
  `status` TINYINT(1) DEFAULT 0 COMMENT '0=verification, 1=confirmed, 2=declined',
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`sinh_vien_id`) REFERENCES `sinh_vien` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng banner_slides
CREATE TABLE `banner_slides` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255),
  `subtitle` TEXT,
  `image` VARCHAR(255) NOT NULL,
  `button_text` VARCHAR(100),
  `button_link` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng contact
CREATE TABLE `contact` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `organization` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `contact_method` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `status` TINYINT(1) DEFAULT 0 COMMENT '0=verification, 1=processed, 2=responded',
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng cv_guide_blog
CREATE TABLE `cv_guide_blog` (
  `ma_bai_viet` INT AUTO_INCREMENT PRIMARY KEY,
  `tieu_de` VARCHAR(255) NOT NULL,
  `tom_tat` TEXT,
  `noi_dung` TEXT,
  `hinh_anh` VARCHAR(255),
  `trang_thai` TINYINT(1) DEFAULT 1,
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng cv_guide_blog_images
CREATE TABLE `cv_guide_blog_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ma_bai_viet` INT NOT NULL,
  `hinh_anh` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`ma_bai_viet`) REFERENCES `cv_guide_blog` (`ma_bai_viet`) ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng cv_guide_sample
CREATE TABLE `cv_guide_sample` (
  `ma_mau_cv` INT AUTO_INCREMENT PRIMARY KEY,
  `tieu_de` VARCHAR(255) NOT NULL,
  `mo_ta` TEXT,
  `hinh_anh` VARCHAR(255),
  `tep_tin` VARCHAR(255),
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng linh_vuc
CREATE TABLE `linh_vuc` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ten_linh_vuc` VARCHAR(100) NOT NULL,
  `mo_ta` TEXT
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng doanh_nghiep (đã chỉnh sửa: thêm mat_khau, xóa tai_khoan_id)
CREATE TABLE `doanh_nghiep` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ten_cong_ty` VARCHAR(255) NOT NULL,
  `dia_chi` TEXT NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mat_khau` TEXT NOT NULL COMMENT 'Mật khẩu được mã hóa (bcrypt)',
  `so_dien_thoai` VARCHAR(20) NOT NULL,
  `mo_ta` TEXT,
  `logo` VARCHAR(255),
  `linh_vuc` VARCHAR(100),
  `quy_mo` VARCHAR(50),
  `website` VARCHAR(255),
  `trang_thai` TINYINT(1) DEFAULT 0 COMMENT '0=pending, 1=approved, 2=rejected',
  `linh_vuc_id` INT,
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`linh_vuc_id`) REFERENCES `linh_vuc` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng events
CREATE TABLE `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `venue_id` INT NOT NULL,
  `event` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `schedule` DATETIME NOT NULL,
  `type` TINYINT(1) DEFAULT 1 COMMENT '1=Public, 2=Private',
  `audience_capacity` INT NOT NULL,
  `payment_type` TINYINT(1) DEFAULT 1 COMMENT '1=Free, 2=Payable',
  `amount` DOUBLE DEFAULT 0,
  `banner` TEXT NOT NULL,
  `date_created` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng system_settings
CREATE TABLE `system_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` TEXT NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `contact` VARCHAR(20) NOT NULL,
  `cover_img` TEXT NOT NULL,
  `about_content` TEXT NOT NULL
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng users
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` TEXT NOT NULL,
  `username` VARCHAR(200) NOT NULL,
  `password` TEXT NOT NULL,
  `type` TINYINT(1) DEFAULT 2 COMMENT '1=Admin, 2=Staff'
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng venue
CREATE TABLE `venue` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `venue` TEXT NOT NULL,
  `address` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `rate` FLOAT NOT NULL
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng venue_booking
CREATE TABLE `venue_booking` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` TEXT NOT NULL,
  `address` TEXT NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `contact` VARCHAR(100) NOT NULL,
  `venue_id` INT NOT NULL,
  `duration` VARCHAR(100) NOT NULL,
  `datetime` DATETIME NOT NULL,
  `status` TINYINT(1) DEFAULT 0 COMMENT '0=verification, 1=confirmed, 2=canceled'
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Bảng viec_lam
CREATE TABLE `viec_lam` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `doanh_nghiep_id` INT NOT NULL,
  `tieu_de` VARCHAR(255) NOT NULL,
  `mo_ta` TEXT NOT NULL,
  `yeu_cau` TEXT,
  `chuyen_nganh` VARCHAR(100) NOT NULL,
  `kinh_nghiem` VARCHAR(50) NOT NULL,
  `dia_diem` VARCHAR(100) NOT NULL,
  `luong` VARCHAR(100),
  `han_nop` DATE,
  `so_luong` INT DEFAULT 1,
  `trang_thai` TINYINT(1) DEFAULT 1 COMMENT '1=recruiting, 0=closed',
  `ngay_tao` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`doanh_nghiep_id`) REFERENCES `doanh_nghiep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;


COMMIT;