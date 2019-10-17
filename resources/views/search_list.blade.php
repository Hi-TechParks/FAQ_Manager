<!-- ===  Text Shorten Code  ====  -->
<?php
 // code for shortening the big content fetched from database
  function textShorten($text, $limit = 100){
     $text = $text." ";
     $text = substr($text, 0, $limit);
     $text = substr($text, 0, strrpos($text, " "));
     $text = $text;
     return $text;
 }
?> 
<!-- ===  Text Shorten Code  ====  -->


@foreach($faqs as $faq)
	<li>
	    <a href="{{ route('single.faq.show', $faq->id) }}">
	      <div class="search_question">{{ $faq->question }}</div>
	      <div class="search_answer">
	      	{!! textShorten($faq->answer) !!}
            @if(strlen($faq->answer) > 100)...@endif
	      </div>
	    </a>
	</li>
@endforeach

@if(count($faqs) <= 0)
	<li class="text-center">No records match with your search criteria</li>
@endif