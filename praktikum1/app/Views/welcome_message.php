<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Code anda disini -->
<section class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
    <p class="mb-3 inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">
        Tailwind Active
    </p>
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Hello World!</h1>
    <p class="mt-4 max-w-2xl text-slate-600">
        Jika teks ini tampil dengan style (spacing, warna, rounded, shadow), berarti pipeline Tailwind sudah bekerja dengan benar.
    </p>

    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-sm font-semibold text-slate-900">CodeIgniter 4</p>
            <p class="mt-2 text-sm text-slate-600">Framework backend yang ringan dan cepat.</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-sm font-semibold text-slate-900">Tailwind CSS</p>
            <p class="mt-2 text-sm text-slate-600">Utility classes langsung dipakai di view.</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-sm font-semibold text-slate-900">Reusable Layout</p>
            <p class="mt-2 text-sm text-slate-600">Template dasar siap dipakai untuk halaman lain.</p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
