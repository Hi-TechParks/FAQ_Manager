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
        // Faq Categories
        $faq_categories = FaqCategory::where('status', '1')
                        ->orderBy('title', 'ASC')
                        ->get();

        // Faqs                                
        $faqs = Faq::where('status', '1')
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('faqs', compact('faq_categories', 'faqs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category($id)
    {
        // Faq Categories
        $faq_categories = FaqCategory::where('status', '1')
                        ->orderBy('title', 'ASC')
                        ->get();

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

        return view('faq-category', compact('faq_categories', 'faqs', 'current_category', 'page_meta'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location($id)
    {
        // Faq Locations
        $faq_locations = Location::where('status', '1')
                        ->orderBy('title', 'ASC')
                        ->get();

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

        return view('faq-location', compact('faq_locations', 'faqs', 'current_location', 'page_meta'));
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
        $faq = Faq::find($id);

        return view('faq', compact('faq'));
    }
}
