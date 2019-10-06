<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Carbon\Carbon;
use Session;
use Image;
use File;
use Auth;
use DB;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Page Data
        $this->title = 'Location';
        $this->url = 'location';

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
        $rows = Location::orderBy('id', 'desc')->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index', compact('rows', 'title', 'url'));
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
            'title' => 'required|max:250|unique:locations,title',
            'meta_keyword' => 'max:500',
        ]);

        // Insert Data
        $data = new Location;
        $data->title = $request->title;
        $data->slug = str_slug($request->title, '-');
        $data->description = $request->details;
        $data->meta_keyword = $request->meta_keyword;
        $data->meta_desc = $request->meta_desc;
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
            'title' => 'required|max:250|unique:locations,title,'.$id,
            'meta_keyword' => 'max:500',
        ]);

        // Update Data
        $data = Location::find($id);
        $data->title = $request->title;
        $data->slug = str_slug($request->title, '-');
        $data->description = $request->details;
        $data->meta_keyword = $request->meta_keyword;
        $data->meta_desc = $request->meta_desc;
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
        $data = Location::find($id);
        $data->delete();

        Session::flash('success', $this->title.' Deleted Successfully!');

        return redirect()->back();
    }
}
