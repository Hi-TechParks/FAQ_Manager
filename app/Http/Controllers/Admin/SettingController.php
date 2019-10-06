<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use App\Social;
use Carbon\Carbon;
use Session;
use Image;
use File;
use Auth;
use Hash;
use DB;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Setting';
        $this->url = 'setting';

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
        $rows = Setting::all();
        $socials = Social::where('user_id', '=', Null)->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'socials', 'title', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function siteInfo(Request $request)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:250',
        ]);

        $id = $request->id;


        // Logo upload, fit and store inside public folder 
        if($request->hasFile('logo')){

            //Delete Old Image
            $old_file = Setting::find($id);

            if(isset($old_file->logo_path)){
                $file_path = public_path('uploads/'.$this->url.'/'.$old_file->logo_path);
                if(File::isFile($file_path)){
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            $extension = $request->file('logo')->getClientOriginalExtension();
            $logoNameToStore = 'logo.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->url.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (auto width, 80 height)
            $thumbnailpath = $path.$logoNameToStore;
            $img = Image::make($request->file('logo')->getRealPath())->resize(null, 80, function ($constraint) { $constraint->aspectRatio(); })->save($thumbnailpath);
        }
        else{

            $old_file = Setting::find($id);

            if(isset($old_file->logo_path)){
                $logoNameToStore = $old_file->logo_path; 
            }
            else {
                $logoNameToStore = Null;
            }
            
        }



        // Favicon upload, fit and store inside public folder 
        if($request->hasFile('favicon')){

            //Delete Old Image
            $old_file = Setting::find($id);

            if(isset($old_file->favicon_path)){
                $file_path = public_path('uploads/'.$this->url.'/'.$old_file->favicon_path);
                if(File::isFile($file_path)){
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('favicon')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            $extension = $request->file('favicon')->getClientOriginalExtension();
            $faviconNameToStore = 'favicon.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->url.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (64 width, 64 height)
            $thumbnailpath = $path.$faviconNameToStore;
            $img = Image::make($request->file('favicon')->getRealPath())->fit(64, 64, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
        }
        else{

            $old_file = Setting::find($id);

            if(isset($old_file->favicon_path)){
                $faviconNameToStore = $old_file->favicon_path; 
            }
            else {
                $faviconNameToStore = Null;
            }
            
        }



        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $data = new Setting;
            $data->title = $request->title;
            $data->description = $request->details;
            $data->keywords = $request->keywords;
            $data->logo_path = $logoNameToStore;
            $data->favicon_path = $faviconNameToStore;
            $data->footer_text = $request->footer_text;
            $data->status = 1;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        else{
            // Update Data
            $data = Setting::find($id);
            $data->title = $request->title;
            $data->description = $request->details;
            $data->keywords = $request->keywords;
            $data->logo_path = $logoNameToStore;
            $data->favicon_path = $faviconNameToStore;
            $data->footer_text = $request->footer_text;
            $data->status = 1;
            $data->updated_by = Auth::user()->id;
            $data->save();
        }


        Session::flash('success', 'Site Info Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactInfo(Request $request)
    {
        // Field Validation
        $request->validate([
            'phone_no' => 'required|max:50',
            'phone_no2' => 'nullable|max:50',
            'email_address' => 'required|max:250',
            'email_address2' => 'nullable|max:250',
            'contact_address' => 'required',
            'contact_mail' => 'required|max:250',
        ]);

        $id = $request->id;


        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $data = new Setting;
            $data->phone_one = $request->phone_no;
            $data->phone_two = $request->phone_no2;
            $data->email_one = $request->email_address;
            $data->email_two = $request->email_address2;
            $data->contact_address = $request->contact_address;
            $data->contact_mail = $request->contact_mail;
            $data->status = 1;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        else{
            // Update Data
            $data = Setting::find($id);
            $data->phone_one = $request->phone_no;
            $data->phone_two = $request->phone_no2;
            $data->email_one = $request->email_address;
            $data->email_two = $request->email_address2;
            $data->contact_address = $request->contact_address;
            $data->contact_mail = $request->contact_mail;
            $data->status = 1;
            $data->updated_by = Auth::user()->id;
            $data->save();
        }


        Session::flash('success', 'Contact Info Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePass(Request $request)
    {
        // Field Validation
        $request->validate([
            'old_password' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $oldPassword = $request->old_password;
        $hashedPassword = Auth::user()->password;

        // Check old password for validation
        if(Hash::check($oldPassword, $hashedPassword)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            Session::flash('success', 'Password Change Successfully!');

            return redirect()->route('login');
        }
        else{
            Session::flash('error', 'Current Password Is Invalid!');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function socialInfo(Request $request)
    {
        // Field Validation
        $request->validate([
            'facebook' => 'nullable|max:500',
            'twitter' => 'nullable|max:500',
            'linkedin' => 'nullable|max:500',
            'instagram' => 'nullable|max:500',
            'pinterest' => 'nullable|max:500',
            'skype' => 'nullable|max:500',
            'youtube' => 'nullable|max:500',
        ]);

        $id = $request->id;


        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $data = new Social;
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->linkedin = $request->linkedin;
            $data->instagram = $request->instagram;
            $data->pinterest = $request->pinterest;
            $data->skype = $request->skype;
            $data->youtube = $request->youtube;
            $data->status = 1;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        else{
            // Update Data
            $data = Social::find($id);
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->linkedin = $request->linkedin;
            $data->instagram = $request->instagram;
            $data->pinterest = $request->pinterest;
            $data->skype = $request->skype;
            $data->youtube = $request->youtube;
            $data->status = 1;
            $data->updated_by = Auth::user()->id;
            $data->save();
        }


        Session::flash('success', 'Social Info Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function aboutUs(Request $request)
    {
        // Field Validation
        $request->validate([
            'about_title' => 'required|max:250',
            'about_details' => 'required',
        ]);

        $id = $request->id;


        // about_image upload, fit and store inside public folder 
        if($request->hasFile('about_image')){

            //Delete Old Image
            $old_file = Setting::find($id);

            if(isset($old_file->about_image)){
                $file_path = public_path('uploads/'.$this->url.'/'.$old_file->about_image);
                if(File::isFile($file_path)){
                    File::delete($file_path);
                }
            }

            //Upload New Image
            $filenameWithExt = $request->file('about_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            $extension = $request->file('about_image')->getClientOriginalExtension();
            $aboutImageNameToStore = 'about_image.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->url.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (500 width, auto height)
            $thumbnailpath = $path.$aboutImageNameToStore;
            $img = Image::make($request->file('about_image')->getRealPath())->resize(500, null, function ($constraint) { $constraint->aspectRatio(); })->save($thumbnailpath);
        }
        else{

            $old_file = Setting::find($id);

            if(isset($old_file->about_image)){
                $aboutImageNameToStore = $old_file->about_image; 
            }
            else {
                $aboutImageNameToStore = Null;
            }
            
        }


        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $data = new Setting;
            $data->about_title = $request->about_title;
            $data->about_details = $request->about_details;
            $data->about_image = $aboutImageNameToStore;
            $data->status = 1;
            $data->created_by = Auth::user()->id;
            $data->save();
        }
        else{
            // Update Data
            $data = Setting::find($id);
            $data->about_title = $request->about_title;
            $data->about_details = $request->about_details;
            $data->about_image = $aboutImageNameToStore;
            $data->status = 1;
            $data->updated_by = Auth::user()->id;
            $data->save();
        }


        Session::flash('success', 'About Us Info Updated Successfully!');

        return redirect()->back();
    }

}
