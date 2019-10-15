<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Faq;
use App\FaqCategory;
use App\Location;
use Carbon\Carbon;
use Session;
use Image;
use File;
use Auth;
use DB;

class FaqDefaultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Default FAQ';
        $this->url = 'faq-default';

        // Permission
        $this->middleware('permission:'.$this->url.'-all', ['only' => ['index','show','create','store','edit','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rows = Faq::where('asked_by', '=', Null )
                    ->leftJoin('user_locations', 'user_locations.location_id', '=', 'faqs.location_id')
                    ->leftJoin('user_categories', 'user_categories.category_id', '=', 'faqs.category_id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->orderBy('faqs.id', 'desc')
                    ->get();

        $categories = FaqCategory::leftJoin('user_categories', 'user_categories.category_id', '=', 'faq_categories.id')
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->where('faq_categories.status', '1')
                    ->distinct('faq_categories.id')
                    ->get();

        $locations = Location::leftJoin('user_locations', 'user_locations.location_id', '=', 'locations.id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('locations.status', '1')
                    ->distinct('locations.id')
                    ->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'categories', 'locations', 'title', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'image' => 'nullable|image',
            'category' => 'required',
            'location' => 'required',
        ]);


        // image upload, fit and store inside public folder 
        if($request->hasFile('image')){
            //Upload New Image
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->url.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (500 width, 280 height)
            $thumbnailpath = $path.$fileNameToStore;
            $img = Image::make($request->file('image')->getRealPath())->fit(500, 280, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
        }
        else{
            $fileNameToStore = 'noimage.jpg'; // if no image selected this will be the default image
        }


        // Get content with media file
        $content=$request->input('answer');
        
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
       // foreach <img> in the submited content
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid().'_'.time();

                //Crete Folder Location
                $path = public_path('uploads/media/');
                if (! File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                $filepath = "/uploads/media/$filename.$mimetype";    
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                  // resize if required
                  //->resize(500, null) 
                  ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));                
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-


        // Insert Data
        $data = new Faq;
        $data->category_id = $request->category;
        $data->location_id = $request->location;
        $data->question = $request->question;
        $data->answer = $dom->saveHTML();
        $data->image = $fileNameToStore;
        $data->video_id = $request->video_id;
        $data->status = 1;
        $data->created_by = Auth::user()->id;
        $data->save();


        Session::flash('success', $this->title.' Created Successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $rows = Faq::where('asked_by', '=', Null )
                    ->leftJoin('user_locations', 'user_locations.location_id', '=', 'faqs.location_id')
                    ->leftJoin('user_categories', 'user_categories.category_id', '=', 'faqs.category_id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->orderBy('faqs.id', 'desc')
                    ->get();

        $categories = FaqCategory::leftJoin('user_categories', 'user_categories.category_id', '=', 'faq_categories.id')
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->where('faq_categories.status', '1')
                    ->distinct('faq_categories.id')
                    ->get();

        $locations = Location::leftJoin('user_locations', 'user_locations.location_id', '=', 'locations.id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('locations.status', '1')
                    ->distinct('locations.id')
                    ->get();

        $data = Faq::find($id);

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'categories', 'locations', 'data', 'title', 'url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'image' => 'nullable|image',
            'category' => 'required',
            'location' => 'required',
        ]);


        // image upload, fit and store inside public folder 
        if($request->hasFile('image')){

            //Delete Old Image
            $old_file = Faq::find($id);

            $file_path = public_path('uploads/'.$this->url.'/'.$old_file->image);
            if(File::isFile($file_path)){
                File::delete($file_path);
            }

            //Upload New Image
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->url.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }


            //Resize And Crop as Fit image here (500 width, 280 height)
            $thumbnailpath = $path.$fileNameToStore;
            $img = Image::make($request->file('image')->getRealPath())->fit(500, 280, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
        }
        else{

            $old_file = Faq::find($id);

            $fileNameToStore = $old_file->image; 
        }



        // Get content with media file
        $content=$request->input('answer');
        
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
       // foreach <img> in the submited content
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid().'_'.time();

                //Crete Folder Location
                $path = public_path('uploads/media/');
                if (! File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                $filepath = "/uploads/media/$filename.$mimetype";    
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                  // resize if required
                  //->resize(500, null) 
                  ->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));                
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-


        // Update Data
        $data = Faq::find($id);
        $data->category_id = $request->category;
        $data->location_id = $request->location;
        $data->question = $request->question;
        $data->answer = $dom->saveHTML();
        $data->image = $fileNameToStore;
        $data->video_id = $request->video_id;
        $data->status = $request->status;
        $data->updated_by = Auth::user()->id;
        $data->save();


        Session::flash('success', $this->title.' Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete Data
        $data = Faq::find($id);

        $file_path = public_path('uploads/'.$this->url.'/'.$data->image);
        if(File::isFile($file_path)){
            File::delete($file_path);
        }
        
        $data->delete();

        Session::flash('success', $this->title.' Deleted Successfully!');

        return redirect()->back();
    }
}
