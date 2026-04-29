<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(1);
?>

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

    @media (max-width: 576px) {
        .blog-pagination-list {
            gap: 0.4rem;
            padding: 0.6rem;
            border-radius: 1.25rem;
        }

        .blog-pagination-link {
            min-width: 2.4rem;
            height: 2.4rem;
            padding: 0 0.85rem;
            font-size: 0.95rem;
        }
    }
</style>

<?php if ($pager->hasPrevious() || $pager->hasNext()) : ?>
    <nav class="blog-pagination" aria-label="<?= lang('Pager.pageNavigation') ?>">
        <ul class="blog-pagination-list">
            <?php if ($pager->hasPrevious()) : ?>
                <li class="blog-pagination-item blog-pagination-label">
                    <a class="blog-pagination-link" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                        Sebelumnya
                    </a>
                </li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
                <li class="blog-pagination-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="blog-pagination-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
                <li class="blog-pagination-item blog-pagination-label">
                    <a class="blog-pagination-link" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                        Berikutnya
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif ?>
