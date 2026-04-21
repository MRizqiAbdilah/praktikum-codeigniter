<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Page extends BaseController
{
    public function about()
    {
        echo view('about', [
            'title' => 'About | MyBlog',
            'pageHeading' => 'Tentang Kami',
        ]);
    }

    public function contact()
    {
        echo view('contact', [
            'title' => 'Contact | MyBlog',
            'pageHeading' => 'Hubungi Kami',
        ]);
    }

    public function faqs()
    {
        echo view('faqs', [
            'title' => 'FAQ | MyBlog',
            'pageHeading' => 'Pertanyaan yang Sering Ditanyakan',
        ]);
    }
}
