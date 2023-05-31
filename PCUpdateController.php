<?php
require_once "BasePCTwigController.php";

class PCUpdateController extends BasePCTwigController {
    public $template = "pc_update.twig";

    public function get(array $context) // добавили параметр
    {
        $id = $this->params['id'];

        $sql = <<<EOL
    SELECT * FROM pc_objects WHERE id=:id
    EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();

        $data = $query->fetch();

        $context['object'] = $data;
        parent::get($context);
    }

    public function post(array $context) { // добавили параметр
        $title = $_POST['title'];
        $type = $_POST['type'];
        $info = $_POST['info'];

        $sql = <<<EOL
UPDATE pc_objects
SET title = :title, type = :type, info =:info
WHERE id =:id
EOL;
        $query = $this->pdo->prepare($sql);

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            move_uploaded_file($tmp_name, "../public/media/$image_name");
            $image_url = "/media/$image_name";

            $sql = <<<EOL
UPDATE pc_objects
SET title = :title, type = :type, info =:info, image =:image_url
WHERE id =:id
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue("image_url", $image_url);
        }
        $query->bindValue("title", $title);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("id", $this->params['id']);
        
        $query->execute();
        
        $context['message'] = 'Вы успешно изменили объект';
        $context['id'] = $this->params['id'];

        $this->get($context);
    }
}