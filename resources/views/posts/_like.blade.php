<form class="like-form" action="{{ route('posts.like', $post) }}" method="POST">
    @csrf
    <button class="like-button {{ $post->liked ? 'is-liked' : '' }}" type="submit" aria-pressed="{{ $post->liked ? 'true' : 'false' }}" aria-label="{{ $post->title }}: {{ $post->liked ? 'Beğeniyi geri al' : 'Beğen' }}">
        <span aria-hidden="true">{{ $post->liked ? '♥' : '♡' }}</span>
        {{ $post->liked ? 'Beğeniyi geri al' : 'Beğen' }}
        <span class="like-count">{{ $post->likes_count }} beğeni</span>
    </button>
</form>
