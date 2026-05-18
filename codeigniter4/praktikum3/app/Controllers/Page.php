<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class Page extends BaseController
{
    public function about(): RedirectResponse
    {
        return redirect()->to(base_url('/#tentang'));
    }

    public function contact(): RedirectResponse
    {
        return redirect()->to(base_url('/#kontak'));
    }

    public function faqs(): RedirectResponse
    {
        return redirect()->to(base_url('/#faq'));
    }
}
