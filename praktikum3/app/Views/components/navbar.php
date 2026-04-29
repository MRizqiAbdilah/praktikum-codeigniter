<?php
helper('auth');

$currentPath = trim(service('uri')->getPath(), '/');
$currentPage = max(1, (int) service('request')->getGet('page_articles'));
$currentCategory = trim((string) service('request')->getGet('category'));
$searchQuery = trim((string) service('request')->getGet('q'));
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
?>

<nav class="navbar navbar-expand-lg fixed-top site-navbar">
    <div class="container gap-3">
        <a class="navbar-brand site-brand" href="<?= base_url() ?>">MyBlog</a>
        <div class="flex-grow-1">
            <form action="<?= base_url() ?>" method="get" class="mx-auto" style="max-width: 42rem;">
                <?php if ($currentPage > 1): ?>
                    <input type="hidden" name="page_articles" value="<?= $currentPage ?>">
                <?php endif; ?>
                <?php if ($currentCategory !== ''): ?>
                    <input type="hidden" name="category" value="<?= esc($currentCategory) ?>">
                <?php endif; ?>
                <div class="input-group">
                    <input
                        type="search"
                        name="q"
                        value="<?= esc($searchQuery) ?>"
                        class="form-control rounded-start-pill"
                        placeholder="Cari artikel, blog, kategori, atau penulis..."
                        aria-label="Cari artikel">
                    <button class="btn btn-dark rounded-end-pill px-4" type="submit">Cari</button>
                </div>
            </form>
        </div>

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
    </div>
</nav>
