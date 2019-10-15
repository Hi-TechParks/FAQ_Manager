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
            @if(isset($status))
            <a href="{{ URL::route($url.'.'.$status) }}" class="btn btn-info">View {{ $status }} list</a>
            @endif
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
                  <h4 class="header-title">{{ $status }} {{ $title }} List</h4>

                  <ul class="nav nav-tabs mb-3">
                    @if(isset($data))
                    <li class="nav-item">
                        <a href="#edit-tab" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Edit
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="#list-tab" data-toggle="tab" aria-expanded="false" class="nav-link @if(!isset($data)) active @endif">
                            List
                        </a>
                    </li>
                    @endif
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane show @if(!isset($data)) active @endif" id="list-tab">

                       <!-- ===  Text Shorten Code  ====  -->
                       <?php
                         // code for shortening the big content fetched from database
                          function textShorten($text, $limit = 40){
                             $text = $text." ";
                             $text = substr($text, 0, $limit);
                             $text = substr($text, 0, strrpos($text, " "));
                             $text = $text;
                             return $text;
                         }
                       ?> 
                       <!-- ===  Text Shorten Code  ====  -->

                      <!-- Data Table Start -->
                      <div class="table-responsive">
                        <table id="basic-datatable" class="table table-striped table-hover table-dark nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Question</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Asked By</th>
                                    @if($status == 'approve')
                                    <th>Email</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach( $rows as $key => $row )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ textShorten($row->question) }}
                                        @if(strlen($row->question) > 40)...@endif
                                    </td>
                                    <td>{{ $row->category->title }}</td>
                                    <td>{{ $row->location->title }}</td>
                                    <td>{{ $row->asked_by }}</td>
                                    @if($status == 'approve')
                                    <td>
                                        @if($row->mail == '0')
                                        <a href="{{ URL::route('faq.sendMail', ['id'=>$row->id, 'status'=>$status]) }}" class="btn btn-sm btn-primary">Send Mail</a>
                                        @else
                                        <a href="{{ URL::route('faq.sendMail', ['id'=>$row->id, 'status'=>$status]) }}" class="btn btn-sm btn-success">Mailed</a>
                                        @endif
                                    </td>
                                    @endif
                                    <td>
                                        @if( $row->status == 1 )
                                        <span class="badge badge-success badge-pill">Active</span>
                                        @elseif( $row->status == 2 )
                                        <span class="badge badge-primary badge-pill">Pending</span>
                                        @else
                                        <span class="badge badge-danger badge-pill">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal-{{ $row->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!-- Include Show modal -->
                                        @include('admin.'.$url.'.show')

                                        <a href="{{ URL::route($url.'.edit', ['id'=>$row->id, 'status'=>$status]) }}" class="btn btn-primary btn-sm">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $row->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Include Delete modal -->
                                        @include('admin.inc.delete')
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                      <!-- Data Table End -->

                    </div>
                    <div class="tab-pane @if(isset($data)) active @endif" id="edit-tab">
                        
                    @if(isset($data))
                      <form class="needs-validation" novalidate action="{{ URL::route($url.'.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Form Start -->
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" name="question" id="question" value="{{ $data->question }}" placeholder="Question" required>

                            <div class="invalid-feedback">
                              Please Provide FAQ Question.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="category" id="category" required>
                                <option value="">Select Category</option>
                                @foreach( $categories as $category )
                                <option value="{{ $category->id }}" @if( $category->id == $data->category_id ) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              Please Select FAQ Category.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <select class="form-control" name="location" id="location" required>
                                <option value="">Select Location</option>
                                @foreach( $locations as $location )
                                <option value="{{ $location->id }}" @if( $location->id == $data->location_id ) selected @endif>{{ $location->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              Please Select FAQ Location.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control textMediaEditor" name="answer" id="answer" rows="8" required>{{ $data->answer }}</textarea>

                            <div class="invalid-feedback">
                              Please Provide FAQ Answer.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Thumb</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Upload File">

                            <div class="invalid-feedback">
                              Please Provide Thumb Image.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="video_id">Youtube Video ID</label>
                            <input type="text" class="form-control" name="video_id" id="video_id" value="{{ $data->video_id }}" placeholder="Video ID">

                            <div class="invalid-feedback">
                              Please Provide Youtube Video ID.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Select Status</label>
                            <select class="wide" name="status" id="status" data-plugin="customselect">
                                <option value="1" @if( $data->status == 1 ) selected @endif>Active</option>
                                <option value="2" @if( $data->status == 2 ) selected @endif>Pending</option>
                                <option value="0" @if( $data->status == 0 ) selected @endif>Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <!-- Form End -->
                      </form>
                    @endif

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