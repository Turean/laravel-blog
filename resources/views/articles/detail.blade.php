@extends("layouts.app")

@section('title', 'Article Detail')
@section("content")
<div class="container">

    @if(session('unauthorized'))
    <div class="alert alert-danger">
        {{ session('unauthorized') }}
    </div>
    @endif

    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <div class="card-subtitle mb-2 text-muted small">
                By <b>{{ $article->user->name }}</b>,
                {{ $article->created_at->diffForHumans() }}
                Category: <b>{{ $article->category->name }}</b>
            </div>
            <p class="card-text">{{ $article->body }}</p>
            <a class="btn btn-danger" href="{{ url("/articles/delete/$article->id") }}">Delete</a>
        </div>
    </div>

    <ul class="list-group">
        <li class="list-group-item active">
            <b>Comments {{ count($article->comments) }}</b>
        </li>
        @foreach($article->comments as $comment)
        <li class="list-group-item">
            <a class="btn-close float-end" href="{{ url("/comments/delete/$comment->id") }}"></a>
            {{ $comment->content }}
            <div class="small mt-2">
                By <b>{{ $comment->user->name }}</b>,
                {{ $comment->created_at->diffForHumans() }}
                @if(session('error') && session('error')['comment_id'] == $comment->id)
                <div class="text-danger mt-1">
                    {{ session('error')['message'] }}
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>

    @auth
    <form action=" {{ url('/comments/add') }}" method="post" class="mt-2">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
        <input type="submit" value="Add Comment" class="btn btn-secondary">
    </form>
    @endauth

</div>
@endsection