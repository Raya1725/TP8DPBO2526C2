<?php
/*****************************************
 * Filename : editDepartments.php
 * Programmer : Renaldy Heryana
 * Date : xx-xx-xxxx
 * Email : renaldyheryana2@gmail.com
 * Deskripsi : tampilan form ubah dosen
 *
 *****************************************/

$title = 'Ubah';
require __DIR__ . '/../../templates/header.php';
?>
<div class="col-lg-6 m-auto">

  <form method="post">

    <br><br>
    <div class="card">

      <div class="card-header bg-warning">
        <h1 class="text-white text-center"> Update Lecturer </h1>
      </div><br>

      <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <label> ID: </label>
      <input type="text" name="id" value="<?= htmlspecialchars($department['id']) ?>" class="form-control" readonly>
      <br>

      <label> NAME: </label>
      <input type="text" name="name" value="<?= htmlspecialchars($department['name']) ?>" class="form-control">
      <br>

      <label> HEAD DEPARTMENT NIDN: </label>
      <select name="head_department_nidn" class="form-select" required>
        <option value="" disabled <?= $department['head_department_nidn'] === '' ? 'selected' : '' ?>> Pilih Kaprodi
        </option>
        <?php foreach ($lecturers as $lecturer): ?>
          <option value="<?= htmlspecialchars($lecturer['nidn']) ?>"
            <?= $lecturer['nidn'] === $department['head_department_nidn'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($lecturer['name']) ?> (<?= htmlspecialchars($lecturer['nidn']) ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <br>

      <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
      <a class="btn btn-info" type="submit" name="cancel" href="index.php?page=departments"> Cancel </a><br>

    </div>
  </form>
</div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>