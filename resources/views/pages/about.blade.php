@extends('layouts.app')

@section('title', __('navbar.about_us'))

@section('content')
<p>{{ __('pages.about_text') }}</p>
<p>Developed by <a href="https://parvizkarimli.com" target="_blank">Parviz Karimli</a></p>
@endsection
