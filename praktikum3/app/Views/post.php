<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-md-12 my-2 card">
                <div class="card-body">
                    <h5 class="h5"><a
                            href="/post/<?= $post['slug'] ?>"><?= $post['title'] ?></a></h5>
                    <p><?=
                        substr($post['content'], 0, 120) ?></p>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>