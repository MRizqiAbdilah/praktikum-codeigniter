<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($metaDescription ?? 'CodeIgniter app with Tailwind CSS') ?>">
    <title><?= esc($title ?? 'CodeIgniter App') ?></title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <!-- arahkan ke output.css, supaya tailwindnya dapat bekerja -->
    <link rel="stylesheet" href="/css/output.css"> 
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <a href="/" class="text-lg font-bold tracking-tight text-slate-900">CI4 + Tailwind</a>
            <nav class="flex items-center gap-5 text-sm font-medium">
                <a href="/" class="text-slate-700 hover:text-slate-900">Home</a>
                <a href="/about" class="text-slate-700 hover:text-slate-900">About</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        <!-- layout templating -->
        <?= $this->renderSection('content') ?> 
    </main>
</body>
</html>
