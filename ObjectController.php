<?php
require_once "../controllers/BasePCTwigController.php";

class ObjectController extends BasePCTwigController {
    public $template = "__object.twig";
    public $nav = [
        [
            "section_name" => "Картинка",
            "section" => "image"
        ],
        [
            "section_name" => "Описание",
            "section" => "info"
        ],
    ];

    public function chooseTemplate() {
        if (isset($_GET['show'])) {
            if ($_GET['show'] == "image") {
                $this->template = "character_image.twig";
            } elseif ($_GET['show'] == "info") {
                $this->template = "character_info.twig";
            }
        }
    }

    public function getContext(): array {
        $context = parent::getContext();

        $query_statement = "SELECT title, description FROM pc_objects WHERE id = :pc_id";

        if (isset($_GET['show'])) {
            $context['section'] = $_GET['show'];

            if ($_GET['show'] == "image") {
                $query_statement = "SELECT title, description, image AS section_data FROM pc_objects WHERE id = :pc_id";
            } elseif ($_GET['show'] == "info") {
                $query_statement = "SELECT title, description, info AS section_data FROM pc_objects WHERE id = :pc_id";
            }
        }

        $query = $this->pdo->prepare($query_statement);
        $query->bindValue("pc_id", $this->params['id']);
        $query->execute();
        $data = $query->fetch();

        $context['title'] = $data['title'];
        $context['description'] = $data['description'];

        if (isset($data['section_data'])) {
            $context['section_data'] = $data['section_data'];
        }

        $context['id'] = $this->params['id'];
        $context['nav'] = $this->nav;

        $pc_query = $this->pdo->query("SELECT title, id FROM pc_objects");
        $pc_data = $pc_query->fetchAll();

        $pc_objects = [];
        foreach ($pc_data as $item) {
            array_push($pc_objects, [
                "title" => $item['title'],
                "id" => $item['id']
            ]);
        }

        $context['pc_objects'] = $pc_objects;

        return $context;
    }
}
