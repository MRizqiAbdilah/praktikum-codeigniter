<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<?php
$createdAt = ! empty($post['created_at']) ? strtotime($post['created_at']) : null;
$formattedCreatedAt = $createdAt ? date('d M Y, H:i', $createdAt) . ' WIB' : '-';
$category = trim((string) ($post['category'] ?? '')) ?: 'Tanpa Kategori';
?>

<style>
    .article-shell {
        padding: 3rem 0 4rem;
    }

    .article-hero {
        background:
            radial-gradient(circle at top right, rgba(15, 118, 110, 0.12), transparent 26rem),
            linear-gradient(135deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96));
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 2rem;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .article-category {
        display: inline-flex;
        align-items: center;
        padding: 0.55rem 0.95rem;
        border-radius: 999px;
        background: rgba(15, 118, 110, 0.1);
        color: #0f766e;
        font-weight: 600;
        font-size: 0.92rem;
    }

    .article-title {
        font-size: clamp(2.4rem, 5vw, 4.3rem);
        line-height: 1;
        letter-spacing: -0.04em;
    }

    .article-meta {
        color: #64748b;
        font-size: 1rem;
    }

    .article-figure img {
        width: 100%;
        max-height: 38rem;
        object-fit: cover;
        border-radius: 1.5rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .article-caption {
        color: #64748b;
        font-size: 0.98rem;
        text-align: center;
    }

    .article-body {
        font-size: 1.08rem;
        line-height: 1.9;
        color: #1e293b;
    }
</style>

<section class="article-shell">
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-xl-10">
                <article class="article-hero p-4 p-md-5 p-xl-6">
                    <div class="mb-4">
                        <span class="article-category"><?= esc($category) ?></span>
                    </div>

                    <h1 class="article-title fw-bold mb-4"><?= esc($post['title']) ?></h1>

                    <div class="article-meta d-flex flex-wrap align-items-center gap-2 mb-4 mb-lg-5">
                        <span class="text-muted"><?= esc($post['author'] ?? 'Admin') ?></span>
                        <span class="text-muted">|</span>
                        <span class="text-muted"><?= esc($formattedCreatedAt) ?></span>
                    </div>

                    <?php if (!empty($post['image'])): ?>
                        <figure class="article-figure mb-0">
                            <img src="<?= base_url($post['image']) ?>" alt="<?= esc($post['caption'] ?: $post['title']) ?>">
                            <?php if (!empty($post['caption'])): ?>
                                <figcaption class="article-caption fst-italic mt-3"><?= esc($post['caption']) ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>

                    <div class="article-body mt-5 pt-2">
                        <?= nl2br(esc($post['content'])) ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
