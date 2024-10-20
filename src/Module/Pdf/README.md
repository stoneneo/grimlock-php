Grimlock PHP - Grimlock PDF
======

### Como usar

Generar un archivo PDF desde un archivo HTML

```php
use Grimlock\Module\Pdf\GrimlockPdf;

$grimlockPdf = new GrimlockPdf();
$grimlockPdf->loadHTML('../../templates/demo.html');
$grimlockPdf->generatePDF('../../pdf/demo.pdf');
```