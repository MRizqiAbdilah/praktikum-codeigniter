<?php
$currentPath = trim(service('uri')->getPath(), '/');
$navItems = [
    [
        'label' => 'Home',
        'url' => base_url(),
        'isActive' => $currentPath === '',
    ],
    [
        'label' => 'About',
        'url' => base_url('about'),
        'isActive' => $currentPath === 'about',
    ],
    [
        'label' => 'Blog',
        'url' => base_url('post'),
        'isActive' => str_starts_with($currentPath, 'post'),
    ],
    [
        'label' => 'Contact',
        'url' => base_url('contact'),
        'isActive' => $currentPath === 'contact',
    ],
    [
        'label' => 'FAQ',
        'url' => base_url('faqs'),
        'isActive' => $currentPath === 'faqs',
    ],
];
?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top
bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">MyBlog</a>
        <button class="navbar-toggler"
            type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
            id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php foreach ($navItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $item['isActive'] ? 'active' : '' ?>"
                            <?= $item['isActive'] ? 'aria-current="page"' : '' ?>
                            href="<?= $item['url'] ?>"><?= esc($item['label']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php if (logged_in()): ?>
                        <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                    <?php else: ?>
                        <a class="nav-link <?= $currentPath === 'login' ? 'active' : '' ?>" href="<?= base_url('login') ?>">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
