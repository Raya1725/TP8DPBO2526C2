<?php
require_once 'Config.php';
require_once 'models/Lecturers.php';
require_once 'models/Departments.php';
require_once 'controllers/LecturersController.php';
require_once 'controllers/DepartmentsController.php';

const DEFAULT_ACTION = 'index';
const ALLOWED_ACTIONS = ['index', 'create', 'edit', 'delete'];
const DEFAULT_PAGE = 'lecturers';
const ALLOWED_PAGE = ['lecturers', 'departments'];
const DEPARTMENT_PAGE = 'departments';

$action = $_GET['action'] ?? DEFAULT_ACTION;
$page = $_GET['page'] ?? DEFAULT_PAGE;
// Whitelist mencegah method lain (misalnya private) dipanggil lewat URL.
if (!in_array($action, ALLOWED_ACTIONS, true)) {
  $action = DEFAULT_ACTION;
}

if (!in_array($page, ALLOWED_PAGE, true)) {
  $page = DEFAULT_PAGE;
}

if ($page === DEPARTMENT_PAGE) {
  $modelDepartment = new Departments($db_host, $db_user, $db_pass, $db_name);
  $modelDepartment->open();

  $modelLecturer = new Lecturers($db_host, $db_user, $db_pass, $db_name);
  $modelLecturer->open();

  $controllerDepartment = new DepartmentsController($modelDepartment, $modelLecturer);
  $controllerDepartment->$action();
} else {
  $modelLecturer = new Lecturers($db_host, $db_user, $db_pass, $db_name);
  $modelLecturer->open();

  $controllerLecturer = new LecturersController($modelLecturer);
  $controllerLecturer->$action();
}