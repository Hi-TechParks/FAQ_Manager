<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @foreach( $settings as $setting )
    <!-- App Title -->
    <title>@yield('title') | {{ $setting->title }}</title>

    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/uploads/setting/'.$setting->favicon_path) }}">
    <link rel="shortcut icon" href="{{ asset('/uploads/setting/'.$setting->favicon_path) }}">

      @if(isset($page_meta))
        <meta name="description" content="{{ $page_meta->meta_desc }}">
        <meta name="keywords" content="{{ $page_meta->meta_keyword }}">
      @else
        <meta name="description" content="{{ $setting->description }}">
        <meta name="keywords" content="{{ $setting->keywords }}">
      @endif

    @endforeach

    @if(empty($setting))
    <!-- App Title -->
    <title>@yield('title')</title>
    @endif
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;#124;PT+Mono" rel="stylesheet">

    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/select2/js/select2.min.js') }}"></script>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->


    <!-- App CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main.css') }}">
    

  </head>
  <body class="loading">
    <div class="arcelia">
      <!-- header-->
      <header class="header text-inverse wow fadeIn">
        <div class="sky"></div>
        <div class="container">

          <!-- Top navbar-->
          <div class="menu">

            @if(isset($setting))
            <!-- App Logo -->
            <a class="logo" href="{{ URL('/') }}">
              <span>
                <img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo">
              </span>
            </a>
            @endif

            <nav>
              <div class="menu__close"><a href="#" title="close"><i class="icon-cross"></i></a></div>
              <ul>
                <li class="{{ Request::path() == '/' ? 'active' : '' }}"><a href="{{ URL('/') }}">Home</a></li>
                <!-- <li class="{{ Request::is('faq*')  ? 'active' : '' }}"><a href="{{ URL('/faqs') }}">Faqs</a></li> -->
                <li class="{{ Request::is('faq*')  ? 'active' : '' }}"><a  data-toggle="modal" data-target="#about_us" href="#">About</a></li>
                <li class="{{ Request::path() == 'ask' ? 'active' : '' }}">
                    <a class="btn btn-white ask_button" data-toggle="modal" data-target="#AskYourQuestion" href="#AskYourQuestion">Ask Your Question</a>
                </li>
              </ul>
            </nav><a class="menu__burger" href="#" title="Menu"><span></span><span></span><span></span></a>
          </div>

          <!-- search-->
          <div class="search">
            <h2 class="search__title">Going somewhere? Got questions?</h2>
            <div class="search__form">
              <form action="{{ URL('/search') }}" method="get">
                <!-- <input class="search__input" type="text" name="search" placeholder="Ask a question or search by keyword..."> -->
                <select class="location search__input select_search" name="location">
                  <option value="" selected="">All Location</option>
                </select>
                <select class="question search__input select_search" name="question"></select>

                <input type="submit" class="btn btn-white submit_search" name="submit" value="Search">

                <!-- <div class="search__icon"><i class="fas fa-search"></i></div> -->
              </form>
            </div>
          </div>

        </div>
      </header>
      <!-- ./ header-->


      <!-- Content Start -->
      @yield('content')
      <!-- Content End -->


      <!-- contactUs-->
      <section class="section section-contactUs text-inverse">
        <div class="container wow fadeIn">
          <div class="row align-items-center">
            <div class="col-lg-8 mb-40 text-lg-left text-center">
              <h2>No luck what you're looking&nbsp;for?</h2>
              <div class="lead">Let us know details about your quesiton. We'll get back to you!</div>
            </div>
            <div class="col-lg-4 mb-40 text-center"><a class="btn btn-white" data-toggle="modal" data-target="#AskYourQuestion" href="#AskYourQuestion">Ask Your Question</a>
            </div>
          </div>
        </div>
      </section>
      <!-- ./ contactUs-->

      <!-- footer-->
      <footer class="footer">

        <div class="copyright">
          <div class="container">
            @if(isset($setting))
            <div>© {!! $setting->footer_text !!}</div>
            @endif
          </div>
        </div>

      </footer>
      <!-- ./ footer-->



      <!-- Ask Your Question -->
      <div class="modal fade" id="AskYourQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Ask Your Question</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              

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
                        @foreach( $category_submenus as $category_submenu )
                        <option value="{{ $category_submenu->id }}">{{ $category_submenu->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" type="text" name="location" required>
                        <option value="">Select Location</option>
                        @foreach( $location_submenus as $location_submenu )
                        <option value="{{ $location_submenu->id }}">{{ $location_submenu->title }}</option>
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
      </div>
      <!-- Ask Your Question -->


      <!-- About Us -->
      <div class="modal fade" id="about_us" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">@if(isset($setting)) {{ $setting->about_title }} @endif</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    @if(isset($setting)) 
                    @if(is_file('uploads/setting/'.$setting->about_image))
                    <div class="about_us_image">
                      <img src="{{ asset('uploads/setting/'.$setting->about_image) }}" class="img-fluid mx-auto d-block" alt="About Us image">
                    </div>
                    @endif
                    @endif

                    @if(isset($setting))
                    <div class="about_us_details">
                      {!! $setting->about_details !!}
                    </div>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-md-6 col-sm-12">
                     <ul class="social">
                      @if(isset($socials))
                        @foreach( $socials as $social )
                          @if(isset($social->facebook))
                          <li class="social-facebook"><a href="{{ $social->facebook }}" class="social-icons" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                          @endif
                          @if(isset($social->twitter))
                          <li class="social-twitter"><a href="{{ $social->twitter }}" class="social-icons" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
                          @endif
                          @if(isset($social->linkedin))
                          <li class="social-linkedin"><a href="{{ $social->linkedin }}" class="social-icons" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                          @endif
                          @if(isset($social->youtube))
                          <li class="social-youtube"><a href="{{ $social->youtube }}" class="social-icons" target="_blank"><i class="fab fa-youtube-square"></i></a></li>
                          @endif
                        @endforeach
                      @endif
                     </ul>

                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- About Us -->

    </div>

    <!-- preloader-->
    <div class="preloader">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <!-- ./ preloader-->

    <!-- App scripts-->
    
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/all.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <!-- ./ App scripts-->



    <script type="text/javascript">

      $('.question').select2({
        placeholder: 'Ask Your Question!',
        minimumInputLength: 3,
        tags: true,
        ajax: {
          url: '{{ Route("question") }}',
          dataType: 'json',
          delay: 250,

          processResults: function (data) {
            return {
              results:  $.map(data, function (question) {
                    return {
                        text: question.question,
                        id: question.question
                    }
                })
            };
          },
          cache: true
        }
      });

    </script>

    <script type="text/javascript">
      $('.category').select2({
        placeholder: 'Select Category',
        minimumInputLength: 3,
        ajax: {
          url: '{{ Route("category") }}',
          dataType: 'json',
          delay: 250,

          processResults: function (data) {
            return {
              results:  $.map(data, function (category) {
                    return {
                        text: category.title,
                        id: category.id
                    }
                })
            };
          },
          cache: true
        }
      });


      $('.location').select2({
        placeholder: 'Location',
        minimumInputLength: 3,
        ajax: {
          url: '{{ Route("location") }}',
          dataType: 'json',
          delay: 250,

          processResults: function (data) {
            return {
              results:  $.map(data, function (location) {
                    return {
                        text: location.title,
                        id: location.id
                    }
                })
            };
          },
          cache: true
        }
      });




    /*$(document).ready(function() {
      $('.location22').select2({
          placeholder: "Select Location",
          tags: true,
          allowClear: true,
          minimumInputLength: 2,
          ajax: {
              url: '/search/location',
              type: "get",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      search_term: params.term
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.location.data, function(obj) {
                          return {id: obj.id,  text: obj.title };
                      })
                  };
              },
              cache: true
          }
      });
    });
*/    </script>

  </body>
</html>