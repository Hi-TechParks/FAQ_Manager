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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete22(Request $request)
    {

        $faqs = Faq::select("title")

                ->where("title","LIKE","%{$request->input('query')}%")

                ->get();

            foreach ($faqs as $faq)
            {
                $data[] = $faqs->title;
            }

        return response()->json($data);

    }


    public function autocomplete(Request $request)
    {
          $search = $request->get('term');
     
          $result = Faq::select('title')->where('title', 'LIKE', '%'. $search. '%')->get();

          return response()->json($result);
           
    }


    /**
     * Show the application location.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request)
    {
        $data = [];

        if($request->has('q')){

            $search = $request->q;

            $data = DB::table("faq_categories")
                    ->select("id","title")
                    ->where('title','LIKE',"%$search%")
                    ->get();
        }

        return response()->json($data);
    }
    

    /**
     * Show the application location.
     *
     * @return \Illuminate\Http\Response
     */
    public function location(Request $request)
    {
        $data = [];

        if($request->has('q')){

            $search = $request->q;

            $data = DB::table("locations")
                    ->select("id","title")
                    ->where('title','LIKE',"%$search%")
                    ->get();
        }

        return response()->json($data);
    }


    /**
     * Show the application question.
     *
     * @return \Illuminate\Http\Response
     */
    public function question(Request $request)
    {
        $data = [];

        if($request->has('q')){

            $search = $request->q;

            $data = DB::table("faqs")
                    ->select("id","question")
                    ->where('question','LIKE',"%$search%")
                    ->orWhere('answer', 'LIKE',"%$search%")
                    ->get();
        }

        return response()->json($data);
    }
}
