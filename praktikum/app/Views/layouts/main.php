<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $cssPath = FCPATH . 'css/output.css';
        $cssVersion = is_file($cssPath) ? filemtime($cssPath) : time();
        $jsPath = FCPATH . 'js/calculator.js';
        $jsVersion = is_file($jsPath) ? filemtime($jsPath) : time();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($metaDescription ?? 'CodeIgniter app with Tailwind CSS') ?>">
    <title><?= esc($title ?? 'CodeIgniter App') ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('css/output.css') . '?v=' . $cssVersion ?>">
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <a href="<?= base_url() ?>" class="text-lg font-bold tracking-tight text-slate-900">CI4 + Tailwind</a>
            <nav class="flex items-center gap-5 text-sm font-medium">
                <a href="<?= base_url() ?>" class="text-slate-700 hover:text-slate-900">Home</a>
                <a href="<?= base_url('about') ?>" class="text-slate-700 hover:text-slate-900">About</a>
                <a href="<?= base_url('calculator') ?>" class="text-slate-700 hover:text-slate-900">Calculator</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('js/calculator.js') . '?v=' . $jsVersion ?>" defer></script>
</body>
</html>
