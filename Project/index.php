<?php
require_once 'Config.php';
require_once 'models/Lecturers.php';
require_once 'controllers/LecturersController.php';

const DEFAULT_ACTION = 'index';
const ALLOWED_ACTIONS = ['index', 'create', 'edit', 'delete'];

$action = $_GET['action'] ?? DEFAULT_ACTION;
// Whitelist mencegah method lain (misalnya private) dipanggil lewat URL.
if (!in_array($action, ALLOWED_ACTIONS, true)) {
  $action = DEFAULT_ACTION;
}

$model = new Lecturers($db_host, $db_user, $db_pass, $db_name);
$model->open();

$controller = new LecturersController($model);
$controller->$action();