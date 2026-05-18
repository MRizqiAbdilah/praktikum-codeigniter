<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'MyBlog') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            padding-top: 5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .btn-block {
            display: block;
            width: 100%;
        }
    </style>

    <?= $this->renderSection('pageStyles') ?>
</head>

<body>
