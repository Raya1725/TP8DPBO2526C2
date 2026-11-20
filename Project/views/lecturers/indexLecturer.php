<?php
/*****************************************
 * Filename : indexLecturer.php
 * Programmer : Renaldy Heryana
 * Date : xx-xx-xxxx
 * Email : renaldyheryana2@gmail.com
 * Deskripsi : tampilan daftar dosen
 *
 *****************************************/

$title = 'Home';
require __DIR__ . '/../../templates/header.php';
?>
<div class="container my-4">
  <?php if ($error !== ''): ?>
    <div class="alert alert-danger"><?= "Tidak bisa dihapus jika masih menjadi kaprodi" ?></div>
  <?php endif; ?>
  <div class="col-1 my-3">
    <a type="button" class="btn btn-primary nav-link active" href="index.php?page=lecturers&action=create">Add New</a>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>NIDN</th>
        <th>NAME</th>
        <th>PHONE</th>
        <th>JOIN DATE</th>
        <th>ACTIONS</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($lecturers)): ?>
        <tr>
          <td colspan="5" class="text-center">Belum ada data dosen.</td>
        </tr>
      <?php endif; ?>
      <?php foreach ($lecturers as $lecturer): ?>
        <tr>
          <td><?= htmlspecialchars($lecturer['nidn']) ?></td>
          <td><?= htmlspecialchars($lecturer['name']) ?></td>
          <td><?= htmlspecialchars($lecturer['phone']) ?></td>
          <td><?= htmlspecialchars($lecturer['join_date']) ?></td>
          <td>
            <a class="btn btn-success"
              href="index.php?page=lecturers&action=edit&nidn=<?= urlencode($lecturer['nidn']) ?>">Edit</a>
            <form method="post" action="index.php?page=lecturers&action=delete" class="d-inline">
              <input type="hidden" name="nidn" value="<?= htmlspecialchars($lecturer['nidn']) ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>