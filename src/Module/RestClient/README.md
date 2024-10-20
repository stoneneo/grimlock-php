Grimlock PHP - Grimlock WebClient
======

### Como usar

Como poder consumir un servicio Restfull

```php
use Grimlock\Module\RestClient\GrimlockRestClient;
use Grimlock\Module\RestClient\Bean\GrimlockResponse;

$grimlockRestClient = new GrimlockRestClient('http://localhost:8080');
$grimlockRestClient->addHeader('Authorization', 'Bearer e32434sdfdsfdsfdsf');
$response = new GrimlockResponse();
$response = $grimlockRestClient->get('/customers');


```