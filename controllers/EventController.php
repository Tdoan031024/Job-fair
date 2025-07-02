<?php
class EventController {
    private $eventModel;

    public function __construct($db) {
        $this->eventModel = new Event($db);
    }

    public function index() {
        $events = $this->eventModel->getAllEvents(); // ← Sửa dòng này
        include_once '../views/event/index.php';
    }

    public function view($id) {
        $event = $this->eventModel->getEventById($id);
        include_once '../views/event/view.php';
    }
}
?>