<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyToVisitor;
use App\Mail\NotifyToAdmin;
use App\Setting;
use App\Faq;
use App\FaqCategory;
use App\Location;
use App\User;
use Session;

class AskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('status', '1')->get();
        $categories = FaqCategory::where('status', '1')->get();
        $locations = Location::where('status', '1')->get();

        return view('ask', compact('settings', 'categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {

        $settings = Setting::where('status', '1')->get();

        if(count($settings) == 1){

            // Field Validation
            $request->validate([
                'name' => 'required|max:250',
                'email' => 'required|max:250',
                'category' => 'required',
                'location' => 'required',
                'question' => 'required',
            ]);


            // Insert Data
            $data = new Faq;
            $data->asked_by = $request->name;
            $data->email = $request->email;
            $data->category_id = $request->category;
            $data->location_id = $request->location;
            $data->question = $request->question;
            $data->status = 2;
            $data->save();


            foreach ($settings as $setting ){
                $maildata['appMail'] = $setting->contact_mail;
                $maildata['appName'] = $setting->title;
            }

            // Passing data to email template
            $maildata['name'] = $request->name;
            $maildata['email'] = $request->email;
            $maildata['subject'] = 'Notify From : '.$setting->title;
            $maildata['question'] = $request->question;

            // Send Mail to Visitor
            Mail::send(new NotifyToVisitor($maildata));


            // Find Author
            $users = User::join('user_locations', 'user_locations.user_id', '=', 'users.id')
                    ->join('user_categories', 'user_categories.user_id', '=', 'users.id')
                    ->where('user_locations.location_id', $request->location)
                    ->where('user_categories.category_id', $request->category)
                    ->get();

            foreach( $users as $user ){

                // Passing data to email template
                $maildata['adminName'] = $user->name;
                $maildata['adminEmail'] = $user->email;
                $maildata['adminSubject'] = 'Get Question : '.$setting->title;

                // Send Mail to Admins
                Mail::send(new NotifyToAdmin($maildata));
            }

            
            Session::flash('success', 'Mail Send Successfully!');

        }
        else{
            Session::flash('error', 'Receiver not configured!');
        }

        return redirect()->back();

    }
}
