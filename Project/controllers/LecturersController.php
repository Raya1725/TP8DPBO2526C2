<?php
/*****************************************
 * Filename : LecturersController.php
 * Programmer : Renaldy Heryana
 * Date : 19-11-2026
 * Email : renaldyheryana2@gmail.com
 * Deskripsi : controller untuk CRUD data dosen
 *
 *****************************************/

require_once __DIR__ . '/../models/Lecturers.php';

class LecturersController
{
    private const MYSQL_DUPLICATE_KEY = 1062;
    private const MYSQL_ERROR_FOREIGN = 1451;
    private const INDEX_URL = 'index.php?page=lecturers;';
    private const VIEW_DIR = __DIR__ . '/../views/lecturers/';
    private const ERROR_EMPTY = 'Semua field wajib diisi.';
    private const ERROR_DUPLICATE = 'NIDN sudah terdaftar.';

    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Menampilkan semua dosen.
     *
     * Kompleksitas: waktu O(n), memori O(n).
     */
    public function index($error = '')
    {
        $lecturers = $this->model->getLecturers();
        require self::VIEW_DIR . 'indexLecturer.php';
    }

    /**
     * Menampilkan form tambah dosen dan memproses pengirimannya.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function create()
    {
        $lecturer = ['nidn' => '', 'name' => '', 'phone' => '', 'join_date' => ''];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lecturer = ['nidn' => trim($_POST['nidn'] ?? '')] + $this->readForm();
            $error = $this->validate($lecturer);

            if ($error === '') {
                $error = $this->saveNew($lecturer);
            }
            if ($error === '') {
                $this->redirectToIndex();
            }
        }

        require self::VIEW_DIR . 'createLecturer.php';
    }

    /**
     * Menampilkan form ubah dosen dan memproses pengirimannya.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function edit()
    {
        $nidn = $_GET['nidn'] ?? '';
        $lecturer = $nidn === '' ? null : $this->model->getByNidn($nidn);
        if ($lecturer === null) {
            $this->redirectToIndex();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // NIDN diambil dari URL, bukan dari form, karena NIDN adalah kunci dan tidak boleh diubah.
            $lecturer = ['nidn' => $nidn] + $this->readForm();
            $error = $this->validate($lecturer);

            if ($error === '') {
                $this->model->update($nidn, $lecturer['name'], $lecturer['phone'], $lecturer['join_date']);
                $this->redirectToIndex();
            }
        }

        require self::VIEW_DIR . 'editLecturer.php';
    }

    /**
     * Menghapus dosen. Hanya menerima POST agar tidak terhapus oleh crawler atau prefetch browser.
     *
     * Kompleksitas: waktu O(log n), memori O(1).
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToIndex();
        }

        $nidn = $_POST['nidn'] ?? '';
        // delete() model tetap sukses walau NIDN tidak ada, jadi keberadaan data dicek di sini.
        if ($nidn === '' || $this->model->getByNidn($nidn) === null) {
            $this->redirectToIndex();
        }
        try {
            $this->model->delete($nidn);
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === self::MYSQL_ERROR_FOREIGN) {
                return $this->index($e->getMessage());
            }
            throw $e;
        }
        $this->redirectToIndex();
    }

    private function readForm()
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'join_date' => trim($_POST['join_date'] ?? ''),
        ];
    }

    private function validate(array $lecturer)
    {
        return in_array('', $lecturer, true) ? self::ERROR_EMPTY : '';
    }

    private function saveNew(array $lecturer)
    {
        try {
            $this->model->create($lecturer['nidn'], $lecturer['name'], $lecturer['phone'], $lecturer['join_date']);
        } catch (mysqli_sql_exception $e) {
            // Error selain NIDN ganda dilempar ulang agar tidak menjadi silent failure.
            if ($e->getCode() !== self::MYSQL_DUPLICATE_KEY) {
                throw $e;
            }
            return self::ERROR_DUPLICATE;
        }
        return '';
    }

    private function redirectToIndex()
    {
        header('Location: ' . self::INDEX_URL);
        exit;
    }
}