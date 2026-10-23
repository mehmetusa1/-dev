@extends('layouts.app')
@section('content')
<section class="panel">
    <h2>Yazıyı düzenle</h2>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf @method('PUT')
        @include('posts._form')
    </form>
</section>
@endsection
