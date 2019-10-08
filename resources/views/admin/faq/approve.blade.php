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
            <!-- Add modal button -->

            <a href="{{ URL::route($url.'.approve') }}" class="btn btn-info">Refresh</a>
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
                  <h4 class="header-title">Approve {{ $title }} List</h4>

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
                                <th>Email</th>
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
                                <td>
                                    @if($row->mail == '0')
                                    <a href="{{ route('faq.sendMail', [$row->id]) }}" class="btn btn-sm btn-primary">Send Mail</a>
                                    @else
                                    <a href="{{ route('faq.sendMail', [$row->id]) }}" class="btn btn-sm btn-success">Mailed</a>
                                    @endif
                                </td>
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

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $row->id }}">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <!-- Include Edit modal -->
                                    @include('admin.'.$url.'.edit')

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

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

    
</div> <!-- container -->
<!-- End Content-->

@endsection