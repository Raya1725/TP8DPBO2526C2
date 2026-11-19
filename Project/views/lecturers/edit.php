<?php
/*****************************************
 * Filename : edit.php
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

        <label> NAME: </label>
        <input type="text" name="name" value="<?= htmlspecialchars($lecturer['name']) ?>" class="form-control"> <br>

        <label> NIDN: </label>
        <input type="text" name="nidn" value="<?= htmlspecialchars($lecturer['nidn']) ?>" class="form-control" readonly> <br>

        <label> PHONE: </label>
        <input type="text" name="phone" value="<?= htmlspecialchars($lecturer['phone']) ?>" class="form-control"> <br>

        <label> JOIN DATE: </label>
        <input type="date" name="join_date" value="<?= htmlspecialchars($lecturer['join_date']) ?>" class="form-control"> <br>

        <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
        <a class="btn btn-info" type="submit" name="cancel" href="index.php"> Cancel </a><br>

      </div>
    </form>
  </div>
<?php require __DIR__ . '/../../templates/footer.php'; ?>
