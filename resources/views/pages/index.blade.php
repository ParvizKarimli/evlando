@extends('layouts.app')

@section('content')
@foreach($posts as $post)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/posts/{{$post->id}}">
                        {{ $post->title }}
                    </a>
                </div>

                <div class="panel-body">
                    {{ $post->body }}
                </div>
            </div>
        </div>
    </div>
@endforeach
{{ $posts->links() }}
@endsection
