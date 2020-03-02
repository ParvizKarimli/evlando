@extends('layouts.app')

@section('title', __('navbar.about_us'))

@section('content')
<p>{{ __('pages.about_text') }}</p>
<p><a href="https://parvizkarimli.com" target="_blank">&copy; Parviz Karimli</a></p>
@endsection
