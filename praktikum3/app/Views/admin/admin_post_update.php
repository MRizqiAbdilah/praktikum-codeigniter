<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <span class="badge text-bg-warning-subtle text-warning mb-2">Editor</span>
                        <h2 class="h3 mb-1">Perbarui artikel</h2>
                        <p class="text-muted mb-0">Edit konten, author, kategori, atau ganti cover blog bila perlu.</p>
                    </div>

                    <?php if (isset($validation) && $validation->getErrors()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data" id="text-editor">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $post['id'] ?>" />
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Post title" value="<?= esc(old('title', $post['title'])) ?>" required>
                            </div>

                            <input type="hidden" name="author" value="<?= esc($currentAuthor) ?>">

                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <?php
                                $currentCategory = old('category', $post['category'] ?? '');
                                $isExistingCategory = $currentCategory !== null && in_array($currentCategory, $categories, true);
                                $selectedExistingCategory = $isExistingCategory ? $currentCategory : '';
                                $newCategoryValue = $isExistingCategory ? '' : (string) $currentCategory;
                                $selectedMode = $newCategoryValue !== '' ? '__new__' : $selectedExistingCategory;
                                ?>
                                <input type="hidden" id="category" name="category" value="<?= esc((string) $currentCategory) ?>">
                                <select id="category_existing" name="category_existing" class="form-select" data-category-select>
                                    <option value="">Pilih kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= esc($category) ?>" <?= $selectedMode === $category ? 'selected' : '' ?>><?= esc($category) ?></option>
                                    <?php endforeach; ?>
                                    <option value="__new__" <?= $selectedMode === '__new__' ? 'selected' : '' ?>>+ Buat kategori baru</option>
                                </select>
                                <div class="mt-2 <?= $selectedMode === '__new__' ? '' : 'd-none' ?>" data-category-new-wrapper>
                                    <input type="text" id="category_new" name="category_new" class="form-control"
                                        placeholder="Tulis kategori baru"
                                        value="<?= esc($newCategoryValue) ?>">
                                </div>
                                <div class="form-text">Daftar kategori hanya diambil dari kategori yang pernah Anda buat sendiri.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="image" class="form-label">Gambar utama</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <?php if (!empty($post['image'])): ?>
                                    <div class="form-text">Cover saat ini: <a href="<?= base_url($post['image']) ?>" target="_blank">lihat gambar</a></div>
                                <?php else: ?>
                                    <div class="form-text">Belum ada cover. Tambahkan gambar supaya artikel lebih menarik.</div>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label for="caption" class="form-label">Caption gambar</label>
                                <input type="text" id="caption" name="caption" class="form-control"
                                    placeholder="Contoh: Dokumentasi kegiatan komunitas pagi ini"
                                    value="<?= esc(old('caption', $post['caption'] ?? '')) ?>">
                            </div>

                            <div class="col-12">
                                <label for="content" class="form-label">Content</label>
                                <textarea id="content" name="content" class="form-control" cols="30" rows="12"
                                    placeholder="Write a great post!"><?= esc(old('content', $post['content'])) ?></textarea>
                            </div>

                            <div class="col-12 d-flex gap-2 pt-2">
                                <button type="submit" name="status" value="published"
                                    class="btn btn-primary">Publish</button>
                                <button type="submit" name="status" value="draft"
                                    class="btn btn-outline-secondary">Save to Draft</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const select = document.querySelector('[data-category-select]');
        const newWrapper = document.querySelector('[data-category-new-wrapper]');
        const newInput = document.getElementById('category_new');
        const hiddenInput = document.getElementById('category');

        if (!select || !newWrapper || !newInput || !hiddenInput) {
            return;
        }

        const syncCategoryValue = () => {
            const isNew = select.value === '__new__';
            newWrapper.classList.toggle('d-none', !isNew);

            if (isNew) {
                hiddenInput.value = newInput.value.trim();
                return;
            }

            hiddenInput.value = select.value;
            newInput.value = isNew ? newInput.value : '';
        };

        select.addEventListener('change', syncCategoryValue);
        newInput.addEventListener('input', syncCategoryValue);
        syncCategoryValue();
    })();
</script>

<?= $this->endSection() ?>
