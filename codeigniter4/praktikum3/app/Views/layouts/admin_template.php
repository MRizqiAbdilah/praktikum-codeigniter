<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin | MyBlog') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        :root {
            --admin-bg: #f4f7fb;
            --admin-panel: #ffffff;
            --admin-border: rgba(15, 23, 42, 0.08);
            --admin-text: #0f172a;
            --admin-muted: #64748b;
            --admin-primary: #0f766e;
            --admin-primary-soft: rgba(15, 118, 110, 0.12);
            --admin-accent: #f59e0b;
            --admin-sidebar: linear-gradient(180deg, #0f172a 0%, #111827 100%);
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(15, 118, 110, 0.08), transparent 24rem),
                linear-gradient(180deg, #f8fbff 0%, var(--admin-bg) 100%);
            color: var(--admin-text);
        }

        .admin-shell {
            min-height: 100vh;
        }

        .admin-sidebar {
            background: var(--admin-sidebar);
            min-height: 100vh;
            color: #e5eef7;
        }

        .admin-brand {
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.78rem;
            color: rgba(226, 232, 240, 0.72);
        }

        .admin-sidebar .nav-link {
            color: rgba(226, 232, 240, 0.82);
            border: 1px solid transparent;
            border-radius: 1rem;
            padding: 0.85rem 1rem;
            transition: 0.2s ease;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.08);
            transform: translateX(2px);
        }

        .admin-stat-card,
        .admin-panel {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border: 1px solid var(--admin-border);
            border-radius: 1.5rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
        }

        .admin-filter-shell {
            position: relative;
            z-index: 40;
        }

        .admin-stat-card .stat-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: var(--admin-primary-soft);
            color: var(--admin-primary);
            font-weight: 700;
        }

        .admin-page-header {
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.12), rgba(245, 158, 11, 0.12));
            border: 1px solid rgba(15, 118, 110, 0.1);
            border-radius: 1.75rem;
        }

        .admin-muted {
            color: var(--admin-muted);
        }

        .admin-table thead th {
            color: var(--admin-muted);
            font-weight: 600;
            border-bottom-width: 1px;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .admin-progress {
            height: 0.8rem;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .admin-progress-bar {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #0f766e, #14b8a6);
        }

        .admin-mobile-topbar {
            background: rgba(15, 23, 42, 0.96);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .admin-search-input {
            min-height: 3rem;
            border-radius: 999px;
            border-color: rgba(15, 23, 42, 0.12);
            padding-inline: 1rem;
        }

        .admin-filter-toggle {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            flex-shrink: 0;
        }

        .admin-filter-dropdown {
            min-width: min(28rem, calc(100vw - 3rem));
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
            padding: 1rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            z-index: 1085;
            margin-top: 0.75rem;
        }

        .admin-filter-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .admin-filter-select {
            min-height: 2.9rem;
            border-radius: 999px;
            border-color: rgba(15, 23, 42, 0.12);
        }

        @media (max-width: 991.98px) {
            .admin-filter-grid {
                grid-template-columns: 1fr;
            }

            .admin-filter-dropdown {
                min-width: min(22rem, calc(100vw - 2rem));
            }
        }
    </style>
</head>

<?php
$currentPath = trim(service('uri')->getPath(), '/');
$adminLinks = [
    [
        'label' => 'Dashboard',
        'url' => base_url('admin/dashboard'),
        'isActive' => $currentPath === 'admin/dashboard' || $currentPath === 'admin',
    ],
    [
        'label' => 'Kelola Post',
        'url' => base_url('admin/post'),
        'isActive' => $currentPath === 'admin/post' || str_starts_with($currentPath, 'admin/post/'),
    ],
];
?>

<body>
    <div class="container-fluid admin-shell px-0">
        <div class="row g-0">
            <aside class="col-lg-3 col-xl-2 d-none d-lg-flex flex-column p-4 admin-sidebar">
                <div class="mb-4">
                    <h1 class="h3 text-white mb-1">MyBlog Studio</h1>
                </div>

                <nav class="nav flex-column gap-2">
                    <?php foreach ($adminLinks as $link): ?>
                        <a href="<?= $link['url'] ?>" class="nav-link <?= $link['isActive'] ? 'active' : '' ?>">
                            <?= esc($link['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <div class="mt-auto pt-4">
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-light rounded-pill w-100 py-3">Logout</a>
                </div>
            </aside>

            <div class="col-lg-9 col-xl-10">
                <div class="d-lg-none sticky-top admin-mobile-topbar px-3 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="admin-brand">Admin Panel</div>
                            <div class="text-white fw-semibold">MyBlog Studio</div>
                        </div>
                        <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas">
                            Menu
                        </button>
                    </div>
                </div>

                <main class="p-3 p-md-4 p-xl-5">
                    <div class="admin-page-header p-4 p-xl-5 mb-4">
                        <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
                                <h2 class="display-6 fw-semibold mb-0"><?= esc($pageHeading ?? 'Admin') ?></h2>
                            
                        </div>
                    </div>

                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="adminSidebarOffcanvas" aria-labelledby="adminSidebarOffcanvasLabel">
        <div class="offcanvas-header border-bottom border-secondary">
            <div>
                <h5 class="offcanvas-title text-white" id="adminSidebarOffcanvasLabel">MyBlog Studio</h5>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="nav flex-column gap-2">
                <?php foreach ($adminLinks as $link): ?>
                    <a href="<?= $link['url'] ?>" class="nav-link <?= $link['isActive'] ? 'active' : '' ?>">
                        <?= esc($link['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="pt-4">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light rounded-pill w-100 py-3">Logout</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
