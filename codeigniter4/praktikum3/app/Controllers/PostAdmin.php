<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

class PostAdmin extends BaseController
{
    public function adminRoot()
    {
        return redirect()->to(base_url('admin/dashboard'));
    }

    public function dashboard()
    {
        $postModel = new PostModel();
        $allPosts = $this->getAuthorScopedPosts($postModel);
        $filters = $this->getAdminFilters();
        $posts = $this->applyAdminFilters($allPosts, $filters);

        $data['posts'] = $posts;
        $data['recentPosts'] = array_slice($posts, 0, 4);
        $data['dashboard'] = $this->buildDashboardData($posts);
        $data['filters'] = $filters;
        $data['categoryOptions'] = $this->extractCategoryOptions($allPosts);
        $data['filterAction'] = base_url('admin/dashboard');
        $data['title'] = 'Admin Dashboard | MyBlog';
        $data['pageHeading'] = 'Dashboard Admin';
        $data['pageSubheading'] = 'Pantau ritme posting, distribusi kategori, dan konten terbaru dari blog Anda.';
        echo view('admin/admin_dashboard', $data);
    }

    public function index()
    {
        $postModel = new PostModel();
        $allPosts = $this->getAuthorScopedPosts($postModel);
        $filters = $this->getAdminFilters();
        $posts = $this->applyAdminFilters($allPosts, $filters);

        $data['posts'] = $posts;
        $data['dashboard'] = $this->buildDashboardData($posts);
        $data['filters'] = $filters;
        $data['categoryOptions'] = $this->extractCategoryOptions($allPosts);
        $data['filterAction'] = base_url('admin/post');
        $data['title'] = 'Kelola Post | MyBlog';
        $data['pageHeading'] = 'Kelola Post';
        $data['pageSubheading'] = 'Lihat semua artikel, status publikasi, author, kategori, dan aksi edit dalam satu tempat.';
        echo view('admin/admin_post_list', $data);
    }

    //--------------------------------------------------------------

    public function preview($slug)
    {
        $post = new PostModel();
        $data['post'] = $post
            ->where('slug', $slug)
            ->where('author', $this->resolveAuthorName())
            ->first();

        if(!$data['post']){
            throw PageNotFoundException::forPageNotFound();
        }

        $data['title'] = $data['post']['title'] . ' | MyBlog';
        $data['pageHeading'] = $data['post']['title'];
        $data['pageSubheading'] = '';
        $data['hideHero'] = true;
        echo view('post_detail', $data);
    }

    //--------------------------------------------------------------

    public function create()
    {
        helper(['filesystem', 'text', 'url']);

        $validation =  \Config\Services::validation();
        if ($this->request->is('post')) {
            $validation->setRules($this->postValidationRules());

            if ($validation->withRequest($this->request)->run()) {
                $post = new PostModel();
                $post->insert($this->collectPostPayload());
                return redirect('admin/post');
            }
        }

        $data['title'] = 'Buat Artikel | MyBlog';
        $data['pageHeading'] = 'Buat Artikel';
        $data['pageSubheading'] = 'Susun artikel baru lengkap dengan author, kategori, cover image, dan caption.';
        $data['categories'] = $this->getExistingCategories();
        $data['currentAuthor'] = $this->resolveAuthorName();
        $data['validation'] = $validation;

        echo view('admin/admin_post_create', $data);
    }

    //--------------------------------------------------------------

    public function edit($id)
    {
        helper(['filesystem', 'text', 'url']);

        $postModel = new PostModel();
        $data['post'] = $postModel
            ->where('id', $id)
            ->where('author', $this->resolveAuthorName())
            ->first();

        if (!$data['post']) {
            throw PageNotFoundException::forPageNotFound();
        }

        $validation =  \Config\Services::validation();
        if ($this->request->is('post')) {
            $validation->setRules($this->postValidationRules());

            if ($validation->withRequest($this->request)->run()) {
                $postModel->update($id, $this->collectPostPayload($data['post']));
                return redirect('admin/post');
            }
        }

        $data['title'] = 'Edit Artikel | MyBlog';
        $data['pageHeading'] = 'Edit Artikel';
        $data['pageSubheading'] = 'Perbarui isi artikel dan detail visualnya agar blog tetap rapi dan konsisten.';
        $data['categories'] = $this->getExistingCategories();
        $data['currentAuthor'] = $data['post']['author'] ?? $this->resolveAuthorName($data['post']);
        $data['validation'] = $validation;

        echo view('admin/admin_post_update', $data);
    }

    //--------------------------------------------------------------

    public function delete($id)
    {
        $post = new PostModel();
        $postData = $post
            ->where('id', $id)
            ->where('author', $this->resolveAuthorName())
            ->first();

        if (! $postData) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($postData && ! empty($postData['image'])) {
            $imagePath = FCPATH . ltrim($postData['image'], '/');

            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $post->delete($id);
        return redirect('admin/post');
    }

    private function postValidationRules(): array
    {
        return [
            'title' => 'required|max_length[255]',
            'category' => 'required|max_length[100]',
            'content' => 'permit_empty',
            'status' => 'required|in_list[published,draft]',
            'caption' => 'permit_empty|max_length[255]',
            'image' => 'if_exist|is_image[image]|max_size[image,4096]',
        ];
    }

    private function collectPostPayload(array $existingPost = []): array
    {
        $title = trim((string) $this->request->getPost('title'));
        $category = $this->resolveCategoryInput();
        $content = trim((string) $this->request->getPost('content'));
        $status = (string) $this->request->getPost('status');
        $caption = trim((string) $this->request->getPost('caption'));

        return [
            'title' => $title,
            'author' => $this->resolvePersistedAuthor($existingPost),
            'category' => $category,
            'content' => $content,
            'status' => $status,
            'caption' => $caption,
            'image' => $this->storeImage($existingPost),
            'slug' => $this->generateUniqueSlug($title, $existingPost['id'] ?? null),
        ];
    }

    private function storeImage(array $existingPost = []): ?string
    {
        $image = $this->request->getFile('image');

        if (! $image || $image->getError() === UPLOAD_ERR_NO_FILE) {
            return $existingPost['image'] ?? null;
        }

        if (! $image->isValid()) {
            return $existingPost['image'] ?? null;
        }

        $targetDirectory = FCPATH . 'uploads/posts';

        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $newName = $image->getRandomName();
        $image->move($targetDirectory, $newName);

        if (! empty($existingPost['image'])) {
            $oldImagePath = FCPATH . ltrim($existingPost['image'], '/');

            if (is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        return 'uploads/posts/' . $newName;
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        helper('url');

        $baseSlug = url_title($title, '-', true);
        $baseSlug = $baseSlug !== '' ? $baseSlug : strtolower(random_string('alnum', 8));
        $slug = $baseSlug;
        $postModel = new PostModel();
        $counter = 1;

        while ($this->slugExists($postModel, $slug, $ignoreId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(PostModel $postModel, string $slug, ?int $ignoreId = null): bool
    {
        $builder = $postModel->where('slug', $slug);

        if ($ignoreId !== null) {
            $builder = $builder->where('id !=', $ignoreId);
        }

        return $builder->first() !== null;
    }

    private function getExistingCategories(): array
    {
        $db = Database::connect();
        $author = $this->resolveAuthorName();
        $rows = $db->table('posts')
            ->select('category')
            ->where('author', $author)
            ->where('category IS NOT NULL', null, false)
            ->where('category !=', '')
            ->distinct()
            ->orderBy('category', 'ASC')
            ->get()
            ->getResultArray();

        return array_map(static fn ($row) => $row['category'], $rows);
    }

    private function resolveCategoryInput(): string
    {
        $existingCategory = trim((string) $this->request->getPost('category_existing'));
        $newCategory = trim((string) $this->request->getPost('category_new'));
        $category = trim((string) $this->request->getPost('category'));

        if ($existingCategory !== '' && $existingCategory !== '__new__') {
            return $existingCategory;
        }

        if ($newCategory !== '') {
            return $newCategory;
        }

        return $category;
    }

    private function resolveAuthorName(array $existingPost = []): string
    {
        if (function_exists('user') && user()) {
            $currentUser = user();

            foreach (['username', 'fullname', 'name', 'email'] as $field) {
                $value = trim((string) ($currentUser->{$field} ?? ''));

                if ($value !== '') {
                    return $value;
                }
            }
        }

        $existingAuthor = trim((string) ($existingPost['author'] ?? ''));

        return $existingAuthor !== '' ? $existingAuthor : 'Admin';
    }

    private function resolvePersistedAuthor(array $existingPost = []): string
    {
        $existingAuthor = trim((string) ($existingPost['author'] ?? ''));

        if ($existingAuthor !== '') {
            return $existingAuthor;
        }

        return $this->resolveAuthorName();
    }

    private function buildDashboardData(array $posts): array
    {
        $today = new \DateTimeImmutable('today');
        $weekStart = $today->modify('-6 days');
        $dailyCount = 0;
        $weeklyCount = 0;
        $categoryDistribution = [];

        foreach ($posts as $post) {
            $createdAt = empty($post['created_at']) ? null : new \DateTimeImmutable($post['created_at']);
            $category = trim((string) ($post['category'] ?? ''));
            $category = $category !== '' ? $category : 'Tanpa Kategori';

            if (! isset($categoryDistribution[$category])) {
                $categoryDistribution[$category] = 0;
            }

            $categoryDistribution[$category]++;

            if (! $createdAt) {
                continue;
            }

            $createdDay = $createdAt->setTime(0, 0);

            if ($createdDay == $today) {
                $dailyCount++;
            }

            if ($createdDay >= $weekStart && $createdDay <= $today) {
                $weeklyCount++;
            }
        }

        arsort($categoryDistribution);

        return [
            'dailyCount' => $dailyCount,
            'weeklyCount' => $weeklyCount,
            'categoryDistribution' => $categoryDistribution,
            'publishedCount' => count(array_filter($posts, static fn ($post) => ($post['status'] ?? '') === 'published')),
            'draftCount' => count(array_filter($posts, static fn ($post) => ($post['status'] ?? '') === 'draft')),
        ];
    }

    private function getAdminFilters(): array
    {
        $sort = trim((string) $this->request->getGet('sort'));
        $category = trim((string) $this->request->getGet('category'));
        $search = trim((string) $this->request->getGet('q'));

        $allowedSorts = ['newest', 'oldest', 'az', 'za'];

        return [
            'sort' => in_array($sort, $allowedSorts, true) ? $sort : 'newest',
            'category' => $category,
            'q' => $search,
        ];
    }

    private function applyAdminFilters(array $posts, array $filters): array
    {
        $filteredPosts = array_values(array_filter($posts, function (array $post) use ($filters): bool {
            $category = trim((string) ($post['category'] ?? ''));
            $category = $category !== '' ? $category : 'Tanpa Kategori';

            if (($filters['q'] ?? '') !== '') {
                $keyword = mb_strtolower($filters['q']);
                $haystack = mb_strtolower(implode(' ', [
                    (string) ($post['title'] ?? ''),
                    (string) ($post['content'] ?? ''),
                    (string) ($post['slug'] ?? ''),
                    (string) ($post['author'] ?? ''),
                    $category,
                ]));

                if (! str_contains($haystack, $keyword)) {
                    return false;
                }
            }

            if ($filters['category'] !== '' && $category !== $filters['category']) {
                return false;
            }

            return true;
        }));

        usort($filteredPosts, function (array $a, array $b) use ($filters): int {
            $titleA = mb_strtolower((string) ($a['title'] ?? ''));
            $titleB = mb_strtolower((string) ($b['title'] ?? ''));
            $createdA = strtotime((string) ($a['created_at'] ?? '')) ?: 0;
            $createdB = strtotime((string) ($b['created_at'] ?? '')) ?: 0;

            return match ($filters['sort']) {
                'oldest' => $createdA <=> $createdB,
                'az' => $titleA <=> $titleB,
                'za' => $titleB <=> $titleA,
                default => $createdB <=> $createdA,
            };
        });

        return $filteredPosts;
    }

    private function extractCategoryOptions(array $posts): array
    {
        $categories = [];

        foreach ($posts as $post) {
            $category = trim((string) ($post['category'] ?? ''));
            $categories[] = $category !== '' ? $category : 'Tanpa Kategori';
        }

        $categories = array_values(array_unique($categories));
        sort($categories);

        return $categories;
    }

    private function getAuthorScopedPosts(PostModel $postModel): array
    {
        return $postModel
            ->where('author', $this->resolveAuthorName())
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
