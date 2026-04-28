<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>

<?= $this->include('admin/_filters') ?>

<?php
$draftCount = count(array_filter($posts, static fn($post) => ($post['status'] ?? '') === 'draft'));
$publishedCount = count(array_filter($posts, static fn($post) => ($post['status'] ?? '') === 'published'));
?>

<div class="admin-panel p-4 p-xl-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <span class="badge rounded-pill text-bg-light mb-2">Content Management</span>
            <h3 class="h4 mb-1">Semua artikel</h3>
            <p class="admin-muted mb-0">Kelola post, lihat author, kategori, status, dan akses aksi penting lebih cepat.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('admin/post/new') ?>" class="btn btn-warning rounded-pill">Buat Post Baru</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <p class="admin-muted mb-2">Total artikel</p>
                <h4 class="display-6 mb-0"><?= esc(count($posts)) ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <p class="admin-muted mb-2">Draft</p>
                <h4 class="display-6 mb-0"><?= esc($draftCount) ?></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-4 p-3 bg-white h-100">
                <p class="admin-muted mb-2">Published</p>
                <h4 class="display-6 mb-0"><?= esc($publishedCount) ?></h4>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Artikel</th>
                            <th>Dibuat</th>
                            <th>Author</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($post['image'])): ?>
                                                <img src="<?= base_url($post['image']) ?>" alt="<?= esc($post['title']) ?>" style="width: 56px; height: 56px; object-fit: cover; border-radius: 1rem;">
                                            <?php else: ?>
                                                <div class="d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: rgba(15, 118, 110, 0.12); color: #0f766e; border-radius: 1rem; font-size: 1.4rem;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M7 4.5H14L18 8.5V18.5C18 19.0523 17.5523 19.5 17 19.5H7C6.44772 19.5 6 19.0523 6 18.5V5.5C6 4.94772 6.44772 4.5 7 4.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                                        <path d="M14 4.5V8.5H18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                                        <path d="M8.75 11H15.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                        <path d="M8.75 14H15.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= esc($post['title']) ?></strong><br>
                                                <small class="admin-muted"><?= esc($post['slug']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= esc(date('d M Y', strtotime($post['created_at']))) ?></div>
                                        <small class="admin-muted"><?= esc(date('H:i', strtotime($post['created_at']))) ?> WIB</small>
                                    </td>
                                    <td><?= esc($post['author'] ?? '-') ?></td>
                                    <td><span class="badge rounded-pill text-bg-light"><?= esc($post['category'] ?? 'Tanpa Kategori') ?></span></td>
                                    <td>
                                        <?php if (($post['status'] ?? '') === 'published'): ?>
                                            <span class="badge text-bg-success">published</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-secondary"><?= esc($post['status'] ?? 'draft') ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?= base_url('admin/post/preview/' . $post['slug']) ?>"
                                                class="btn btn-sm btn-outline-secondary rounded-pill" target="_blank">Preview</a>
                                            <a href="<?= base_url('admin/post/' . $post['id'] . '/edit') ?>"
                                                class="btn btn-sm btn-outline-primary rounded-pill">Edit</a>
                                            <a href="#"
                                                data-href="<?= base_url('admin/post/' . $post['id'] . '/delete') ?>"
                                                onclick="confirmToDelete(this)"
                                                class="btn btn-sm btn-outline-danger rounded-pill">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada artikel. Mulai dengan membuat post pertama Anda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
        </table>
    </div>
</div>

<div id="confirm-dialog" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="h2">Are you sure?</h2>
                    <p>The data will be deleted and lost forever</p>
                </div>
                <div class="modal-footer">
                    <a href="#" role="button" id="delete-button" class="btn btn-danger">Delete</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
</div>

<script>
    function confirmToDelete(el) {
        document.getElementById("delete-button")
            .setAttribute("href", el.dataset.href);
        var myModal = new bootstrap.Modal(
            document.getElementById('confirm-dialog'), {
            keyboard: false
        });
        myModal.show();
    }
</script>

<?= $this->endSection() ?>
