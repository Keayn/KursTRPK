<?php
require_once "../controllers/BasePCTwigController.php";

class SearchController extends BasePCTwigController {
    public $template = "search.twig";

    public function getContext(): array {
        $context = parent::getContext();

        $type = isset($_GET['type']) ? $_GET['type'] : "";
        $title = isset($_GET['title']) ? $_GET['title'] : "";
        $info = isset($_GET['info']) ? $_GET['info'] : "";
        $description = isset($_GET['description']) ? $_GET['description'] : "";

        $sql = <<<EOL
SELECT id, title
FROM pc_objects
WHERE (:title = '' OR title like CONCAT('%', :title, '%'))
        AND (:info = '' OR info like CONCAT('%', :info, '%'))
        AND (:type = '' OR type like CONCAT('%', :type, '%'))
        AND (:description = '' OR type like CONCAT('%', :description, '%'))
EOL;

        $query = $this->pdo->prepare($sql);

        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("info", $info);
        $query->bindValue("type", $type);
        $query->execute();

        $context['type'] = $type;
        $context['description'] = $description;
        $context['title'] = $title;
        $context['info'] = $info;
        $context['pc_objects'] = $query->fetchAll();

        return $context;
    }
}