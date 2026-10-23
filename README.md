# Mehmet'in Blogu

İnternet Programcılığı II ödevi için sade Laravel blogu. BLOG1 ve BLOG2 örneklerindeki arka plan, Cyberpunk görseli, gri içerik alanı ve giriş bölümü kullanıldı.

## Bu bilgisayarda çalıştırma

`BASLAT.bat` dosyasına çift tıkla. Ardından tarayıcıda http://127.0.0.1:8000 adresini aç. Terminal açık kalmalı.


## Başka bilgisayarda kurulum

PHP 8.3 veya üzeri, PDO SQLite eklentisi ve Composer gerekir.

1. `composer install`
2. `.env.example` dosyasını `.env` adıyla kopyala; `BLOG_USERNAME` ve `BLOG_PASSWORD` değerlerini doldur.
3. `php artisan key:generate`
4. `database/database.sqlite` adında boş dosya oluştur.
5. `php artisan migrate --seed`
6. `php artisan serve`

Node.js veya npm kurulumu gerekmez.

## Nasıl çalışıyor?

- Herkes ana sayfayı ve yazı detayını okuyabilir.
- Giriş yapan yönetici yazı ekleyebilir, düzenleyebilir ve silebilir.
- Yalnızca admin giriş yapabilir; giriş bilgileri `.env` dosyasındaki `BLOG_USERNAME` ve `BLOG_PASSWORD` değerlerinden okunur.
- Kullanıcı hesabı ve kişi listesi yönetimi kaldırıldı. Eski kayıtlar veritabanında korunur fakat giriş için kullanılmaz.
- Ziyaretçiler ana sayfada ve yazı detayında beğeni verebilir, tekrar tıklayarak geri alabilir. Sayılar veritabanında saklanır. Tarayıcı, bir yıl geçerli şifreli çerezle tanınır; çerezleri silmek veya başka tarayıcı kullanmak yeni ziyaretçi sayılır.
- Mevcut kurulumu güncelledikten sonra `php artisan migrate` çalıştır.
- Yazılar ve eklenme tarihleri SQLite veritabanında kalıcı olarak saklanır.
- Ders notlarındaki Student model/controller örneği Post olarak uyarlandı. Migration, resource route, validate, Blade, csrf, method, include ve session kullanıldı.
- Ödevde istenen giriş için küçük bir LoginController ve her yazma işleminde sunucu tarafında oturum kontrolü eklendi.
- Temel CSS kullanıldı. Ek arayüz paketi, herkese açık kayıt formu, yorumlar veya dosya yükleme eklenmedi.
- Ses ve video blog ödevinin işlevleri için gerekli olmadığından eklenmedi.

## Dosyalar

`routes/web.php`: adresler. `app/Http/Controllers`: giriş ve yazı işlemleri. `app/Models/Post.php`: yazı modeli. `resources/views`: sayfalar. `public/style.css`: görünüm. `database/migrations`: yazı tablosu.

## Kontrol

`php vendor/phpunit/phpunit/phpunit` komutu giriş, ziyaretçi yetkileri, yazı ekleme/düzenleme/silme, doğrulama ve HTML kaçışını denetler. Testler bellekte ayrı veritabanı kullanır; mevcut yazıları değiştirmez.

## GitHub

Bu proje için commit veya push yapılmadı. `.gitignore`; `.env`, `vendor`, SQLite veritabanı ve çalışma dosyalarını dışarıda tutar. Giriş bilgilerini GitHub'a ekleme; `.env.example` şifre içermez.
