<?php
// Đảm bảo không có khoảng trắng trước <?php
// Start output buffering
ob_start();

// Khởi tạo session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once '../config/connect_database.php';
try {
    $db = (new Database())->getConnection();
} catch (Exception $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

// System name with sanitization
$systemName = isset($_SESSION['system']['name']) ? htmlspecialchars($_SESSION['system']['name']) : 'HUIT IEC';
$loggedIn = isset($_SESSION['user_id']);
$username = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : '';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HUIT IEC - Nền tảng Giáo dục và Sự nghiệp Quốc tế">
    <meta name="author" content="HUIT IEC Team">
    <title><?php echo $systemName; ?></title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300italic,400,400italic,700,700italic"
        rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="../assets/css/jquery.datetimepicker.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="../assets/css/select2.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="../assets/css/header.css" rel="stylesheet">
    <link href="../assets/css/profile-icon.css" rel="stylesheet">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg custom-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="./index.php" style="margin-left: -40px;">
                <img src="../assets/images/IEC/logoiec.jpg" alt="Logo" width="250" class="mr-3">
                <!-- <span class="brand-text"><?php echo $systemName; ?></span> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : ''; ?>"
                            href="index.php?page=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'event') ? 'active' : ''; ?>"
                            href="index.php?page=event">Sự kiện</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'companies') ? 'active' : ''; ?>"
                            href="index.php?page=companies">Doanh nghiệp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'about') ? 'active' : ''; ?>"
                            href="index.php?page=about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'contact') ? 'active' : ''; ?>"
                            href="index.php?page=contact">Liên hệ</a>
                    </li>
                </ul>

                <!-- Login / Profile icon -->
                <ul class="navbar-nav ml-3">
                    <?php if ($loggedIn): ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link profile-icon" href="index.php?page=profile" title="Trang cá nhân">
                            <i class="fas fa-user-circle"></i>

                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <span class="username ml-2"><?php echo $username; ?></span>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm ml-lg-2" href="index.php?page=login">Đăng nhập</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script>
    window.addEventListener('load', function() {
        adjustContentPadding();
    });
    window.addEventListener('resize', function() {
        adjustContentPadding();
    });

    function adjustContentPadding() {
        const header = document.querySelector('.custom-navbar');
        const content = document.querySelector('body');
        const headerHeight = header.offsetHeight;
        content.style.paddingTop = `${headerHeight}px`;
    }
    </script>
</body>

</html>