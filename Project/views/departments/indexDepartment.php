<?php
/*****************************************
 * Filename : indexdepartment.php
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
  <div class="col-1 my-3">
    <a type="button" class="btn btn-primary nav-link active" href="index.php?page=departments&action=create">Add New</a>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>HEAD DEPARTMENT NIDN</th>
        <th>ACTIONS</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($departments)): ?>
        <tr>
          <td colspan="4" class="text-center">Belum ada data prodi.</td>
        </tr>
      <?php endif; ?>
      <?php foreach ($departments as $department): ?>
        <tr>
          <td><?= htmlspecialchars($department['id']) ?></td>
          <td><?= htmlspecialchars($department['name']) ?></td>
          <td><?= htmlspecialchars($department['head_department_nidn']) ?></td>
          <td>
            <a class="btn btn-success"
              href="index.php?page=departments&action=edit&id=<?= urlencode($department['id']) ?>">Edit</a>
            <form method="post" action="index.php?page=departments&action=delete" class="d-inline">
              <input type="hidden" name="id" value="<?= htmlspecialchars($department['id']) ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>