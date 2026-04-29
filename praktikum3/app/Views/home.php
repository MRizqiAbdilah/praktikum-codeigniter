<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<?php
$renderExcerpt = static fn(string $content, int $limit = 140): string => mb_strimwidth(trim(strip_tags($content)), 0, $limit, '...');
$hasSearch = trim((string) ($search ?? '')) !== '';
$filters = $filters ?? ['q' => '', 'category' => ''];
$hasCategoryFilter = trim((string) ($filters['category'] ?? '')) !== '';
$hasActiveFilters = $hasSearch || $hasCategoryFilter;
$pagination = $pagination ?? [
    'currentPage' => 1,
    'totalPages' => 1,
    'hasPrevious' => false,
    'hasNext' => false,
];
$buildPageUrl = static function (int $page) use ($filters): string {
    $query = ['page_articles' => $page];

    if (trim((string) ($filters['q'] ?? '')) !== '') {
        $query['q'] = $filters['q'];
    }

    if (trim((string) ($filters['category'] ?? '')) !== '') {
        $query['category'] = $filters['category'];
    }

    return base_url('/?' . http_build_query($query) . '#semua-artikel');
};
$buildFilterUrl = static function (array $overrides = []) use ($filters): string {
    $query = array_merge([
        'q' => $filters['q'] ?? '',
        'category' => $filters['category'] ?? '',
    ], $overrides);

    foreach ($query as $key => $value) {
        if ($value === '') {
            unset($query[$key]);
        }
    }

    $suffix = $query === [] ? '' : ('?' . http_build_query($query));

    return base_url('/' . $suffix . '#semua-artikel');
};
?>

<div class="container py-4 mt-5">
    <section class="mb-5">
        <div class="row g-4 align-items-start">
            <div class="col-xl-8" id="semua-artikel">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                    <div>
                        <h2 class="h3 mb-1">Artikel Terbaru</h2>
                    </div>
                </div>

                <?php if ($hasActiveFilters): ?>
                    <div class="card border-0 bg-light rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <p class="text-uppercase small fw-semibold text-muted mb-2">Filter Aktif</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php if ($hasCategoryFilter): ?>
                                            <span class="badge rounded-pill text-bg-dark px-3 py-2">Kategori: <?= esc($filters['category']) ?></span>
                                        <?php endif; ?>
                                        <?php if ($hasSearch): ?>
                                            <span class="badge rounded-pill text-bg-light px-3 py-2 border">Pencarian: "<?= esc($filters['q']) ?>"</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="<?= base_url('/#semua-artikel') ?>" class="btn btn-outline-dark rounded-pill px-4">Reset</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php if (!empty($publishedPosts)): ?>
                        <?php foreach ($publishedPosts as $post): ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="<?= base_url($post['image']) ?>" class="card-img-top" alt="<?= esc($post['caption'] ?: $post['title']) ?>" style="height: 220px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                            <span class="badge text-bg-light"><?= esc(trim((string) ($post['category'] ?? '')) ?: 'Umum') ?></span>
                                            <small class="text-muted"><?= esc($post['author'] ?? 'Admin') ?></small>
                                        </div>
                                        <h3 class="h5 mb-3"><?= esc($post['title']) ?></h3>
                                        <p class="text-muted mb-4"><?= esc($renderExcerpt((string) ($post['content'] ?? ''), 140)) ?></p>
                                        <a href="<?= base_url('post/' . $post['slug']) ?>" class="btn btn-outline-dark rounded-pill px-4">Baca Artikel</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card border-0 bg-light rounded-4">
                                <div class="card-body p-4">
                                    <h3 class="h5 mb-2">Artikel tidak ditemukan</h3>
                                    <p class="text-muted mb-0">
                                        <?php if ($hasSearch): ?>
                                            Tidak ada artikel yang cocok dengan pencarian Anda.
                                        <?php else: ?>
                                            Belum ada artikel yang dipublikasikan.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (($pagination['totalPages'] ?? 1) > 1): ?>
                    <div class="mt-4">
                        <style>
                            .blog-pagination {
                                display: flex;
                                justify-content: center;
                                margin-top: 1.5rem;
                            }

                            .blog-pagination-list {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.55rem;
                                flex-wrap: wrap;
                                padding: 0.75rem;
                                margin: 0;
                                list-style: none;
                                background: #fff;
                                border: 1px solid rgba(15, 23, 42, 0.08);
                                border-radius: 999px;
                                box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
                            }

                            .blog-pagination-item {
                                display: flex;
                            }

                            .blog-pagination-link {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                min-width: 2.75rem;
                                height: 2.75rem;
                                padding: 0 1rem;
                                border-radius: 999px;
                                text-decoration: none;
                                color: #0f172a;
                                font-weight: 600;
                                transition: all 0.2s ease;
                            }

                            .blog-pagination-link:hover {
                                background: #f1f5f9;
                                color: #111827;
                            }

                            .blog-pagination-item.active .blog-pagination-link {
                                background: #212529;
                                color: #fff;
                                box-shadow: 0 10px 20px rgba(33, 37, 41, 0.18);
                            }

                            .blog-pagination-label .blog-pagination-link {
                                min-width: auto;
                                padding: 0 1.1rem;
                                border: 1px solid rgba(15, 23, 42, 0.08);
                                background: #fff;
                            }
                        </style>

                        <nav class="blog-pagination" aria-label="Pagination artikel">
                            <ul class="blog-pagination-list">
                                <?php if ($pagination['hasPrevious']): ?>
                                    <li class="blog-pagination-item blog-pagination-label">
                                        <a class="blog-pagination-link" href="<?= esc($buildPageUrl($pagination['currentPage'] - 1)) ?>">Sebelumnya</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($page = 1; $page <= $pagination['totalPages']; $page++): ?>
                                    <li class="blog-pagination-item <?= $page === $pagination['currentPage'] ? 'active' : '' ?>">
                                        <a class="blog-pagination-link" href="<?= esc($buildPageUrl($page)) ?>"><?= $page ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['hasNext']): ?>
                                    <li class="blog-pagination-item blog-pagination-label">
                                        <a class="blog-pagination-link" href="<?= esc($buildPageUrl($pagination['currentPage'] + 1)) ?>">Berikutnya</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-xl-4">
                <div id="artikel-hari-ini" class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <div>
                                <span class="badge text-bg-dark mb-2">Harian</span>
                                <h2 class="h4 mb-1">Artikel Hari Ini</h2>
                            </div>
                            <span class="small text-muted"><?= esc(count($todayPosts ?? [])) ?> artikel</span>
                        </div>

                        <?php if (!empty($todayPosts)): ?>
                            <?php foreach (array_slice($todayPosts, 0, 3) as $index => $post): ?>
                                <div class="<?= $index < min(count($todayPosts), 3) - 1 ? 'pb-3 mb-3 border-bottom' : '' ?>">
                                    <a href="<?= base_url('post/' . $post['slug']) ?>" class="text-decoration-none text-dark">
                                        <h3 class="h6 mb-1"><?= esc($post['title']) ?></h3>
                                    </a>
                                    <p class="small text-muted mb-1"><?= esc(trim((string) ($post['category'] ?? '')) ?: 'Umum') ?> | <?= esc($post['author'] ?? 'Admin') ?></p>
                                    <p class="text-muted small mb-0"><?= esc($renderExcerpt((string) ($post['content'] ?? ''), 90)) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted mb-0">Belum ada artikel yang terbit hari ini.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="kategori" class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <div>
                                <span class="badge text-bg-secondary mb-2">Kategori</span>
                                <h2 class="h4 mb-1">Kategori Artikel</h2>
                            </div>
                            <span class="small text-muted"><?= esc($categoryCount ?? 0) ?> kategori</span>
                        </div>

                        <?php if (!empty($categorySections)): ?>
                            <?php foreach ($categorySections as $index => $section): ?>
                                <?php $firstPost = $section['posts'][0] ?? null; ?>
                                <div class="<?= $index < count($categorySections) - 1 ? 'pb-3 mb-3 border-bottom' : '' ?>">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-1">
                                        <a href="<?= esc($buildFilterUrl(['category' => $section['name']])) ?>" class="fw-semibold text-decoration-none text-dark">
                                            <?= esc($section['name']) ?>
                                        </a>
                                        <span class="badge text-bg-light"><?= esc($section['count']) ?></span>
                                    </div>
                                    <?php if ($firstPost): ?>
                                        <a href="<?= base_url('post/' . $firstPost['slug']) ?>" class="text-decoration-none text-dark">
                                            <p class="mb-1"><?= esc($firstPost['title']) ?></p>
                                        </a>
                                        <p class="text-muted small mb-0"><?= esc($renderExcerpt((string) ($firstPost['content'] ?? ''), 80)) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted mb-0">Kategori akan muncul otomatis saat artikel sudah memiliki pengelompokan topik.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
