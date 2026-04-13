<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
initial-scale=1.0">
    <title>MyBlog</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="<? base_url('css/bootstrap.min.css') ?>" />
      -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top
bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?=
                                            base_url() ?>">MyBlog</a>
            <button class="navbar-toggler"
                type="button" data-bs-toggle="collapse" data-bstarget="#navbarNav" aria-controls="navbarNav" ariaexpanded="false" aria-label="Toggle navigation">
                <span class="navbar-togglericon"></span>
            </button>
            <div class="collapse navbar-collapse"
                id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link
active" aria-current="page" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?= base_url('about') ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?= base_url('post') ?>">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?= base_url('faqs') ?>">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Selamat Datang</h1>
            <!-- <p class="col-md-8 fs-4">di laman portal berita</p>
-->
            <!-- <button class="btn btn-primary btn-sm"
type="button">Read more</button> -->
        </div>
    </div>