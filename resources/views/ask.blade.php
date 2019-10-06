@extends('layouts.master')
@section('title', 'Contact')
@section('content')

      <!-- contacts-->     
      <section class="section">
        <div class="preover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
            <path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
        <div class="container wow fadeIn">
          <div class="section-title text-center">
            <h2>Ask Your Question</h2>

            <!-- Message Display -->
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
            @endif

            <!-- Message Display -->
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
            </div>
            @endif

            <!-- Error Display -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

          </div>
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
              <form class="contact-form" action="{{ URL('/ask') }}" method="post">
                @csrf
                <div class="row form-group">
                  <div class="col-md-6">
                    <input class="form-control" type="text" name="name" placeholder="Your name*" required>
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" type="email" name="email" placeholder="Your email*" required>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-6">
                    <select class="form-control" type="text" name="category" required>
                      <option value="">Select Category</option>
                      @foreach( $categories as $category )
                      <option value="{{ $category->id }}">{{ $category->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" type="text" name="location" required>
                      <option value="">Select Location</option>
                      @foreach( $locations as $location )
                      <option value="{{ $location->id }}">{{ $location->title }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="question" placeholder="Your Question" required></textarea>
                </div>
                <div class="text-center mb-10">
                  <button class="btn btn-accent" type="submit">Submit Your Question</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="postover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
      </section>
      <!-- ./ contacts-->

@endsection