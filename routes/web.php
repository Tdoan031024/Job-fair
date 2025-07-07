<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once '../config/connect_database.php';
require_once '../controllers/HomeController.php';
require_once '../controllers/EventController.php';
require_once '../controllers/CompanyController.php';
require_once '../controllers/ContactController.php';
require_once '../controllers/AboutController.php';
require_once '../controllers/BookingController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/ProfileController.php';

$db = (new Database())->getConnection();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController($db);
        $controller->index();
        break;
    case 'event':
        $controller = new EventController($db);
        $controller->index();
        break;
    case 'view_event':
        $controller = new EventController($db);
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $controller->view($id);
        break;
    case 'companies':
        $controller = new CompanyController($db);
        $controller->index();
        break;
    case 'view_company':
        $controller = new CompanyController($db);
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $controller->view($id);
        break;
    case 'contact':
        $controller = new ContactController($db);
        $controller->index();
        break;
    case 'about':
        $controller = new AboutController($db);
        $controller->index();
        break;
    case 'booking':
        $controller = new BookingController($db);
        $controller->index();
        break;
    case 'login':
        $controller = new AuthController($db);
        $controller->login();
        break;
    case 'register':
        $controller = new AuthController($db);
        $controller->register();
        break;
    case 'profile':
        $controller = new ProfileController($db);
        $controller->index();
        break;
    case 'edit_profile':
        $controller = new ProfileController($db);
        $controller->edit();
        break;
    case 'logout':
        $controller = new AuthController($db);
        $controller->logout();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        $error_404_path = '../views/errors/404.php';
        if (file_exists($error_404_path)) {
            include_once $error_404_path;
        } else {
            echo "<h1>404 - Trang Không Tìm Thấy</h1>";
            echo "<p>Xin lỗi, trang bạn đang tìm kiếm không tồn tại.</p>";
            echo '<a href="index.php?page=home">Quay lại trang chủ</a>';
        }
        break;
}
?>