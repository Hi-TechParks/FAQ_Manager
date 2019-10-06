<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Setting;
use App\Faq;
use App\FaqCategory;
use App\Location;
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
            $maildata['subject'] = $request->question;

            // Send Mail
            Mail::send(new SendMailable($maildata));

            
            // Mail Information
            /*$senderName = $request->name;;
            $sendFrom = $request->email;
            $subject = $request->question;*/


            /*Mail::send('emails.email', $data, function($message) use ($sendTo, $senderName, $sendFrom, $appName, $subject) {

                // Mail Information
                $message->from($sendFrom, $senderName);
                $message->to($sendTo, $appName)
                        ->subject($subject);

            });*/

            
            Session::flash('success', 'Mail Send Successfully!');

        }
        else{
            Session::flash('error', 'Receiver not configured!');
        }

        

        return redirect()->back();

    }
}
