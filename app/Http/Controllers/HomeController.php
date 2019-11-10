<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use App\FaqCategory;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Faqs                                
        $faqs = Faq::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('index', compact('faqs'));
    }
}
