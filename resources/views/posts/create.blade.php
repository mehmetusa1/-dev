@extends('layouts.app')
@section('content')
<section class="panel">
    <h2>Yeni yazı</h2>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('posts._form')
    </form>
</section>
@endsection
