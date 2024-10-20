Grimlock PHP - Grimlock Firebase
======

### Como usar

Se debe tener las siguientes propiedades en el archivo .env

```dotenv
FCM_KEY = {FIREBASE_KEY}
```

Enviar una notificación a una persona

```php
use Grimlock\Module\Notification\Firebase\GrimlockFirebase;
use Grimlock\Module\Notification\Firebase\Bean\Person;
use Grimlock\Module\Notification\Firebase\Bean\Notification;
use Grimlock\Core\Util\GrimlockList;

$grimlockFirebase = new GrimlockFirebase();

$person = new Person();
$person->setName('Jon');
$person->setLastname('Doe');
$person->setIdRegistration('121212asdasdasdsadas');

$notification = new Notification();
$notification->setTitle('Message Push Test');
$notification->setBody('Hello {NAME} {LASTNAME}. It is a message test.');

$grimlockFirebase->sendNotification($notification, $person);
```
Enviar una notificación a mas de una persona
```php
use Grimlock\Module\Notification\Firebase\GrimlockFirebase;
use Grimlock\Module\Notification\Firebase\Bean\Person;
use Grimlock\Module\Notification\Firebase\Bean\Notification;
use Grimlock\Core\Util\GrimlockList;

$notification = new Notification();
$notification->setTitle('Message Push Test');
$notification->setBody('Message Push Test');

$person1 = new Person();
$person1->setName('Jonny');
$person1->setLastname('Ramon');
$person1->setIdRegistration('121212asdasdasdsada111s');

$person2 = new Person();
$person2->setName('Eddie');
$person2->setLastname('Vedder');
$person2->setIdRegistration('121212asdasdasdsadas1111');

$persons = new GrimlockList();
$persons->append($person1);
$persons->append($person2);

$grimlockFirebase->sendNotifications($notification, $persons);
```