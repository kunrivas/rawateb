<?php
//-------------------------------------------------------------------------------
// Author:    Hamza Abbas
// Discription: a class manages the months of the year .
//
// Contents:
// $MainVar : is the main variable handles the month number  over this class .
//
// Languages : Arabic , English .
//
// Methods:
// Display("language") returns the month in string .
// GetMonth() the cardinal number of the month .
// SetMonth("number") the cardinal number of the month .
// GetYear() retrieving the Year .
// SetYear("number") Setting the Year .
//-------------------------------------------------------------------------------
namespace App\Helper;

use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;

class CMPDF extends Mpdf
{
    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    protected $mpdf;

    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    public function initialize($settings = [])
    {

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = [public_path('fonts')];
        //$defaultConfig['fontDir'];
        $tempDir       = $defaultConfig['tempDir'];
        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = [
            'arial' => [
                'R' => 'arial.ttf',       // Regular
                'B' => 'arialbd.ttf',     // Bold
                'I' => 'arial.ttf',       // Italic (أو نسخ Regular إذا ما عندك Italic)
                'BI' => 'arialbd.ttf',    // BoldItalic (أو نسخ Bold)
                'type' => 'TTF',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],

            'janna' => [
                'R' => 'Janna_LT_Regular.ttf',
                'B' => 'Janna_LT_Bold.ttf',
                'type' => 'TTF',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'idcode39' => [
                'R' => 'IDAutomationHC39M.ttf',
                'type' => 'TTF',
            ],
        ];


        //$defaultFontConfig['fontdata'];

        $configGlobal      = [
            'mode'              =>  '',
            'format'            => ($settings) && isset($settings['format']) ? $settings['format'] : 'A4',
            'orientation'       => ($settings) && isset($settings['orientation']) ? $settings['orientation'] : 'P',
            'default_font_size' => ($settings) && isset($settings['default_font_size']) ? $settings['default_font_size'] : '12',
            'default_font'      => ($settings) && isset($settings['default_font']) ? $settings['default_font'] : 'sans-serif',
            'margin_left'       => ($settings) && isset($settings['margin_left']) ? $settings['margin_left'] : '10',
            'margin_right'      => ($settings) && isset($settings['margin_right']) ? $settings['margin_right'] : '10',
            'margin_top'        => ($settings) && isset($settings['margin_top']) ? $settings['margin_top'] : '10',
            'margin_bottom'     => ($settings) && isset($settings['margin_bottom']) ? $settings['margin_bottom'] : '10',
            'margin_header'     => ($settings) && isset($settings['margin_header']) ? $settings['margin_header'] : '0',
            'margin_footer'     => ($settings) && isset($settings['margin_footer']) ? $settings['margin_footer'] : '0',
            'fontDir'           => $fontDirs,
            'fontdata' => isset($settings['custom_font_data'])
                ? array_merge($fontData, $settings['custom_font_data'])
                : $fontData,

            'autoScriptToLang'  =>  false,
            'autoLangToFont'    =>  false,
            'tempDir'           => (rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR)) ?: $tempDir
        ];

        $this->mpdf = new Mpdf(array_merge($defaultConfig, $configGlobal));
        $this->mpdf->SetTitle(($settings) && isset($settings['title']) ? $settings['title'] : '');
        $this->mpdf->SetSubject(($settings) && isset($settings['subject']) ? $settings['subject'] : '');
        $this->mpdf->SetAuthor(($settings) && isset($settings['author']) ? $settings['author'] : '');
        $this->mpdf->SetWatermarkText(($settings) && isset($settings['watermark']) ? $settings['watermark'] : '');
        $this->mpdf->SetWatermarkImage(
            ($settings) && isset($settings['watermark_image_path']) ? $settings['watermark_image_path']  : '',
            ($settings) && isset($settings['watermark_image_alpha']) ? $settings['watermark_image_alpha']  : '',
            ($settings) && isset($settings['watermark_image_size']) ? $settings['watermark_image_size']  : '',
            ($settings) && isset($settings['watermark_image_position']) ? $settings['watermark_image_position'] : ''
        );
        $this->mpdf->SetDisplayMode(($settings) && isset($settings['display_mode']) ? $settings['display_mode'] : 'fullpage');
        $this->mpdf->PDFA               =   $settings['pdfa']  ?? false;
        $this->mpdf->PDFAauto           =  $settings['pdfaauto']  ?? false;
        $this->mpdf->showWatermarkText  =  ($settings) && isset($settings['show_watermark']) ? $settings['show_watermark'] : '';
        $this->mpdf->showWatermarkImage = ($settings) && isset($settings['show_watermark_image']) ? $settings['show_watermark_image'] : '';
        $this->mpdf->watermark_font     =  ($settings) && isset($settings['watermark_font']) ? $settings['watermark_font'] : '';
        $this->mpdf->watermarkTextAlpha =  ($settings) && isset($settings['watermark_text_alpha']) ? $settings['watermark_text_alpha'] : '';
        //use active forms
        $this->mpdf->useActiveForms =  ($settings) && isset($settings['use_active_forms']) ? $settings['use_active_forms'] : '';
        //$this->mpdf->shrink_tables_to_fit = 1;
        //use other pdf as background
        //$mpdf->SetImportUse(); // only with mPDF <8.0
        //$mpdf->SetDocTemplate('logoheader.pdf',true);
    }
    public function addFoterNumber()
    {
        $this->mpdf->use_kwt = true;
        $this->mpdf->setFooter('<h4 style="text-align: center; display:block;">{PAGENO}/{nbpg}</h4>');
    }
    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    public function getObject()
    {
        return $this->mpdf;
    }

    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    public function taceHTML($html)
    {

        $this->mpdf->WriteHTML($html);
    }

    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    public function viewToPDF($view, $data = [])
    {
        $html = View($view, $data)->render();
        $this->mpdf->WriteHTML($html);
    }

    //----------------------------------------------
    //   Mpdf
    //----------------------------------------------
    public function outPut($destination = 'I', $filename = 'document.pdf')
    {
        switch ($destination) {
            case 'F':
                $destination = Destination::FILE;
                break;
            case 'D':
                $destination = Destination::DOWNLOAD;
                break;
            case 'S':
                $destination = Destination::STRING_RETURN;
                break;
            case 'I':
                $destination = Destination::INLINE;
                break;
        }
        $this->mpdf->Output($filename, $destination);
    }
}
