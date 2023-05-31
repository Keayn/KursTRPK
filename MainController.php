<?php
require_once "../controllers/BasePCTwigController.php";

class MainController extends BasePCTwigController {
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array {
        $context = parent::getContext();

        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM pc_objects WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM pc_objects");
        }

        $context['pc_objects'] = $query->fetchAll();

        return $context;
    }
}

?>