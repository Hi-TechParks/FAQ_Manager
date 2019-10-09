@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">
    
    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <!-- end page title --> 


    <div class="row">
        <div class="col-12">
            <a href="{{ URL::route($url.'.index') }}" class="btn btn-info">Refresh</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <!-- Include Flash Messages -->
                    @include('admin.inc.message')
                </div>

                <div class="card-body">
                  <h4 class="header-title">{{ $title }} Setting</h4>
                  <br/>

                  <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a href="#profile-tab" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Profile Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#password-tab" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Change Password
                        </a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane show active" id="profile-tab">

                      @foreach( $rows as $row )
                      <!-- Form Start -->
                      <form class="needs-validation" novalidate action="{{ URL::route($url.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="name">Profile Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $row->name }}" placeholder="Profile Name" required>

                            <div class="invalid-feedback">
                              Please Provide Profile Name.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" placeholder="Email" disabled>

                            <div class="invalid-feedback">
                              Please Provide Email Address.
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" placeholder="Phone">

                            <div class="invalid-feedback">
                              Please Provide Phone Number.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $row->address }}" placeholder="Address" required>

                            <div class="invalid-feedback">
                              Please Provide Address.
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="dob">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="{{ $row->dob }}" placeholder="Date Of Birth" required>

                            <div class="invalid-feedback">
                              Please Provide Date Of Birth.
                            </div>
                          </div>

                          <div class="form-group col-md-6">
                            <label for="image">Photo</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Photo">

                            <div class="invalid-feedback">
                              Please Provide Profile Photo.
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="details">Profile Details</label>
                            <textarea class="form-control summernote" name="details" id="details" rows="8">{{ $row->profile }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>

                      </form>
                      <!-- Form End -->
                      @endforeach

                    </div>
                    <div class="tab-pane" id="password-tab">
                        
                      <!-- Form Start -->
                      <form class="needs-validation" novalidate action="{{ URL::route($url.'.changepass') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="old_password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="invalid-feedback">
                                  Please Provide Your Old Password.
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="invalid-feedback">
                                  Please Provide A New Password.
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="invalid-feedback">
                                Please Confirm Your New Password.
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>

                      </form>
                      <!-- Form End -->

                    </div>
                  </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

    
</div> <!-- container -->
<!-- End Content-->

@endsection