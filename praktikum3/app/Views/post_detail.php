<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-12 my-2 card">
            <div class="card-body">
                <h5 class="h5"><?=
                                $post['title'] ?></h5>
                <span><?= $post['author'] ?> | <?=
                                                $post['created_at'] ?></span>
                <p><?=
                    $post['content'] ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>