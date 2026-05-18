<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>


<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="admin-stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="admin-muted mb-2">Post harian</p>
                    <h3 class="display-6 mb-0"><?= esc($dashboard['dailyCount']) ?></h3>
                </div>
                <div class="stat-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="5" width="16" height="15" rx="3" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 3.5V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 3.5V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4 9.5H20" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8.5 13H12.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <p class="small admin-muted mb-0">Jumlah artikel yang dibuat hari ini.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="admin-stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="admin-muted mb-2">Post mingguan</p>
                    <h3 class="display-6 mb-0"><?= esc($dashboard['weeklyCount']) ?></h3>
                </div>
                <div class="stat-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="5" width="16" height="15" rx="3" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 3.5V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M16 3.5V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M4 9.5H20" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 14L10.5 16.5L16 11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <p class="small admin-muted mb-0">Akumulasi post dalam 7 hari terakhir.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="admin-stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="admin-muted mb-2">Sudah publish</p>
                    <h3 class="display-6 mb-0"><?= esc($dashboard['publishedCount']) ?></h3>
                </div>
                <div class="stat-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 4L19 8V16L12 20L5 16V8L12 4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M9 12.5L11 14.5L15.5 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <p class="small admin-muted mb-0">Artikel yang sudah tampil di blog publik.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="admin-stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <p class="admin-muted mb-2">Draft aktif</p>
                    <h3 class="display-6 mb-0"><?= esc($dashboard['draftCount']) ?></h3>
                </div>
                <div class="stat-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M7 4.5H14L18 8.5V18.5C18 19.0523 17.5523 19.5 17 19.5H7C6.44772 19.5 6 19.0523 6 18.5V5.5C6 4.94772 6.44772 4.5 7 4.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M14 4.5V8.5H18" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M8.75 12H15.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M8.75 15H13.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <p class="small admin-muted mb-0">Konten yang masih menunggu finalisasi.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-5">
        <div class="admin-panel p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="h4 mb-1">Distribusi kategori</h3>
                    <p class="admin-muted mb-0">Kategori yang paling sering digunakan.</p>
                </div>
                <span class="badge rounded-pill text-bg-light"><?= esc(count($dashboard['categoryDistribution'])) ?> kategori</span>
            </div>

            <?php if (!empty($dashboard['categoryDistribution'])): ?>
                <?php $maxCategoryCount = max($dashboard['categoryDistribution']); ?>
                <?php foreach ($dashboard['categoryDistribution'] as $category => $count): ?>
                    <?php $percentage = $maxCategoryCount > 0 ? (int) round(($count / $maxCategoryCount) * 100) : 0; ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold"><?= esc($category) ?></span>
                            <span class="admin-muted"><?= esc($count) ?> post</span>
                        </div>
                        <div class="admin-progress">
                            <div class="admin-progress-bar" style="width: <?= $percentage ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="admin-muted mb-0">Belum ada kategori yang tersimpan.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="admin-panel p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="h4 mb-1">Artikel terbaru</h3>
                    <p class="admin-muted mb-0">Cuplikan konten terbaru dari panel admin.</p>
                </div>
                <a href="<?= base_url('admin/post') ?>" class="btn btn-outline-dark rounded-pill">Kelola Semua</a>
            </div>

            <div class="d-flex flex-column gap-3">
                <?php if (!empty($recentPosts)): ?>
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="border rounded-4 p-3 bg-white">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                <div>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        <span class="badge rounded-pill text-bg-light"><?= esc($post['category'] ?: 'Tanpa Kategori') ?></span>
                                        <span class="badge rounded-pill <?= ($post['status'] ?? '') === 'published' ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                            <?= esc($post['status'] ?? 'draft') ?>
                                        </span>
                                    </div>
                                    <h4 class="h5 mb-1"><?= esc($post['title']) ?></h4>
                                    <p class="admin-muted mb-1">Ditulis oleh <?= esc($post['author'] ?: 'Admin') ?></p>
                                    <p class="mb-0"><?= esc(substr(strip_tags($post['content'] ?? ''), 0, 110)) ?>...</p>
                                </div>
                                <div class="text-md-end">
                                    <p class="small admin-muted mb-2"><?= esc($post['created_at']) ?></p>
                                    <a href="<?= base_url('admin/post/' . $post['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary rounded-pill">Edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="admin-muted mb-0">Belum ada artikel terbaru untuk ditampilkan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
