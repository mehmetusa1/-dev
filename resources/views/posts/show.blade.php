@extends('layouts.app')
@section('content')
<article class="panel">
    @if($post->title === 'Cyberpunk')
        <img class="cover" src="{{ asset('img/cyberpunk.jpg') }}" alt="Cyberpunk 2077">
    @endif
    <h2>{{ $post->title }}</h2>
    <p class="date">Mehmet · {{ $post->created_at->format('d.m.Y H:i') }}</p>
    <p class="content">{{ $post->content }}</p>
    @include('posts._like')
    <a href="{{ route('posts.index') }}">Ana sayfaya dön</a>
    @if(session('admin'))
        <a class="edit-link" href="{{ route('posts.edit', $post) }}">Düzenle</a>
    @endif
</article>
@endsection
