@extends('layouts.master')
@section('title', 'Article')
@section('content')

      <!-- articles-->
      <section class="section">
        <div class="preover">
          <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="120" viewBox="0 0 1920 120" preserveAspectRatio="xMidYMax meet">
          	<path fill="#fff" d="M0,0 L0,120 L1920,120 L1920,0 L745,120 L0,0 Z"/>
          </svg>
        </div>
        <div class="container wow fadeIn">
          
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
              
            </div>
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