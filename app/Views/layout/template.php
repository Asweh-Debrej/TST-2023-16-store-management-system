<!doctype html>
<html lang="ar" dir="ltr">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />


  <link rel="stylesheet" href="/css/style.css">

  <title><?= $title; ?></title>
</head>

<body>

  <?= $this->include('layout/navbar'); ?>

  <div class="container mt-5 mb-4">
    <h1><strong><?= $title ?? '' ?></strong></h1>
    <!-- Alert for row removal -->
    <?php if (session('successes')) : ?>
      <div class="alert alert-success">
        <ul>
          <?php foreach (session('successes') as $message) : ?>
            <li><?= esc($message) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>

    <?php if (session('errors')) : ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach (session('errors') as $message) : ?>
            <li><?= esc($message) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>

    <?= $this->renderSection('content'); ?>

  </div>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    -->
</body>

</html>