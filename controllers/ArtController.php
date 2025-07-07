<?php
class ArtController {
    private $artModel;

    public function __construct($db) {
        $this->artModel = new Art($db);
    }

    public function view($id) {
        $art = $this->artModel->getArtById($id);
        $fs = $this->artModel->getArtForSale($id);
        include_once '../views/art/view.php';
    }
}
?>