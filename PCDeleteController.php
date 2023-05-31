<?php

class PCDeleteController extends BaseController {
    public function post(array $context)
    {
        $id = $this->params['id'];

        $query = $this->pdo->prepare("DELETE FROM pc_objects WHERE id = :id");
        $query->bindValue("id", $id);
        $query->execute();

        header("Location: /");
        exit;
    }
}