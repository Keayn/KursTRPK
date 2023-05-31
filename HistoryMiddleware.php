<?php

class HistoryMiddleware extends BaseMiddleware {
    public function apply(BaseController $controller, array $context) {
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }

        if (sizeof($_SESSION['history']) > 10) {
            array_shift($_SESSION['history']);
        }

        array_push($_SESSION['history'], $_SERVER["REQUEST_URI"]);
    }
}