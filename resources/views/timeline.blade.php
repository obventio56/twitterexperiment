@extends('layouts.app')

@section('content')
<div class="tweets-container">
  @foreach($tweets as $tweet)
  <div class="tweet" data-tweet-id="{{$tweet->id_str}}">

  </div>
  @endforeach
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://platform.twitter.com/widgets.js"></script>
<script>
$(document).ready(function(){
    $('.tweet').each( function() {
      var tweet = $(this)
      var tweet_id = tweet.data('tweet-id');
      $.getJSON("https://api.twitter.com/1/statuses/oembed.json?id=" + tweet_id + "&align=center&callback=?", function(data){
        console.log(data.html);
        console.log(tweet);
        tweet.html(data.html);
        
      });
    });
    
});
</script>
@endsection



