<?php

namespace Grimlock\Tests\Module\Pdf;

use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Module\Pdf\GrimlockPdf;
use PHPUnit\Framework\TestCase;

class GrimlockPdfTest extends TestCase
{

    /**
     * @throws GrimlockException
     */
    public function testLoadHtmlException()
    {
        $grimlockPdf = new GrimlockPdf();
        $this->expectException(GrimlockException::class);
        $grimlockPdf->loadHTML("././resources/template.html.php");
    }


    /**
     * @throws GrimlockException
     */
    public function testGeneratePDFException()
    {
        $grimlockPdf = new GrimlockPdf();
        $this->expectException(GrimlockException::class);
        $grimlockPdf->loadHTML("././test/resources/template.html.php");
        $this->expectException(GrimlockException::class);
        $grimlockPdf->generatePDF();
    }

    /**
     * @throws GrimlockException
     */
    /*public function testDownloadPDF()
    {
        $htmlToPdf = new GrimlockPdf();
        $htmlToPdf->loadHTML("./test/resources/template.html.php");
        $this->assertEmpty($htmlToPdf->downloadPDF("template.pdf"));
    }*/

    /**
     * @throws GrimlockException
     */
    public function testDownloadPDFException()
    {
        $htmlToPdf = new GrimlockPdf();
        $this->expectException(GrimlockException::class);
        $htmlToPdf->loadHTML("./test/resources/template.html.php");
        $htmlToPdf->downloadPDF();
    }
    
}