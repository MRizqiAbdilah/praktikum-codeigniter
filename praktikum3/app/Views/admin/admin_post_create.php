<?= $this->extend('layouts/admin_template') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <span class="badge text-bg-primary-subtle text-primary mb-2">Editor</span>
                        <h2 class="h3 mb-1">Tulis artikel baru</h2>
                        <p class="text-muted mb-0">Lengkapi author, kategori, gambar, dan caption agar postingan terasa seperti blog modern.</p>
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
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Post title" value="<?= esc(old('title')) ?>" required>
                            </div>

                            <input type="hidden" name="author" value="<?= esc($currentAuthor) ?>">

                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <?php
                                $oldCategory = old('category');
                                $isExistingCategory = $oldCategory !== null && in_array($oldCategory, $categories, true);
                                $selectedExistingCategory = $isExistingCategory ? $oldCategory : '';
                                $newCategoryValue = $isExistingCategory ? '' : (string) $oldCategory;
                                $selectedMode = $newCategoryValue !== '' ? '__new__' : $selectedExistingCategory;
                                ?>
                                <input type="hidden" id="category" name="category" value="<?= esc($oldCategory ?? '') ?>">
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
                                <div class="form-text">Anda bisa memilih kategori milik Anda yang sudah ada, atau membuat kategori baru khusus untuk akun ini.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="image" class="form-label">Gambar utama</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <div class="form-text">Gunakan gambar cover supaya artikel terasa seperti blog pada umumnya.</div>
                            </div>

                            <div class="col-12">
                                <label for="caption" class="form-label">Caption gambar</label>
                                <input type="text" id="caption" name="caption" class="form-control"
                                    placeholder="Contoh: Dokumentasi kegiatan komunitas pagi ini"
                                    value="<?= esc(old('caption')) ?>">
                            </div>

                            <div class="col-12">
                                <label for="content" class="form-label">Content</label>
                                <textarea id="content" name="content" class="form-control" cols="30" rows="12"
                                    placeholder="Write a great post!"><?= esc(old('content')) ?></textarea>
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
