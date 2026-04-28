<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index()
    {
        $post = new PostModel();
        $data['posts'] = $post->where(
            'status',
            'published'
        )->orderBy('created_at', 'DESC')->findAll();
        $data['title'] = 'Blog | MyBlog';
        $data['pageHeading'] = 'Daftar Artikel';
        echo view('post', $data);
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
        echo view('post_detail', $data);
    }
}
