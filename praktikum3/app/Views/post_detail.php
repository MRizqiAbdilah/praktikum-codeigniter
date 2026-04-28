<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<?php
$createdAt = ! empty($post['created_at']) ? strtotime($post['created_at']) : null;
$formattedCreatedAt = $createdAt ? date('d M Y, H:i', $createdAt) . ' WIB' : '-';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="card border-0 shadow-sm overflow-hidden">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= base_url($post['image']) ?>" alt="<?= esc($post['caption'] ?: $post['title']) ?>" class="w-100" style="max-height: 460px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge text-bg-light"><?= esc($post['category'] ?? 'Tanpa Kategori') ?></span>
                        <span class="text-muted"><?= esc($post['author'] ?? 'Admin') ?></span>
                        <span class="text-muted">|</span>
                        <span class="text-muted"><?= esc($formattedCreatedAt) ?></span>
                    </div>
                    <h5 class="display-6 mb-3"><?= esc($post['title']) ?></h5>
                    <?php if (!empty($post['caption'])): ?>
                        <p class="text-secondary fst-italic mb-4"><?= esc($post['caption']) ?></p>
                    <?php endif; ?>
                    <div class="lh-lg">
                        <?= nl2br(esc($post['content'])) ?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
