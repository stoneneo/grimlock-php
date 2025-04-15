<?php

namespace Grimlock\Module\Pdf;

use Dompdf\Dompdf;
use Exception;
use Grimlock\Core\Exception\GrimlockException;
use Grimlock\Core\Util\Enumeration;
use Grimlock\Module\Pdf\Enum\PdfOrientation;
use Grimlock\Module\Pdf\Enum\PdfSize;

/**
 * Class GrimlockPdf
 * Class that facilitates the use of the DOMPDF library to load HTML and render it as PDF.
 * @package Grimlock
 * @author Rubén Darío Huamaní Ucharima
 */
class GrimlockPdf
{

    private Dompdf $pdf;

    /**
     *
     */
    public function __construct()
    {
        $this->pdf = new Dompdf();
    }

    /**
     * @param string $pathHTML
     * @param string $size
     * @param string $orientation
     * @return void
     * @throws GrimlockException
     */
    public function loadHTML(string $pathHTML, string $size = PdfSize::A4->value, string $orientation = PdfOrientation::VERTICAL->value): void
    {
        try {
            if (is_readable($pathHTML)) {
                if (!Enumeration::contains(PdfSize::class, $size)) {
                    throw new GrimlockException(GrimlockPdf::class, 'Size PDF not exist');
                }

                if (!Enumeration::contains(PdfOrientation::class, $orientation)) {
                    throw new GrimlockException(GrimlockPdf::class, 'Orientation PDF not exist');
                }

                ob_start();
                require_once($pathHTML);
                $pdf_html = ob_get_contents();
                ob_end_clean();

                $this->pdf->loadHtml($pdf_html, 'UTF-8');
                $this->pdf->setPaper($size, $orientation);
                $this->pdf->render();
            } else {
                throw new GrimlockException(GrimlockPdf::class, 'Variable $pathHTML is null.');
            }
        } catch (Exception $e) {
            throw new GrimlockException(GrimlockPdf::class, $e->getMessage());
        }
    }

    /**
     * @param string $nomPDF
     * @return void
     * @throws GrimlockException
     */
    public function generatePDF(string $nomPDF = ''): void
    {
        try {
            if (!empty($nomPDF)) {
                $options = array('MailAttachment' => 0);
                try {
                    ini_set('output_buffering', true);
                    $this->pdf->stream($nomPDF, $options);
                } catch(Exception $e) {
                    echo 'Error : '.$e->getMessage();
                }
            } else {
                throw new GrimlockException(GrimlockPdf::class, 'Name PDF cannot be null or empty');
            }
        } catch(Exception $e) {
            throw new GrimlockException(GrimlockPdf::class, $e->getMessage());
        }
    }

    /**
     * @param string $nomPDF
     * @return void
     * @throws GrimlockException
     */
    public function downloadPDF(string $nomPDF = ''): void
    {
        try {
            if (!empty($nomPDF)) {
                $options = array('MailAttachment' => 1);
                $this->pdf->stream($nomPDF, $options);
            } else {
                throw new GrimlockException(GrimlockPdf::class, 'Name PDF cannot be null or empty');
            }
        } catch(Exception $e) {
            throw new GrimlockException(GrimlockPdf::class, $e->getMessage());
        }
    }

}