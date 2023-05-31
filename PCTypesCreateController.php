<?php
require_once "BasePCTwigController.php";

class PCTypesCreateController extends BasePCTwigController {
    public $template = "pc_types_create.twig";

    public function get(array $context) {
        parent::get($context);
    }

    public function post(array $context) {
        $type = $_POST['type'];

        
       
        
        

        $sql = <<<EOL
INSERT INTO types(type)
VALUES(:type)
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("type", $type);
        
        
        $query->execute();

        $context['message'] = 'Вы успешно создали объект';
        $context['type'] = $type;

        $this->get($context);
    }
}