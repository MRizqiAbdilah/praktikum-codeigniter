<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PortofolioController extends BaseController
{
    public $dataDiri = [
        "name" => "Muhammad Rizqi Abdilah",
        "job" => "Developer, Freelancer",
        "birthday" => "5 Februari 2005",
        "website" => "www.lordshadow",
        "phone" => "+62 858-9485-1202",
        "city" => "DKI Jakarta, Indonesia",
        "age" => "21",
        "degree" => "S1",
        "email" => "muhammadrizqiabdilah10@gmail.com",
        "freelance" => "Available",
        "socialMedia" => [
            "x" => "",
            "facebook" => "",
            "instagram" => "",
            "skype" => "",
        ],
    ];

    public function index()
    {
        return view('portofolio/index.html', [
            "profile" => $this->dataDiri
        ]);
    }
}
