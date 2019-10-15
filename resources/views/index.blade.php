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
                    <div class="faq__item-icon"></div>
                    <div class="faq__item-title">{{ $faq->question }}</div>
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

                      <a href="https://api.addthis.com/oexchange/0.8/forward/email/offer?url=https%3A%2F%2Fwww.addthis.com%2F&pubid=ra-42fed1e187bae420&title=AddThis%20%7C%20Home&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/email.png" border="0" alt="Email"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=https%3A%2F%2Fwww.addthis.com%2F&pubid=ra-42fed1e187bae420&title=AddThis%20%7C%20Home&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=https%3A%2F%2Fwww.addthis.com%2F&pubid=ra-42fed1e187bae420&title=AddThis%20%7C%20Home&ct=1" target="_blank"><img src="https://cache.addthiscdn.com/icons/v3/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a>


                      <a href="https://www.facebook.com/sharer/sharer.php?u=https://hitechparks.com/&display=popup"> share this </a>

                      <a href="https://www.instagram.com/?url=https://www.facebook.com/" target="_blank" rel="noopener">
                          Share on instagram
                      </a>

                      <a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site http://www.website.com."
                         title="Share by Email">
                        <img src="http://png-2.findicons.com/files/icons/573/must_have/48/mail.png">
                      </a>
                      
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

                @foreach( $faq_categories as $faq_category )
                <li class="">
                  <div class="faq-nav__icon">
                    <i class="fas fa-exclamation-circle"></i>
                  </div>
                  <a href="{{ URL('/faq/category/'.$faq_category->id) }}">{{ $faq_category->title }}</a>
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