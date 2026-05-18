<?php

namespace App\Controllers;

use App\Models\PostModel;

class Home extends BaseController
{
    public function index(): string
    {
        $filters = $this->getPublicFilters();
        $search = $filters['q'];
        $perPage = 6;
        $allPostsModel = new PostModel();
        $allPublishedPosts = $allPostsModel
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $filteredPosts = $this->applyPublicFilters($allPublishedPosts, $filters);

        $totalPosts = count($filteredPosts);
        $totalPages = max(1, (int) ceil($totalPosts / $perPage));
        $requestedPage = (int) $this->request->getGet('page_articles');
        $currentPage = $requestedPage > 0 ? $requestedPage : 1;
        $currentPage = min($currentPage, $totalPages);
        $offset = ($currentPage - 1) * $perPage;
        $publishedPosts = array_slice($filteredPosts, $offset, $perPage);

        $today = date('Y-m-d');
        $todayPosts = [];
        $categoryGroups = [];

        foreach ($allPublishedPosts as $post) {
            $createdDate = ! empty($post['created_at']) ? date('Y-m-d', strtotime((string) $post['created_at'])) : null;

            if ($createdDate === $today) {
                $todayPosts[] = $post;
            }

            $category = trim((string) ($post['category'] ?? '')) ?: 'Umum';
            $categoryGroups[$category][] = $post;
        }

        $categorySections = [];

        foreach ($categoryGroups as $category => $posts) {
            $categorySections[] = [
                'name' => $category,
                'count' => count($posts),
                'posts' => $posts,
            ];
        }

        usort($categorySections, static fn(array $left, array $right): int => $right['count'] <=> $left['count']);

        return view('home', [
            'title' => 'Home | MyBlog',
            'pageHeading' => 'Blog Adalah Fokus Utama Kami',
            'hideHero' => true,
            'search' => $search,
            'filters' => $filters,
            'pagination' => [
                'currentPage' => $currentPage,
                'perPage' => $perPage,
                'totalPosts' => $totalPosts,
                'totalPages' => $totalPages,
                'hasPrevious' => $currentPage > 1,
                'hasNext' => $currentPage < $totalPages,
            ],
            'todayPosts' => $todayPosts,
            'categorySections' => $categorySections,
            'publishedPosts' => $publishedPosts,
            'publishedCount' => $totalPosts,
            'categoryCount' => count($categoryGroups),
        ]);
    }

    private function getPublicFilters(): array
    {
        $category = trim((string) $this->request->getGet('category'));
        $search = trim((string) $this->request->getGet('q'));

        return [
            'category' => $category,
            'q' => $search,
        ];
    }

    private function applyPublicFilters(array $posts, array $filters): array
    {
        $filteredPosts = array_values(array_filter($posts, function (array $post) use ($filters): bool {
            $category = trim((string) ($post['category'] ?? ''));
            $category = $category !== '' ? $category : 'Umum';

            if (($filters['q'] ?? '') !== '') {
                $keyword = mb_strtolower($filters['q']);
                $haystack = mb_strtolower(implode(' ', [
                    (string) ($post['title'] ?? ''),
                    (string) ($post['author'] ?? ''),
                    $category,
                ]));

                if (! str_contains($haystack, $keyword)) {
                    return false;
                }
            }

            if (($filters['category'] ?? '') !== '' && $category !== $filters['category']) {
                return false;
            }

            return true;
        }));

        return $filteredPosts;
    }
}
