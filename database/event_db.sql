-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 05:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audience`
--

CREATE TABLE `audience` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `event_id` int(11) NOT NULL,
  `payment_status` tinyint(1) DEFAULT 0 COMMENT '0=pending, 1=Paid',
  `attendance_status` tinyint(1) DEFAULT 0 COMMENT '1=present',
  `status` tinyint(1) DEFAULT 0 COMMENT '0=verification, 1=confirmed, 2=declined',
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audience`
--

INSERT INTO `audience` (`id`, `name`, `contact`, `email`, `address`, `event_id`, `payment_status`, `attendance_status`, `status`, `date_created`) VALUES
(1, 'Lê Văn An', '0987654321', 'an.le@gmail.com', '12 Nguyễn Trãi, Hà Nội', 1, 1, 0, 1, '2025-06-29 10:00:00'),
(2, 'Phạm Thị Bình', '0971234567', 'binh.pham@gmail.com', '34 Lý Tự Trọng, TP.HCM', 2, 0, 0, 0, '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `banner_slides`
--

CREATE TABLE `banner_slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_slides`
--

INSERT INTO `banner_slides` (`id`, `title`, `subtitle`, `image`, `button_text`, `button_link`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'Sự kiện Công nghệ', 'Tham gia hội thảo', 'huit.png', 'Đăng ký ngay', '', 1, 1, '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `organization` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_method` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0=verification, 1=processed, 2=responded',
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `full_name`, `organization`, `email`, `contact_method`, `message`, `status`, `date_created`) VALUES
(1, 'Nguyễn Thị C', 'Công ty XYZ', 'c.nguyen@gmail.com', 'Email', 'Yêu cầu hỗ trợ sự kiện', 0, '2025-06-29 10:00:00'),
(2, 'Trần Văn D', 'Doanh nghiệp ABC', 'd.tran@gmail.com', 'Phone', 'Hỏi về hội thảo', 1, '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cv_guide_blog`
--

CREATE TABLE `cv_guide_blog` (
  `ma_bai_viet` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `tom_tat` text DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `trang_thai` tinyint(1) DEFAULT 1,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_guide_blog`
--

INSERT INTO `cv_guide_blog` (`ma_bai_viet`, `tieu_de`, `tom_tat`, `noi_dung`, `hinh_anh`, `trang_thai`, `ngay_tao`) VALUES
(1, 'Cách viết CV chuyên nghiệp', 'Hướng dẫn viết CV ấn tượng', 'Nội dung chi tiết về cách viết CV...', '1751853700_IT Intern - Nguyen Thi Huyen Tran.pdf', 1, '2025-06-29 10:00:00'),
(2, 'Mẹo phỏng vấn thành công', 'Chuẩn bị phỏng vấn hiệu quả', 'Nội dung chi tiết về phỏng vấn...', 'interview_tips.jpg', 1, '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cv_guide_blog_images`
--

CREATE TABLE `cv_guide_blog_images` (
  `id` int(11) NOT NULL,
  `ma_bai_viet` int(11) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_guide_blog_images`
--

INSERT INTO `cv_guide_blog_images` (`id`, `ma_bai_viet`, `hinh_anh`) VALUES
(1, 1, 'cv_image_1.jpg'),
(2, 1, 'cv_image_2.jpg'),
(3, 2, 'interview_image_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cv_guide_sample`
--

CREATE TABLE `cv_guide_sample` (
  `ma_mau_cv` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `tep_tin` varchar(255) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_guide_sample`
--

INSERT INTO `cv_guide_sample` (`ma_mau_cv`, `tieu_de`, `mo_ta`, `hinh_anh`, `tep_tin`, `ngay_tao`) VALUES
(1, 'Mẫu CV IT', 'Mẫu CV cho lập trình viên', '1751531805_Screenshot 2025-07-03 153626.png', '1751531805_IT Intern - Nguyen Thi Huyen Tran.pdf', '2025-06-29 10:00:00'),
(2, 'Mẫu CV Marketing', 'Mẫu CV cho ngành marketing', 'cv_marketing.jpg', 'cv_marketing.docx', '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cv_guide_video`
--

CREATE TABLE `cv_guide_video` (
  `id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_guide_video`
--

INSERT INTO `cv_guide_video` (`id`, `tieu_de`, `link`, `ngay_tao`) VALUES
(1, 'Hướng dẫn viết CV cơ bản', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '2025-07-07 09:09:50'),
(2, 'Mẹo phỏng vấn thành công', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '2025-07-07 09:09:50'),
(3, 'Cách trả lời câu hỏi phỏng vấn', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '2025-07-07 09:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `doanh_nghiep`
--

CREATE TABLE `doanh_nghiep` (
  `id` int(11) NOT NULL,
  `ten_cong_ty` varchar(255) NOT NULL,
  `dia_chi` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `linh_vuc` varchar(100) DEFAULT NULL,
  `quy_mo` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `tai_khoan_id` int(11) DEFAULT NULL,
  `trang_thai` tinyint(1) DEFAULT 0 COMMENT '0=pending, 1=approved, 2=rejected',
  `linh_vuc_id` int(11) DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doanh_nghiep`
--

INSERT INTO `doanh_nghiep` (`id`, `ten_cong_ty`, `dia_chi`, `email`, `so_dien_thoai`, `mo_ta`, `logo`, `linh_vuc`, `quy_mo`, `website`, `tai_khoan_id`, `trang_thai`, `linh_vuc_id`, `ngay_tao`) VALUES
(1, 'Công ty TNHH TechVN', '140/5 Lê Minh Xuân, Phường 7, Quận Tân Bình, Thành phố Hồ Chí Minh, Việt Nam', 'vanminh@techvn.vn', '0901234567', 'Công Ty TNHH Tech VN được thành lập với mong muốn trở thành đối tác tin cậy của tất cả các cửa hàng, các doanh nghiệp trong lĩnh vực công nghệ trên khắp cả nước. Là công ty chuyên về dịch vụ công nghệ thông tin:\r\n- Phát triển phần mềm ứng dụng và quản lý, thiết kế website\r\n- Tư vấn, thiết kế, lắp đặt, bảo trì hệ thống mạng\r\n- Cung cấp dịch vụ đăng ký tên miền và lưu trữ website, hosting, sever, vpa\r\nĐồng thời, chúng tôi chuyên phân phối các sản phẩm thiết bị công nghệ, thiết bị lắp đặt hệ thống an ninh & âm thanh.', 'company_1751855831.png', 'Công nghệ thông tin', 'Vừa', 'https://techvn.com', 1, 1, 1, '2025-06-29 10:00:00'),
(2, 'Ngân hàng ABC', '456 Nguyễn Huệ, TP.HCM', 'info@abc.vn', '0912345678', 'Ngân hàng thương mại', 'company_1751855860.png', 'Tài chính', 'Lớn', 'https://abc.vn', 2, 1, 2, '2025-06-29 10:00:00'),
(3, 'Intel', '140 Lê Trọng Tấn ', 'intel@gmail.com', '1234566789', '', 'company_1751420718.png', NULL, 'Lớn', '', NULL, 1, 2, '2025-07-02 08:45:18'),
(4, 'Công ty Cổ phần Tập đoàn Hòa Phát', 'KCN Phố Nối A, Xã Giai Phạm, Huyện Yên Mỹ, Tỉnh Hưng Yên', 'prm@hoaphat.com.vn', '024-62848666', 'Công ty Cổ phần Tập đoàn Hòa Phát (HPG) là một tập đoàn sản xuất công nghiệp hàng đầu Việt Nam, hoạt động trong nhiều lĩnh vực như thép, nội thất, điện lạnh, nông nghiệp và bất động sản. ', 'company_1751855683.png', NULL, 'Lớn', 'https://www.hoaphat.com.vn/gioi-thieu', NULL, 1, 2, '2025-07-07 09:34:43'),
(5, 'CÔNG TY CỔ PHẦN DỊCH VỤ VỆ SĨ MẠNG', 'Số 23 Đường T4A, Phường Tây Thạnh, Quận Tân Phú, Thành phố Hồ Chí Minh, Việt Nam', 'contact@vesimang.org', '0982 504 504', 'Chúng tôi cung cấp các Sản Phẩm, Dịch Vụ, Giải Pháp về CNTT', 'company_1751857060.png', NULL, 'Vừa', 'https://vesimang.org/', NULL, 1, 1, '2025-07-07 09:57:40'),
(6, 'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TBAY', '82A-82B Dân Tộc, Phường Tân Sơn Nhì, Quận Tân Phú, TP. HCM', 'hotro@tbay.vn', '0316776409', 'TBAY chuyên thiết kế Website, các dịch vụ Quảng cáo GOOGLE ADS, Cắt HTML từ file PSD – AI, Đăng kí Tên miền, Hosting, Email. doanh nghiệp, SSL, Chăm sóc Website. Uy tín – Chuyên nghiệp – Công nghệ luôn mới.', 'company_1751857198.jpg', NULL, 'Vừa', 'https://tbay.vn/', NULL, 1, 1, '2025-07-07 09:59:58'),
(7, 'Công ty cổ phần giải pháp và dịch vụ phần mềm Nét Việt', 'Số 5 Đường số 3, Khu phố 2, Phường An Khánh, Thành phố Hồ Chí Minh, Việt Nam', 'info@ids.net.vn', '0388482492', 'CÔNG TY CỔ PHẦN GIẢI PHÁP IDS VIỆT NAM (viết tắt là IDS) được thành lập năm 2013. IDS là kết quả của quá trình hoạt động nhiều năm của các cá nhân hoạt động trong lĩnh vực Điện tử và Công nghệ thông tin. Nhân sự của IDS hiện nay từng là lực lượng chính của các Công ty CNTT có nhiều danh tiếng, trong việc thực hiện các dự án và hợp đồng dịch vụ về CNTT trên toàn quốc.', NULL, NULL, 'Vừa', 'https://www.ids.net.vn/', NULL, 1, 1, '2025-07-07 10:09:38'),
(8, 'https://fpt.vn/vi', 'Tầng 9, Block A, tòa nhà FPT Cầu Giấy, số 10 Phạm Văn Bạch, quận Cầu Giấy, TP. Hà Nội', 'hotrokhachhang@fpt.com', '024 7300 2222', 'Công ty Cổ phần Viễn thông FPT (tên gọi tắt là FPT Telecom) hiện là một trong những nhà cung cấp dịch vụ Viễn thông và Internet hàng đầu khu vực.', 'company_1751858098.png', NULL, 'Vừa', 'https://fpt.vn/vi', NULL, 1, 1, '2025-07-07 10:14:58'),
(9, 'CÔNG TY CỔ PHẦN GIẢI PHÁP VÀ TÍCH HỢP HỆ THỐNG SUNSHINE', 'Số 29A, Đường Núi Thành, Phường 13, Quận Tân Bình, Thành Phố Hồ Chí Minh', 'sunshinesoftware.vn@gmail.com', '0788 999 797', 'Là công ty chuyên gia công phần mềm với bản đồ công nghệ phong phú, kỹ sư trẻ tài năng nhiệt huyết. Sứ mệnh của Sunshine là tạo nên một môi trường công nghệ thích ứng mọi hoàn cảnh - cung cấp cho mọi người công nghệ tốt nhất với giá thành cạnh tranh nhất', 'company_1751858268.png', NULL, 'Lớn', 'https://sunshine.software/', NULL, 1, 1, '2025-07-07 10:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `event` text NOT NULL,
  `description` text NOT NULL,
  `schedule` datetime NOT NULL,
  `type` tinyint(1) DEFAULT 1 COMMENT '1=Public, 2=Private',
  `audience_capacity` int(11) NOT NULL,
  `payment_type` tinyint(1) DEFAULT 1 COMMENT '1=Free, 2=Payable',
  `amount` double DEFAULT 0,
  `banner` text NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `venue_id`, `event`, `description`, `schedule`, `type`, `audience_capacity`, `payment_type`, `amount`, `banner`, `date_created`) VALUES
(1, 1, 'Hội thảo Công nghệ 2025', 'Hội thảo về AI và Blockchain', '2025-07-10 09:00:00', 1, 150, 2, 500000, 'AIinOffice.jpg', '2025-06-29 10:00:00'),
(2, 1, 'Hội nghị Tài chính', 'Cập nhật xu hướng tài chính', '2025-07-15 14:00:00', 1, 100, 1, 0, 'AIinOffice.jpg', '2025-06-29 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `linh_vuc`
--

CREATE TABLE `linh_vuc` (
  `id` int(11) NOT NULL,
  `ten_linh_vuc` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `linh_vuc`
--

INSERT INTO `linh_vuc` (`id`, `ten_linh_vuc`, `mo_ta`) VALUES
(1, 'Công nghệ thông tin', 'Lĩnh vực phát triển phần mềm và dịch vụ công nghệ'),
(2, 'Tài chính', 'Lĩnh vực ngân hàng và đầu tư');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Trung tâm đổi mới sáng tạo và khởi nghiệp ', 'hotrosinhvien@hufi.edu.vn', '096 362 11 24', 'cover.jpg', 'Hệ thống quản lý sự kiện và việc làm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) DEFAULT 2 COMMENT '1=Admin, 2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'Tuyên Đoán', 'admin', 'admin123', 1),
(2, 'Trần Thị Staff', 'staff1', 'hashed_password_456', 2);

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `id` int(11) NOT NULL,
  `venue` text NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`id`, `venue`, `address`, `description`, `rate`) VALUES
(1, 'Hội trường A', '789 Lê Lợi, Hà Nội', 'Hội trường lớn, sức chứa 200 người', 5000000),
(2, 'Sảnh B', '101 Trần Phú, TP.HCM', 'Sảnh sang trọng, sức chứa 150 người', 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `venue_booking`
--

CREATE TABLE `venue_booking` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0=verification, 1=confirmed, 2=canceled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_booking`
--

INSERT INTO `venue_booking` (`id`, `name`, `address`, `email`, `contact`, `venue_id`, `duration`, `datetime`, `status`) VALUES
(1, 'Công ty TechVN', '123 Đường Láng, Hà Nội', 'contact@techvn.com', '0901234567', 1, '3 giờ', '2025-07-10 09:00:00', 1),
(2, 'Ngân hàng ABC', '456 Nguyễn Huệ, TP.HCM', 'info@abc.vn', '0912345678', 2, '2 giờ', '2025-07-15 14:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `viec_lam`
--

CREATE TABLE `viec_lam` (
  `id` int(11) NOT NULL,
  `doanh_nghiep_id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `mo_ta` text NOT NULL,
  `yeu_cau` text DEFAULT NULL,
  `chuyen_nganh` varchar(100) NOT NULL,
  `kinh_nghiem` varchar(50) NOT NULL,
  `dia_diem` varchar(100) NOT NULL,
  `luong` varchar(100) DEFAULT NULL,
  `han_nop` date DEFAULT NULL,
  `so_luong` int(11) DEFAULT 1,
  `trang_thai` tinyint(1) DEFAULT 1 COMMENT '1=recruiting, 0=closed',
  `ngay_tao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viec_lam`
--

INSERT INTO `viec_lam` (`id`, `doanh_nghiep_id`, `tieu_de`, `mo_ta`, `yeu_cau`, `chuyen_nganh`, `kinh_nghiem`, `dia_diem`, `luong`, `han_nop`, `so_luong`, `trang_thai`, `ngay_tao`) VALUES
(1, 1, 'Lập trình viên Python', 'Phát triển ứng dụng web', 'Biết Python, Django', 'Công nghệ thông tin', '2 năm', 'Hà Nội', '20-30 triệu', '2025-07-15', 2, 1, '2025-06-29 10:00:00'),
(2, 2, 'Chuyên viên tài chính', 'Quản lý đầu tư', 'Tốt nghiệp tài chính', 'Tài chính', '3 năm', 'TP.HCM', '25-35 triệu', '2025-07-20', 1, 1, '2025-06-29 10:00:00'),
(3, 3, 'Backend Developer (Java) intern', 'Mục đích công việc :\r\n- Phát triển các nội dung xử lý phía back-end theo yêu cầu dự án\r\n- Phát triển API kết nối với front-end hay đối tác\r\n- Đảm bảo các tiêu chuẩn bảo mật và mã hóa\r\n- Tuân thủ quy trình/quy định của HDBank\r\n\r\nNhiệm vụ :\r\n- Có ít nhất 3 năm kinh nghiệm trong lĩnh vực phát triển phần mềm ở vị trí backend\r\n- Đã từng tham gia ít nhất 4-5 dự án trong đó đảm nhiệm việc phát triển back-end; hoặc 2 dự án lớn (có 5 người tham gia trở lên)', '- Thành thạo với ngôn ngữ lập trình .Net/Java\r\n- Có kinh nghiệm về PL/SQL \r\n- Có kinh nghiệm phát triển  API Web Services, tương tác với API và sử dụng thành thạo các công cụ lập trình như Eclipse, Netbean\r\n- Thành thạo về Java core Back-End, xử lý tốt Multithread (Xử lý tối thiểu 1000-2000 giao dịch cùng lúc), Multi-processing, cơ chế Hash table, cơ chế xử lý file.\r\n- Có kinh nghiệm về các tiêu chuẩn bảo mật\r\n- Thành thạo việc thiết kế CSDL trên DB Oracle, MS SQL …\r\n- Có kinh nghiệm làm việc với các hệ điều hành Enterprise Linux, HP-UX\r\n- Có kinh nghiệm về SVN, GIT, Jira;\r\n- Có kinh nghiệm với các quy tắc thiết kế OOP;\r\n- Có kinh nghiệm về các dự án ESB, Open API\r\n- Có hiểu biết về Docker và Microservices, MQ, cache...,mockup API', 'Công nghệ thông tin', 'Không cần kinh nghiệm', 'Thủ Đức, TP.HCM', '10000000', '2025-07-11', 2, 1, '2025-07-03 14:34:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audience`
--
ALTER TABLE `audience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_slides`
--
ALTER TABLE `banner_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cv_guide_blog`
--
ALTER TABLE `cv_guide_blog`
  ADD PRIMARY KEY (`ma_bai_viet`);

--
-- Indexes for table `cv_guide_blog_images`
--
ALTER TABLE `cv_guide_blog_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ma_bai_viet` (`ma_bai_viet`);

--
-- Indexes for table `cv_guide_sample`
--
ALTER TABLE `cv_guide_sample`
  ADD PRIMARY KEY (`ma_mau_cv`);

--
-- Indexes for table `cv_guide_video`
--
ALTER TABLE `cv_guide_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doanh_nghiep`
--
ALTER TABLE `doanh_nghiep`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `linh_vuc_id` (`linh_vuc_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linh_vuc`
--
ALTER TABLE `linh_vuc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue_booking`
--
ALTER TABLE `venue_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viec_lam`
--
ALTER TABLE `viec_lam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doanh_nghiep_id` (`doanh_nghiep_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audience`
--
ALTER TABLE `audience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner_slides`
--
ALTER TABLE `banner_slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cv_guide_blog`
--
ALTER TABLE `cv_guide_blog`
  MODIFY `ma_bai_viet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cv_guide_blog_images`
--
ALTER TABLE `cv_guide_blog_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cv_guide_sample`
--
ALTER TABLE `cv_guide_sample`
  MODIFY `ma_mau_cv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cv_guide_video`
--
ALTER TABLE `cv_guide_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doanh_nghiep`
--
ALTER TABLE `doanh_nghiep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `linh_vuc`
--
ALTER TABLE `linh_vuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venue_booking`
--
ALTER TABLE `venue_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `viec_lam`
--
ALTER TABLE `viec_lam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cv_guide_blog_images`
--
ALTER TABLE `cv_guide_blog_images`
  ADD CONSTRAINT `cv_guide_blog_images_ibfk_1` FOREIGN KEY (`ma_bai_viet`) REFERENCES `cv_guide_blog` (`ma_bai_viet`) ON DELETE CASCADE;

--
-- Constraints for table `doanh_nghiep`
--
ALTER TABLE `doanh_nghiep`
  ADD CONSTRAINT `doanh_nghiep_ibfk_1` FOREIGN KEY (`linh_vuc_id`) REFERENCES `linh_vuc` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `viec_lam`
--
ALTER TABLE `viec_lam`
  ADD CONSTRAINT `viec_lam_ibfk_1` FOREIGN KEY (`doanh_nghiep_id`) REFERENCES `doanh_nghiep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
