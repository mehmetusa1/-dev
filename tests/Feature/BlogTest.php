<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_can_read_but_cannot_change_posts(): void
    {
        $post = Post::create(['title' => 'Deneme', 'content' => 'Bir blog yazısı.']);
        $this->get('/')->assertOk()->assertSee('Deneme')->assertDontSee('Yeni yazı ekle');
        $this->get('/posts/'.$post->id)->assertOk()->assertSee('Bir blog yazısı.');
        $this->get('/posts/create')->assertForbidden();
        $this->get('/posts/'.$post->id.'/edit')->assertForbidden();
        $this->post('/posts', ['title' => 'İzinsiz', 'content' => 'Deneme'])->assertForbidden();
        $this->put('/posts/'.$post->id, ['title' => 'İzinsiz', 'content' => 'Deneme'])->assertForbidden();
        $this->delete('/posts/'.$post->id)->assertForbidden();
        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseHas('posts', ['title' => 'Deneme']);
    }

    public function test_login_create_edit_delete_and_logout(): void
    {
        config(['blog.username' => 'testadmin', 'blog.password' => 'test-password']);
        $this->post('/giris', ['username' => 'testadmin', 'password' => 'wrong'])
            ->assertSessionHasErrors('login')->assertSessionMissing('admin');
        $this->post('/giris', ['username' => 'testadmin', 'password' => 'test-password'])
            ->assertRedirect('/')->assertSessionHas('admin', true);
        $this->get('/posts/create')->assertOk();
        $this->post('/posts', ['title' => '', 'content' => ''])->assertSessionHasErrors(['title', 'content']);
        $this->post('/posts', ['title' => 'Yeni yazı', 'content' => '<script>alert(1)</script>'])->assertRedirect('/');
        $post = Post::firstOrFail();
        $this->get('/posts/'.$post->id)->assertSee('&lt;script&gt;', false)->assertDontSee('<script>', false);
        $this->get('/posts/'.$post->id.'/edit')->assertOk();
        $this->put('/posts/'.$post->id, ['title' => 'Güncel yazı', 'content' => 'Güncel içerik'])->assertRedirect('/');
        $this->assertDatabaseHas('posts', ['title' => 'Güncel yazı']);
        $this->delete('/posts/'.$post->id)->assertRedirect('/');
        $this->assertDatabaseCount('posts', 0);
        $this->post('/cikis')->assertRedirect('/')->assertSessionMissing('admin');
        $this->get('/posts/create')->assertForbidden();
    }
}
