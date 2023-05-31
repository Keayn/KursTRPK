<?php
require_once "BasePCTwigController.php";

class PCCreateController extends BasePCTwigController {
    public $template = "PC_create.twig";

    public function get(array $context) {
        $query = $this->pdo->query("SELECT type FROM types");
        $types = $query->fetchAll();

        $context['types'] = $types;

        parent::get($context);
    }

    public function getContext():array{

        $context=parent::getContext();
        $query=$this->pdo->prepare("SELECT * FROM types");
        
        $query->execute();
        $types = $query->fetchAll();
        $context['types']=$types;
        
        return $context;
    }

    public function post(array $context) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];

        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];
        move_uploaded_file($tmp_name, "../public/media/$name");
        $image_url = "/media/$name"; // формируем ссылку без адреса сервера

        $sql = <<<EOL
        INSERT INTO pc_objects(title, description, type, info, image)
        VALUES(:title, :description, :type, :info, :image_url) -- передаем переменную в запрос
        EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
        
        $query->execute();

        $context['message'] = 'Вы успешно создали объект';
        $context['id'] = $this->pdo->lastInsertId();

        $this->get($context);
    }
}