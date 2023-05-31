<?php
require_once "../controllers/BasePCTwigController.php";

class Controller404 extends BasePCTwigController {
    public $template = "404.twig"; 
    public $title = "Страница не найдена";

    public function get(array $context) {
        http_response_code(404);
        parent::get($context);
    }
}

?>