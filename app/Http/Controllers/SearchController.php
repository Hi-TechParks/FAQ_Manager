<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FaqCategory;
use App\Location;
use App\Faq;
use Session;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // Search Question    
      if($request->get('question') != Null && !empty($request->get('question'))){

        $question = DB::table('faqs')->where('faqs.question', 'LIKE', '%'.$request->get('question').'%' );

            if(!empty($request->get('location'))){
              $question->where('faqs.location_id', $request->get('location'));
            }

            $faqs_ques = $question->where('faqs.status', '1')
                    ->orderBy('faqs.id', 'desc');



        // Search Answer
        $answer = DB::table('faqs')->where('faqs.answer', 'LIKE', '%'.$request->get('question').'%' );

            if(!empty($request->get('location'))){
              $answer->where('faqs.location_id', $request->get('location'));
            }

            $faqs = $answer->where('faqs.status', '1')
                    ->orderBy('faqs.id', 'desc')
                    ->unionAll($faqs_ques)
                    ->take(15)
                    ->get();

        // Data pass to view
        $search_list = view('search_list',compact('faqs'))->render();


        if(!empty($request->get('location'))){
            // Increment Views
            $locationKey = 'location_' . $request->get('location');

            if (!Session::has($locationKey)) {
                Location::where('id', $request->get('location'))->increment('views');
                Session::put($locationKey, 1);
            }
        }

      }

      return response()->json(['values'=> $search_list]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new(Request $request)
    {
      // Search Question    
      if(1 == 1){

        $question = DB::table('faqs')->where('faqs.question', 'LIKE', '%'.'will'.'%' );
            // ->orWhere('faqs.answer', 'LIKE', '%'.$request->question.'%' );

            if(1 == 1){
              $question->where('faqs.location_id', 1);
            }

            $faqs_ques = $question->where('faqs.status', '1')
                    ->orderBy('faqs.id', 'desc');



        // Search Answer
        $answer = DB::table('faqs')->where('faqs.answer', 'LIKE', '%'.'will'.'%' );

            if(1 == 1){
              $answer->where('faqs.location_id', 1);
            }

            $faqs = $answer->where('faqs.status', '1')
                    ->orderBy('faqs.id', 'desc')
                    ->unionAll($faqs_ques)
                    ->get();


        return $faqs;

        //$search_list = view('search_list',compact('faqs'))->render();

      }

     //return response()->json(['values'=> $search_list]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index3333(Request $request)
    {
        // Faq Categories
        $faq_categories = FaqCategory::where('status', '1')
                                    ->orderBy('title', 'ASC')
                                    ->get();


        // Faqs                                
        $data = DB::table('faqs')->where('faqs.question', 'LIKE', '%'.$request->question.'%' );
                    //->orWhere('faqs.answer', 'LIKE', '%'.$request->question.'%' );

                    if(!empty($request->location)){
                    $data->join('locations', 'locations.id', '=', 'faqs.location_id')
                        ->where('locations.id', $request->location)
                        ->select('faqs.*', 'locations.title');
                    }

            $faqs = $data->where('faqs.status', '1')
                    ->orderBy('faqs.id', 'desc')
                    ->paginate(20);


        if(!empty($request->location)){
            // Increment Views
            $locationKey = 'location_' . $request->location;

            if (!Session::has($locationKey)) {
                Location::where('id', $request->location)->increment('views');
                Session::put($locationKey, 1);
            }
        }


        $search = $request->question;

        return view('search', compact('faq_categories', 'faqs', 'search'));
    }

}
