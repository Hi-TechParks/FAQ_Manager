<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Faq;
use App\FaqCategory;
use App\Location;
use App\Setting;
use Carbon\Carbon;
use Session;
use Image;
use File;
use Auth;
use DB;

class FaqController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'FAQ';
        $this->url = 'faq';

        // Permission
        $this->middleware('permission:'.$this->url.'-all', ['only' => ['index','show','create','store','edit','update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        //
        $rows = Faq::where('faqs.asked_by', '!=', Null)
                    ->where('faqs.status', '2')
                    ->leftJoin('user_locations', 'user_locations.location_id', '=', 'faqs.location_id')
                    ->leftJoin('user_categories', 'user_categories.category_id', '=', 'faqs.category_id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->orderBy('faqs.id', 'desc')
                    ->get();

        $categories = FaqCategory::where('status', '1')->get();
        $locations = Location::where('status', '1')->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.pending', compact('rows', 'categories', 'locations', 'title', 'url'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve()
    {
        //
        $rows = Faq::where('asked_by', '!=', Null)
                    ->where('faqs.status', '1')
                    ->leftJoin('user_locations', 'user_locations.location_id', '=', 'faqs.location_id')
                    ->leftJoin('user_categories', 'user_categories.category_id', '=', 'faqs.category_id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->orderBy('faqs.id', 'desc')
                    ->get();

        $categories = FaqCategory::where('status', '1')->get();
        $locations = Location::where('status', '1')->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.approve', compact('rows', 'categories', 'locations', 'title', 'url'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reject()
    {
        //
        $rows = Faq::where('asked_by', '!=', Null)
                    ->where('faqs.status', '0')
                    ->leftJoin('user_locations', 'user_locations.location_id', '=', 'faqs.location_id')
                    ->leftJoin('user_categories', 'user_categories.category_id', '=', 'faqs.category_id')
                    ->where('user_locations.user_id', Auth::user()->id)
                    ->where('user_categories.user_id', Auth::user()->id)
                    ->orderBy('faqs.id', 'desc')
                    ->get();

        $categories = FaqCategory::where('status', '1')->get();
        $locations = Location::where('status', '1')->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.reject', compact('rows', 'categories', 'locations', 'title', 'url'));
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

        // Update Data
        $data = Faq::find($id);
        $data->category_id = $request->category;
        $data->location_id = $request->location;
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->image = $fileNameToStore;
        $data->ref_url = $request->ref_url;
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request, $id)
    {

        $settings = Setting::where('status', '1')->get();

        if(count($settings) == 1){

            foreach ($settings as $setting ){
                $maildata['appMail'] = $setting->contact_mail;
                $maildata['appName'] = $setting->title;
            }

            // Passing data to email template
            $data = Faq::find($id);

            $maildata['name'] = $data->asked_by;
            $maildata['email'] = $data->email;
            $maildata['subject'] = $data->question;

            // Send Mail
            Mail::send(new SendMailable($maildata));

            $data->mail = '1';
            $data->save();

            
            Session::flash('success', 'Mail Send Successfully!');

        }
        else{
            Session::flash('error', 'Receiver not configured!');
        }

        return redirect()->back();

    }
}
