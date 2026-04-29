<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index(): RedirectResponse
    {
        return redirect()->to(base_url('/#semua-artikel'));
    }
    //-----------------------------------------------------
    public function viewPost($slug)
    {
        $post = new PostModel();
        $data['post'] = $post->where([
            'slug' => $slug,
            'status' => 'published'
        ])->first();

        // tampilkan 404 error jika data tidak ditemukan
        if (!$data['post']) {
            throw
            PageNotFoundException::forPageNotFound();
        }
        $data['title'] = $data['post']['title'] . ' | MyBlog';
        $data['pageHeading'] = $data['post']['title'];
        $data['hideHero'] = true;
        echo view('post_detail', $data);
    }
}
