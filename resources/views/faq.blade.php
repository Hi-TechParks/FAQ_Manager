@extends('layouts.master')
@section('title', 'FAQ')
@section('content')

      <!-- articles-->
      <section class="section">
        <div class="preover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
        <div class="container wow fadeIn">
          <div class="row">
            <div class="col-lg-3">
              <div class="article-date">{{ date('d.m.y', strtotime($faq->created_at)) }}</div>
            </div>
            <div class="col-lg-9">
              <div class="section-title mb-40">
                <h1>{{ $faq->question }}</h1>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL('/faq/category/'.$faq->category->id) }}" title="">{{ $faq->category->title }}</a></li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
          <div class="row justify-content-between">
            <div class="col-lg-9 order-lg-2">

              <div class="article-full">

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

              </div>

              <div class="faq__item text-center">
                <ul class="social">
                  <li class="social-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u={{ route('single.faq.show', [$faq->id]) }}&display=popup" class="social-icons" target="_blank"><i class="fab fa-facebook-square"></i></a></li>

                  <li class="social-twitter"><a href="https://twitter.com/intent/tweet?url={{ route('single.faq.show', [$faq->id]) }}&text={{ $faq->question }}" class="social-icons" target="_blank"><i class="fab fa-twitter-square"></i></a></li>

                  <li class="social-email"><a href="mailto:?subject={{ $faq->question }}&amp;body=Check out the answer : {{ route('single.faq.show', [$faq->id]) }}" class="social-icons" target="_blank"><i class="fas fa-envelope"></i></a></li>
                </ul>
              </div>
              
            </div>

            <aside class="aside col-lg-3 order-lg-1">
              <ul class="nostyle categories-nav">
                @foreach( $category_submenus as $category_submenu )
                <li>
                  <div class="categories-nav__icon">
                    <i class="fas fa-folder-plus"></i>
                  </div>
                  <a href="{{ URL('/faq/category/'.$category_submenu->id) }}">{{ $category_submenu->title }}</a>
                  <sup>{{ $category_submenu->faqs->count() }}</sup>
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