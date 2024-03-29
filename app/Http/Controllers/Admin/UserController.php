<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\User;
use App\Location;
use App\FaqCategory;
use Session;
use Hash;
use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

        // Page Data
        $this->title = 'User';
        $this->url = 'user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = User::orderBy('id','desc')->get();

        $roles = Role::all();
        $locations = Location::where('status', '1')->orderBy('title', 'asc')->get();
        $categories = FaqCategory::where('status', '1')->orderBy('title', 'asc')->get();

        $title = $this->title;
        $url = $this->url;

        return view('admin.'.$url.'.index',compact('rows', 'roles', 'locations', 'categories', 'title', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::pluck('name','name')->all();
        $roles = Role::all();

        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'locations' => 'required',
            'categories' => 'required',
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user->assignRole($request->input('roles'));

        // Insert Locations
        $user->locations()->attach($request->locations);
        // Insert Categories
        $user->categories()->attach($request->categories);

        return redirect()->route('user.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        // $roles = Role::pluck('name','name')->all();
        $roles = Role::all();

        $userRole = $user->roles->pluck('name','name')->all();

        return view('user.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'roles' => 'required',
            'locations' => 'required',
            'categories' => 'required',
        ]);


        $input = $request->all();
        
        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        // Update Locations
        $user->locations()->sync($request->locations);
        // Update Categories
        $user->categories()->sync($request->categories);

        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if( $data->id == Auth::user()->id ){

            Session::flash('error', 'You are not permitted delete this!');
            return redirect()->back();
        }
        else{
            
            $data->delete();
            return redirect()->route('user.index')
                            ->with('success','User deleted successfully');
        }
    }
}