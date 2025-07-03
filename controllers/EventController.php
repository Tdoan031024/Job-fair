<?php
class EventController
{
    private $eventModel;

    public function __construct($db)
    {
        $this->eventModel = new Event($db);
    }

    public function index()
    {
        $events = $this->eventModel->getAllEvents();

        include_once '../views/event/index.php';
    }

    public function view($id)
    {
        error_log("ID được truyền vào: $id");
        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            include_once '../views/errors/404.php';
            return;
        }
        include_once '../views/event/view.php';
    }
}