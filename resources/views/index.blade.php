@extends('layouts.master')
@section('title', 'Home')
@section('content')

      <!-- articles-->
      <section class="section section-faqs">
        <div class="preover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
        <div class="container wow fadeIn">
          <div class="row justify-content-end">
            <div class="col-lg-8">
              <div class="section-title mb-40">
                <h1>Ibiza Q&A</h1>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQs</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <div class="row justify-content-between">
            <div class="col-lg-8 order-lg-2">
              <div class="faq">
                <div class="faq__list">

                  @foreach( $faqs as $faq )
                  <div class="faq__item">
                    <div class="faq__item-title">
                      {{ $faq->question }}
                      <div class="faq__item-icon"></div>
                    </div>
                    <div class="faq__item-body">

                      @if(!empty($faq->video_id))
                      <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $faq->video_id }}?rel=0" allowfullscreen></iframe>
                      </div>
                      <br/>
                      @endif

                      @if(is_file('uploads/faq/'.$faq->image))
                      <img src="{{ asset('uploads/faq/'.$faq->image) }}" class="img-fluid" alt="Thumbnail image">
                      <br/><br/>
                      @endif

                      {!! $faq->answer !!}

                      <ul class="social">
                        <li class="social-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('single.faq.show', [$faq->id]) }}&display=popup" class="social-icons" target="_blank"><i class="fab fa-facebook-square"></i></a></li>

                        <li class="social-twitter"><a href="https://twitter.com/intent/tweet?url={{ route('single.faq.show', [$faq->id]) }}&text={{ $faq->question }}" class="social-icons" target="_blank"><i class="fab fa-twitter-square"></i></a></li>

                        <li class="social-email"><a href="mailto:?subject={{ $faq->question }}&amp;body=Check out the answer : {{ route('single.faq.show', [$faq->id]) }}" class="social-icons" target="_blank"><i class="fas fa-envelope"></i></a></li>
                      </ul>


                      {{-- <ul class="social">
                        <li class="social-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=https://codecanyon.net/user/hi-techparks/&display=popup" class="social-icons" target="_blank"><i class="fab fa-facebook-square"></i></a></li>

                        <li class="social-twitter"><a href="https://twitter.com/intent/tweet?url=https://codecanyon.net/user/hi-techparks/&text=your%20text" class="social-icons" target="_blank"><i class="fab fa-twitter-square"></i></a></li>

                        <li class="social-email"><a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site http://www.website.com." class="social-icons" target="_blank"><i class="fas fa-envelope"></i></a></li>
                      </ul> --}}


                      {{-- <a href="https://www.facebook.com/sharer/sharer.php?u=https://hitechparks.com/&display=popup"> share this </a>

                      <a href="https://www.instagram.com/?url=https://www.facebook.com/" target="_blank" rel="noopener">
                          Share on instagram
                      </a> --}}

                      {{-- <a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site http://www.website.com."
                         title="Share by Email">
                        <img src="http://png-2.findicons.com/files/icons/573/must_have/48/mail.png">
                      </a> --}}
                      
                    </div>
                  </div>
                  @endforeach
                  
                </div>
              </div>

              <nav class="wow fadeIn" aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                  {{ $faqs->links() }}
                </ul>
              </nav>

            </div>
            <aside class="aside col-lg-3 order-lg-1">
              <ul class="nostyle faq-nav">

                @foreach( $category_submenus as $category_submenu )
                <li class="">
                  <div class="faq-nav__icon">
                    <i class="fas fa-exclamation-circle"></i>
                  </div>
                  <a href="{{ URL('/faq/category/'.$category_submenu->slug) }}">{{ $category_submenu->title }}</a>
                </li>
                @endforeach
                
              </ul>
            </aside>
          </div>
        </div>
        <div class="postover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
      </section>
      <!-- ./ articles-->

@endsection