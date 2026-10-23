<label for="title">Başlık</label>
<input id="title" name="title" maxlength="150" value="{{ old('title', $post->title ?? '') }}" required>
<label for="content">Yazı</label>
<textarea id="content" name="content" rows="12" maxlength="20000" required>{{ old('content', $post->content ?? '') }}</textarea>
<button>Kaydet</button>
<a href="{{ route('posts.index') }}">Vazgeç</a>
