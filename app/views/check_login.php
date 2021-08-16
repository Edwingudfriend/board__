<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    require VIEW_ROOT . '/templates/login_page.php';
} else {
    require VIEW_ROOT . '/templates/home_page.php';
}
