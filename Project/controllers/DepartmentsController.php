<?php

require_once __DIR__ . '/../models/Departments.php';

class DepartmentsController
{
    private const MYSQL_DUPLICATE_KEY = 1062;
    private const INDEX_URL = 'index.php?page=departments';
    private const VIEW_DIR = __DIR__ . '/../views/departments/';
    private const ERROR_EMPTY = 'Semua field wajib diisi.';
    private const ERROR_DUPLICATE = 'id sudah terdaftar.';

    private $modelDepartment;
    private $modelLecturer;

    public function __construct($modelDepartment, $modelLecturer)
    {
        $this->modelDepartment = $modelDepartment;
        $this->modelLecturer = $modelLecturer;
    }

    public function index()
    {
        $departments = $this->modelDepartment->getDepartment();
        require self::VIEW_DIR . 'indexDepartment.php';
    }

    public function create()
    {
        $department = ['id' => '', 'name' => '', 'head_department_nidn' => ''];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $department = ['id' => trim($_POST['id'] ?? '')] + $this->readForm();
            $error = $this->validate($department);

            if ($error === '') {
                $this->saveNew($department);
            }

            if ($error === '') {
                $this->redirectToIndex();
            }
        }
        $lecturers = $this->modelLecturer->getLecturers();
        require self::VIEW_DIR . 'createDepartment.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        $department = $id === '' ? null : $this->modelDepartment->getById($id);
        if ($department === null) {
            $this->redirectToIndex();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $department = ['id' => $id] + $this->readForm();
            $error = $this->validate($department);

            if ($error === '') {
                $this->modelDepartment->update($id, $department['name'], $department['head_department_nidn']);
                $this->redirectToIndex();
            }
        }
        $lecturers = $this->modelLecturer->getLecturers();
        require self::VIEW_DIR . 'editDepartment.php';
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToIndex();
        }

        $id = $_POST['id'] ?? '';
        if ($id === '' || $this->modelDepartment->getById($id) === null) {
            $this->redirectToIndex();
        }

        $this->modelDepartment->delete($id);
        $this->redirectToIndex();
    }

    private function validate(array $department)
    {
        return in_array('', $department, true) ? self::ERROR_EMPTY : '';
    }

    private function readForm()
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'head_department_nidn' => trim($_POST['head_department_nidn'] ?? ''),
        ];
    }

    private function saveNew(array $department)
    {
        try {
            $this->modelDepartment->create($department['id'], $department['name'], $department['head_department_nidn']);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() !== self::MYSQL_DUPLICATE_KEY) {
                throw $e;
            }
            return self::ERROR_DUPLICATE;
        }
        return '';
    }

    private function redirectToIndex()
    {
        header('location: ' . self::INDEX_URL);
        exit;
    }
}