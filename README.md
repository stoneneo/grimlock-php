Grimlock PHP
======

![Grimlock Logo](assets/grimlock.png)

# ¿Qué es Grimlock PHP?
Es un framework que permite construir APIs RESTful de manera sencilla.

# Capacidades

* Cliente de apis REST
* Acceso a Base de Datos
* Generación de PDF en base a HTML
* Notificaciones Push Firebase
* Envío de Emails

# Requisitos

* PHP 8.3.1 o superior
* Composer 2.5.5 o superior

# Dependencias

* Slim 4
* Eloquent 
* Guzzle
* Dotenv
* DomPDF
* PHPMailer
* PHPUnit
* JWT Auth
* Monolog
* Google Auth

# Recommendaciones

Visita el wiki para mas información:
https://github.com/GorillaSoft/grimlock-php/wiki

# Instalación

La instalación es super facil con [Composer](https://getcomposer.org/):

```bash
composer require gorilla-soft/grimlock-php
```

Asegúrese de que el archivo de carga automática de Composer esté cargado.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';
```
# Como usar

## 1. GrimlockFirebase - Notificación Push con Firebase

Se debe tener en la carpeta resources la public key de firebase con el nombre firebase.json.

Se debe tener las siguientes propiedades en el archivo .env

```dotenv
FCM_PROJECT_ID = {FIREBASE_PROJECT_ID}
```

Enviar una notificación a una persona

```php
use Grimlock\Module\Notification\Firebase\GrimlockFirebase;
use Grimlock\Module\Notification\Firebase\Bean\Person;
use Grimlock\Module\Notification\Firebase\Bean\Notification;

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
Enviar una notificación a personas inscritas en un tópico
```php
use Grimlock\Module\Notification\Firebase\GrimlockFirebase;
use Grimlock\Module\Notification\Firebase\Bean\Notification;

$grimlockFirebase = new GrimlockFirebase();

$notification = new Notification();
$notification->setTopic("topic_test");
$notification->setTitle('Message Push Test');
$notification->setBody('Message Push Test');

$grimlockFirebase->sendNotification($notification);
```

## 2 GrimlockPdf - Generación de PDF desde HTML

```php
use Grimlock\Module\Pdf\GrimlockPdf;

$grimlockPdf = new GrimlockPdf();
$grimlockPdf->loadHTML('../../templates/demo.html');
$grimlockPdf->generatePDF('../../pdf/demo.pdf');
```

## 3. GrimlockRestClient - Cliente Rest

```php
use Grimlock\Module\RestClient\GrimlockRestClient;

$grimlockRestClient = new GrimlockRestClient('http://localhost:8080');
$grimlockRestClient->addHeader('Authorization', 'Bearer e32434sdfdsfdsfdsf');

//Return Object GrimlockResponse
$response = $grimlockRestClient->get('/customers');

if ($response->getCode() == 200) {
    $data = $response->getBody();
} 


```

## Licencia

Grimlock PHP esta bajo Licencia MIT.
