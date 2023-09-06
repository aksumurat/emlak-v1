### Tasarım aşamasında 

Açık kaynak kodlu emlak sitesi yönetim paneli.

Paneli yapmak için FilamentPHP paketini kullandım.

Kurulum için izlenecek adımlar

- `cd <dizin adi>`
- `git clone https://github.com/gsarigul84/emlak .`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`

`.env` içerisinde bulunan veritabanı ayarları, site başlığı, site adresi gibi değerleri gerektiği gibi değiştirdikten sonra aşağıdaki işlemleri yapmanız gerekiyor
- `php artisan migrate --seed`
- `php artisan tinker`

Açılan konsolda :
- `User::create(['name' => '<ad>', 'email' => <eposta>, 'password' => Hash::make('<sifre>'), 'is_admin' => true, 'active' => true]);`

Filament ayarları için https://filamentphp.com/

Özel yazılım projeleriniz için mesaj atabilirsiniz.<br>
- 📫 Bana ulaşmak isterseniz **murat@murataksu.net.tr** adresini kullanabilirsiniz. <br><br>
![GitHub WidgetBox](https://github-widgetbox.vercel.app/api/profile?username=aksumurat&data=followers,repositories,stars,commits&theme=nautilus)
