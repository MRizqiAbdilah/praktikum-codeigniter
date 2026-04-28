<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-lg-6 my-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?= base_url($post['image']) ?>" class="card-img-top" alt="<?= esc($post['caption'] ?: $post['title']) ?>" style="height: 240px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge text-bg-light"><?= esc($post['category'] ?? 'Tanpa Kategori') ?></span>
                            <small class="text-muted"><?= esc($post['author'] ?? 'Admin') ?></small>
                        </div>
                        <h5 class="h5">
                            <a class="text-decoration-none" href="/post/<?= $post['slug'] ?>"><?= esc($post['title']) ?></a>
                        </h5>
                        <p class="text-muted"><?= esc(substr(strip_tags($post['content']), 0, 140)) ?>...</p>
                        <?php if (!empty($post['caption'])): ?>
                            <p class="small text-secondary mb-0">Caption: <?= esc($post['caption']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>
