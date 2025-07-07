<?php
class VenueController {
    private $venueModel;

    public function __construct($db) {
        $this->venueModel = new Venue($db);
    }

    public function index() {
        $venues = $this->venueModel->getVenues();
        include_once '../views/venue/index.php';
    }

    public function view($id) {
        $venue = $this->venueModel->getVenueById($id);
        include_once '../views/venue/view.php';
    }
}
?>