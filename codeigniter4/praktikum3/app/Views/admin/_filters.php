<?php
$activeCategory = trim((string) ($filters['category'] ?? ''));
$activeSort = trim((string) ($filters['sort'] ?? 'newest'));
$activeSearch = trim((string) ($filters['q'] ?? ''));

$sortLabels = [
    'newest' => 'terbaru',
    'oldest' => 'terlama',
    'az' => 'judul A-Z',
    'za' => 'judul Z-A',
];

$summaryCategory = $activeCategory !== '' ? $activeCategory : 'semua kategori';
$summarySort = $sortLabels[$activeSort] ?? 'terbaru';
$summarySearch = $activeSearch !== '' ? '"' . $activeSearch . '"' : 'semua post';
?>

<div class="admin-panel admin-filter-shell p-4 mb-4">
    <form method="get" action="<?= esc($filterAction) ?>">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center gap-3">
            <div class="d-flex align-items-center gap-3 flex-grow-1">
                <input
                    type="search"
                    name="q"
                    class="form-control admin-search-input flex-grow-1"
                    placeholder="Cari judul, kategori, author, slug..."
                    value="<?= esc($activeSearch) ?>">
            </div>

            <div class="d-flex gap-2 align-items-center">
                <div class="dropdown">
                    <button type="button"
                        class="btn btn-outline-secondary admin-filter-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="Buka filter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 7H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M7 12H17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M10 17H14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end admin-filter-dropdown">
                        <div class="fw-semibold mb-1">Filter Post</div>
                        <div class="admin-muted small mb-3">Pilih kategori dan urutan tampilan yang diinginkan.</div>

                        <div class="admin-filter-grid">
                            <select id="filter-category" name="category" class="form-select admin-filter-select" aria-label="Filter kategori">
                                <option value="">Kategori: Semua</option>
                                <?php foreach ($categoryOptions as $categoryOption): ?>
                                    <option value="<?= esc($categoryOption) ?>" <?= ($filters['category'] ?? '') === $categoryOption ? 'selected' : '' ?>>
                                        Kategori: <?= esc($categoryOption) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select id="filter-sort" name="sort" class="form-select admin-filter-select" aria-label="Urutkan artikel">
                                <option value="newest" <?= ($filters['sort'] ?? 'newest') === 'newest' ? 'selected' : '' ?>>Urutkan: Terbaru</option>
                                <option value="oldest" <?= ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Urutkan: Terlama</option>
                                <option value="az" <?= ($filters['sort'] ?? '') === 'az' ? 'selected' : '' ?>>Urutkan: Judul A-Z</option>
                                <option value="za" <?= ($filters['sort'] ?? '') === 'za' ? 'selected' : '' ?>>Urutkan: Judul Z-A</option>
                            </select>
                        </div>

                        <div class="d-flex flex-wrap gap-2 pt-3">
                            <button type="submit" class="btn btn-dark rounded-pill px-4">Terapkan</button>
                            <a href="<?= esc($filterAction) ?>" class="btn btn-outline-secondary rounded-pill px-4">Reset</a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark rounded-pill px-4">Cari</button>
            </div>
        </div>
    </form>
</div>
