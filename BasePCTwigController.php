<?php

class BasePCTwigController extends TwigBaseController {
    public function getContext() : array {
        $context = parent::getContext();
        
        
        $query = $this->pdo->query("SELECT DISTINCT type FROM pc_objects ORDER BY 1");
        $types = $query->fetchAll();
        $context['types'] = $types;

        $context['history'] = $_SESSION['history'];

        $context['is_logged'] = isset($_SESSION['is_logged']) ? $_SESSION['is_logged'] : false;

        return $context;
    }
}

?>