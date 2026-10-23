<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminAndLikesTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_log_in_and_account_management_is_removed(): void
    {
        config(['blog.username' => 'owner', 'blog.password' => 'owner-password']);
        $user = User::create(['name' => 'Former user', 'username' => 'member', 'password' => Hash::make('password123')]);
        $this->post('/giris', ['username' => 'member', 'password' => 'password123'])->assertSessionHasErrors('login')->assertSessionMissing('admin');
        $this->assertGuest();
        $this->actingAs($user)->get('/')->assertOk()->assertSee('Admin girişi')->assertDontSee('Former user');
        $this->post('/posts', ['title' => 'Denied', 'content' => 'Denied'])->assertForbidden();
        $this->post('/giris', ['username' => 'owner', 'password' => 'owner-password'])->assertSessionHas('admin', true);
        $this->get('/')->assertOk()->assertDontSee('Kullanıcı ekle')->assertDontSee('Kişi ekle');
        $this->post('/users', [])->assertNotFound();
        $this->delete('/users/'.$user->id)->assertNotFound();
        $this->post('/people', [])->assertNotFound();
        $this->delete('/people/1')->assertNotFound();
    }

    public function test_guest_can_like_and_undo_with_counts_on_both_pages(): void
    {
        $post = Post::create(['title' => 'Article', 'content' => 'Content']);
        $this->get('/')->assertOk()->assertCookie('blog_visitor')->assertSee('0 beğeni');
        $this->withCookie('blog_visitor', (string) Str::uuid());
        $this->from('/')->post('/posts/'.$post->id.'/like')->assertRedirect('/');
        $this->assertDatabaseCount('post_likes', 1);
        $this->get('/')->assertSee('1 beğeni')->assertSee('Beğeniyi geri al');
        $this->get('/posts/'.$post->id)->assertOk()->assertSee('1 beğeni')->assertSee('Beğeniyi geri al');
        $this->post('/cikis');
        $this->get('/')->assertSee('Beğeniyi geri al');
        $this->post('/posts/'.$post->id.'/like')->assertRedirect();
        $this->assertDatabaseCount('post_likes', 0);
        $this->get('/')->assertSee('0 beğeni');
    }

    public function test_likes_are_separate_per_visitor_and_post_and_deleted_with_post(): void
    {
        $post = Post::create(['title' => 'First', 'content' => 'Content']);
        $other = Post::create(['title' => 'Second', 'content' => 'Content']);
        $firstVisitor = (string) Str::uuid();
        $this->withCookie('blog_visitor', $firstVisitor)->post('/posts/'.$post->id.'/like')->assertRedirect();
        $this->withCookie('blog_visitor', (string) Str::uuid())->post('/posts/'.$post->id.'/like')->assertRedirect();
        $this->get('/posts/'.$post->id)->assertSee('2 beğeni');
        $this->get('/posts/'.$other->id)->assertSee('0 beğeni');
        $this->withCookie('blog_visitor', $firstVisitor)->post('/posts/'.$post->id.'/like')->assertRedirect();
        $this->assertDatabaseCount('post_likes', 1);
        $this->post('/posts/999999/like')->assertNotFound();
        $this->withSession(['admin' => true])->delete('/posts/'.$post->id)->assertRedirect('/');
        $this->assertDatabaseCount('post_likes', 0);
    }
}
