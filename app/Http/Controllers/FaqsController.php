<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use App\FaqCategory;
use App\Location;
use Session;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Faqs                                
        $faqs = Faq::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('faqs', compact('faqs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($slug)
    {
        // Faq Category
        $category = FaqCategory::where('slug', $slug)->firstOrFail();
        $id = $category->id;

        // Faqs                                
        $faqs = Faq::where('category_id', $id)
        			->where('status', '1')
                    ->orderBy('id', 'desc')
                    ->paginate(10);


        // Increment Views
        $categoryKey = 'category_' . $id;

        if (!Session::has($categoryKey)) {
            FaqCategory::where('id', $id)->increment('views');
            Session::put($categoryKey, 1);
        }


        $page_meta = $current_category = FaqCategory::find($id);

        return view('faq-category', compact('faqs', 'current_category', 'page_meta'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location($slug)
    {
        // Faq Location
        $location = Location::where('slug', $slug)->firstOrFail();
        $id = $location->id;

        // Faqs                                
        $faqs = Faq::where('location_id', $id)
                    ->where('status', '1')
                    ->orderBy('id', 'desc')
                    ->paginate(10);


        // Increment Views
        $locationKey = 'location_' . $id;

        if (!Session::has($locationKey)) {
            Location::where('id', $id)->increment('views');
            Session::put($locationKey, 1);
        }


        $page_meta = $current_location = Location::find($id);

        return view('faq-location', compact('faqs', 'current_location', 'page_meta'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Faq                               
        $faq_meta = $faq = Faq::where('id', $id)
                            ->where('status', '1')
                            ->firstOrFail();

        return view('faq', compact('faq', 'faq_meta'));
    }
}
