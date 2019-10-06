@extends('layouts.master')
@section('title', 'Contact')
@section('content')

      <!-- contacts-->
      <section class="section section-contacts">
        <div class="preover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
        <div class="container wow fadeIn">
          <div class="section-title decor__center">
            <h1>Contacts</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ URL('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contacts</li>
              </ol>
            </nav>
          </div>

          @foreach( $settings as $setting )
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-80">
              <div class="contact">
                <div class="contact__icon"><i class="fas fa-phone"></i></div>
                <div class="contact__text">
                  {{ $setting->phone_one }}<br>{{ $setting->phone_two }}
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-80">
              <div class="contact">
                <div class="contact__icon"><i class="fas fa-envelope-open-text"></i></div>
                <div class="contact__text">
                  {{ $setting->email_one }}<br>{{ $setting->email_two }}
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-80">
              <div class="contact">
                <div class="contact__icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="contact__text">
                  {{ $setting->contact_address }}
                </div>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </section>
      
      <section class="section">
        <div class="container wow fadeIn">
          <div class="section-title text-center">
            <h2>Get in touch with&nbsp;us</h2>

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
              <form class="contact-form" action="{{ URL('/contact') }}" method="post">
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
                    <input class="form-control" type="text" name="phone" placeholder="Your phone">
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" type="text" name="subject" placeholder="Subject*" required>
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" placeholder="Your message" required></textarea>
                </div>
                <div class="text-center mb-10">
                  <button class="btn btn-accent" type="submit">Submit a Message</button>
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