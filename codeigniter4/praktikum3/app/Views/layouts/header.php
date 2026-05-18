<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
initial-scale=1.0">

<title><?= esc($title ?? 'MyBlog') ?></title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="<? base_url('css/bootstrap.min.css') ?>" />
      -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
    <?= $this->include('components/navbar') ?>
    <?php if (!($hideHero ?? false)): ?>
    <div class="p-5 bg-light rounded-3">
        <div class="container py-5">
            <h1 class="display-5 fw-bold"><?= esc($pageHeading ?? "Selamat Datang") ?></h1>
        </div>
    </div>
    <?php endif; ?>
