<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<link rel="icon" href="{{ asset('img/postcodes_ng_map_pin2.png', true) }}" type="image/gif" sizes="20x20">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Postcodes.NG - @yield('title')</title>
<meta name="ROBOTS" content="INDEX,FOLLOW"/>
<meta name="description" content="@yield('description')"/>
<meta name="keywords" content="nigeria postcode,nigeria zipcode,nigeria state postcode,nigeria postal code,nigeria urban postcode,nigeria facility postcode"/>
<!-- <link rel="alternate" href="http://nigeriapostcodes.naijaz.com" hreflang="en-us" /> -->

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
@stack('styles')

<!-- Scripts -->
<script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
]) !!};
window.Laravel.webJWT = "{{ AjaxHelper::generateWebJWT() }}";
</script>
<script src="{{ mix('js/npc-polyfills.js') }}"></script>
<script src="{{ mix('js/npc-declarations.js') }}"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105002949-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<div id="app">

@yield('body')
</div>
<div class="npc-footer-wrapper">
@include('footer.footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/npc-common-functions.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<!--<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>-->
@stack('scripts')
</body>
</html>
