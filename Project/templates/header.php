<?php
/*****************************************
 * Filename : header.php
 * Programmer : Renaldy Heryana
 * Date : xx-xx-xxxx
 * Email : renaldyheryana2@gmail.com
 * Deskripsi : bagian atas halaman (head dan navbar)
 *
 *****************************************/
?>
<!DOCTYPE html>
<html>

<head>
  <title><?= htmlspecialchars($title) ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php?page=lecturers">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=lecturers">Lecturers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=departments">Departments</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>