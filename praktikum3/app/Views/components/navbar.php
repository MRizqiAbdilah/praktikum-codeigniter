<?php
helper('auth');

$currentPath = trim(service('uri')->getPath(), '/');
$currentUser = function_exists('user') ? user() : null;
$displayName = 'Akun';

if ($currentUser) {
    foreach (['username', 'fullname', 'name', 'email'] as $field) {
        $value = trim((string) ($currentUser->{$field} ?? ''));

        if ($value !== '') {
            $displayName = $value;
            break;
        }
    }
}

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

<nav class="navbar navbar-expand-lg fixed-top site-navbar">
    <div class="container">
        <a class="navbar-brand site-brand" href="<?= base_url() ?>">MyBlog</a>
        <button class="navbar-toggler"
            type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
            id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <?php foreach ($navItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $item['isActive'] ? 'active' : '' ?>"
                            <?= $item['isActive'] ? 'aria-current="page"' : '' ?>
                            href="<?= $item['url'] ?>"><?= esc($item['label']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item">
                    <?php if (logged_in()): ?>
                        <div class="dropdown">
                            <button class="btn btn-dark rounded-pill px-4 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= esc($displayName) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                                <li><a class="dropdown-item rounded-3 text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-dark rounded-pill px-4 <?= $currentPath === 'login' ? 'active' : '' ?>" href="<?= base_url('login') ?>">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
