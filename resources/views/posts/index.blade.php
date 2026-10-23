@extends('layouts.app')
@section('content')
    @if(session('admin'))
        <p class="panel"><a href="{{ route('posts.create') }}">Yeni yazı ekle</a></p>
    @endif
    @forelse($posts as $post)
        <article class="panel">
            @if($post->title === 'Cyberpunk')
                <img class="cover" src="{{ asset('img/cyberpunk.jpg') }}" alt="Cyberpunk 2077">
            @endif
            <h2>{{ $post->title }}</h2>
            <p class="date">Mehmet · {{ $post->created_at->format('d.m.Y H:i') }}</p>
            <p class="content">{{ \Illuminate\Support\Str::limit($post->content, 450) }}</p>
            <a href="{{ route('posts.show', $post) }}">Devamını oku</a>
            @include('posts._like')
            @if(session('admin'))
                <div class="actions">
                    <a href="{{ route('posts.edit', $post) }}">Düzenle</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Bu yazı silinsin mi?')">Sil</button>
                    </form>
                </div>
            @endif
        </article>
        <hr class="separator">
    @empty
        <p class="panel">Henüz yazı eklenmedi.</p>
    @endforelse
    <section class="panel bottom">
        <div>
            <h2>Blog konuları</h2>
            <ol>
                <li>Tıbbın gelişimi</li>
                <li>Teknolojinin kötü yanları
                    <ol><li>Artan nüfus</li><li>Düzensiz kentleşme</li></ol>
                </li>
                <li>Her şeye erişimin kolay olması</li>
            </ol>
        </div>
        <div class="login">
            @if(session('admin'))
                <h2>Hoş geldin, Mehmet</h2>
                <p>Yazıları ekleyebilir, düzenleyebilir ve silebilirsin.</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button>Çıkış yap</button>
                </form>
            @else
                <h2>Admin girişi</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <label for="username">Kullanıcı adı</label>
                    <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" required>
                    <label for="password">Şifre</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" required>
                    <button>Giriş yap</button>
                </form>
            @endif
        </div>
    </section>
@endsection
