Grimlock PHP - Grimlock Log
======

### Como usar

Se debe tener la siguiente propiedad en el archivo .env

```dotenv
PROJECT_LOG = ../logs/app.log
```

Se recomienda tener la carpeta de log fuera de la zona pública

```php
use Grimlock\Core\Log\GrimlockLog;
use Grimlock\Core\Log\Enum\LevelLog;

$grimlockLog = new GrimlockLog(LevelLog::Debug);

$grimlockLog->error("Message Error");
$grimlockLog->debug("Message Debug");
$grimlockLog->info(("Message Info"));
```