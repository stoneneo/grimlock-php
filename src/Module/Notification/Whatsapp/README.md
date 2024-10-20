Grimlock PHP - Grimlock Whatsapp
======

### Como usar

Se debe tener las siguientes propiedades en el archivo .env

```dotenv
WSP_HOST = https://graph.facebook.com/v18.0/{PHONE_NUMBER_ID}/messages
WSP_JWT = {WHATASPP_ACCESS_TOKEN}
```

```php
use Grimlock\Module\Notification\Whatsapp\GrimlockWhatsapp;
use Grimlock\Module\Notification\Whatsapp\Bean\Person;

$grimlockWhatsapp = new GrimlockWhatsapp();
$person = new Person();
$person->setName('Jon Doe');
$person->setNumber('+5199999999');

$grimlockWhatsapp->sendMessage('Test Notification', $person);
```