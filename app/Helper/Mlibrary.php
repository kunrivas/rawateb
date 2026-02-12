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

// Register this Helper.php into config/app.php file
// 'aliases' => [
//        ....
//        'Helper' => App\Helper\Helper::class
//  ]
//'Mlibrary' => App\Helper\Mlibrary::class,


namespace App\Helper;



class Mlibrary
{
    // //----------------------------------------------
    // //   Mpdf
    // //----------------------------------------------
    // public static function viewToPDF($view ,$data=[], $settings=[] ,$destination='I' , $filename='document.pdf' ){

    //     //if (!defined('_MPDF_TTFONTPATH')) {
    //     //    // an absolute path is preferred, trailing slash required:
    //     //    //define('_MPDF_TTFONTPATH', realpath('fonts/'));
    //     //    // example using Laravel's resource_path function:
    //     //    define('_MPDF_TTFONTPATH', public_path('theme/font'));
    //     //}



    //     $defaultConfig = (new ConfigVariables())->getDefaults();
    //     $fontDirs      = $defaultConfig['fontDir'];
    //     $tempDir       = $defaultConfig['tempDir'];
    //     $defaultFontConfig = (new FontVariables())->getDefaults();
    //     $fontData          = $defaultFontConfig['fontdata'];

    //     $configGlobal      = [
    //         'mode'              =>  '',
    //         'format'            =>  'A4',
    //         'orientation'       =>  'P',
    //         'default_font_size' =>  '12',
    //         'default_font'      =>  'sans-serif',
    //         'margin_left'       =>  '10',
    //         'margin_right'      =>  '10',
    //         'margin_top'        =>  '10',
    //         'margin_bottom'     =>  '10',
    //         'margin_header'     =>  '0',
    //         'margin_footer'     =>  '0',
    //         'fontDir'           =>  ($settings) ? array_merge($fontDirs , [$settings['custom_font_dir']]) : $fontDirs ,
    //         'fontdata'          =>  ($settings) ? array_merge($fontData + $settings['custom_font_data'] ) : $fontData ,
    //         'autoScriptToLang'  =>  false,
    //         'autoLangToFont'    =>  false,
    //         'tempDir'           =>  ( rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR)) ?: $tempDir
    //     ];

    //     $configMerge = array_merge($configGlobal, $settings);
    //     $this->mpdf = new Mpdf(array_merge($defaultConfig,$configGlobal));

    //     $this->mpdf->SetTitle( ($settings) ? $settings['title'] : '');
    //     $this->mpdf->SetSubject(  ($settings) ? $settings['subject'] : '' );
    //     $this->mpdf->SetAuthor(  ($settings) ? $settings['author'] : '' );
    //     $this->mpdf->SetWatermarkText( ($settings) ? $settings['watermark'] : '' );
    //     $this->mpdf->SetWatermarkImage(
    //          ($settings) ? $settings['watermark_image_path'    ]  : '' ,
    //          ($settings) ? $settings['watermark_image_alpha'   ]  : '' ,
    //          ($settings) ? $settings['watermark_image_size'    ]  : '' ,
    //          ($settings) ? $settings['watermark_image_position'] : ''
    //     );
    //     $this->mpdf->SetDisplayMode( ($settings) ? $settings['display_mode'] : 'fullpage' );
    //     $this->mpdf->PDFA               =   $settings['pdfa']  ?? false;
    //     $this->mpdf->PDFAauto           =  $settings['pdfaauto']  ?? false;
    //     $this->mpdf->showWatermarkText  =  ($settings) ? $settings['show_watermark'] : '' ;
    //     $this->mpdf->showWatermarkImage = ($settings) ? $settings['show_watermark_image'] : '' ;
    //     $this->mpdf->watermark_font     =  ($settings) ? $settings['watermark_font'] : '' ;
    //     $this->mpdf->watermarkTextAlpha =  ($settings) ? $settings['watermark_text_alpha'] : '' ;
    //     //use active forms
    //     $this->mpdf->useActiveForms =  ($settings) ? $settings['use_active_forms'] : '' ;

    //     //$stylesheet = file_get_contents('style.css');
    //     //$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    //     //$mpdf->WriteHTML($content,\Mpdf\HTMLParserMode::HTML_BODY);

    //     //use other pdf as background
    //     //$mpdf->SetImportUse(); // only with mPDF <8.0
    //     //$mpdf->SetDocTemplate('logoheader.pdf',true);
    //     $html = View::make($view, $data)->render() ;
    //     $this->mpdf->WriteHTML($html); //


    //     switch ($destination) {
    //         case 'F':
    //             $destination = Destination::FILE ;
    //         break;
    //         case 'D':
    //             $destination = Destination::DOWNLOAD ;
    //         break;
    //         case 'S':
    //             $destination = Destination::STRING_RETURN ;
    //         break;
    //         case 'I':
    //             $destination = Destination::INLINE ;
    //         break;
    //     }

    //     return $this->mpdf->Output($filename,$destination);//
    // }


    // property declaration :
    // public $MainVar = '';
    // public $Year = "";
    // private $YearMonthsEnglish = array(
    // '1' =>"January" ,
    // '2' =>"Febuary" ,
    // '3' =>"March" ,
    // '4' =>"April" ,
    // '5' =>"Mai" ,
    // '6' =>"June" ,
    // '7' =>"July" ,
    // '8' =>"August" ,
    // '9' =>"September" ,
    // '10' =>"October" ,
    // '11' =>"November" ,
    // '12' =>"December");
    // private $YearMonthsArabic = array(
    // '1' =>"جانفي" ,
    // '2' =>"فيفري" ,
    // '3' =>"مارس" ,
    // '4' =>"أفريل" ,
    // '5' =>"ماي" ,
    // '6' =>"جوان" ,
    // '7' =>"جويلية" ,
    // '8' =>"أوت" ,
    // '9' =>"سبتمبر" ,
    // '10' =>"أكتوبر" ,
    // '11' =>"نوفمبر" ,
    // '12' =>"ديسمبر");

    // // Display method declaration
    // public function DisplayMonth($lang = "Arabic") {
    //     if( $lang == "Arabic" )
    //     print $this->YearMonthsArabic[$this->MainVar];
    //     if( $lang == "English" )
    //     print $this->YearMonthsEnglish[$this->MainVar];
    // }

    // // Set method declaration
    // public function GetDate() {
    //     if(strlen($this->MainVar) > 1)
    //     $m = $this->MainVar ;
    //     else {
    //     $m="0".$this->MainVar ;
    //     }
    //     $date = $this->Year."/".$m."/01" ; //"01/".$this->MainVar."/".$this->Year
    //     return $date;
    // }

    // // Set method declaration
    // public function GetDateTo($month) {
    //     if(strlen($month) > 1)
    //     $m = $month ;
    //     else {
    //     $m="0".$month ;
    //     }
    //     $date = $this->Year."/".$m."/".$this->GetMonthDaysNumber($month) ; //"01/".$this->MainVar."/".$this->Year
    //     return $date;
    // }

    //     // Get method declaration
    // public function GetMonth() {
    //     return $this->MainVar;
    // }

    // function getArabicMonth($month_number) {
    //     $YearMonthsArabic = array(
    //         '1' =>"جانفي" ,
    //         '2' =>"فيفري" ,
    //         '3' =>"مارس" ,
    //         '4' =>"أفريل" ,
    //         '5' =>"ماي" ,
    //         '6' =>"جوان" ,
    //         '7' =>"جويلية" ,
    //         '8' =>"أوت" ,
    //         '9' =>"سبتمبر" ,
    //         '10' =>"أكتوبر" ,
    //         '11' =>"نوفمبر" ,
    //         '12' =>"ديسمبر"
    //     );
    //     return $YearMonthsArabic[$month_number];
    // }


    // // Get method declaration
    // public function GetFirstMonthDate() {
    //     return " ".$this->Year."/01/01 ";
    // }

    // // Get method declaration
    // public function GetMonthDaysNumber($month) {
    //     return cal_days_in_month(CAL_GREGORIAN,$month,$this->Year) ;
    // }

    // // Get method declaration
    // public function GetDateByMonth($month) {
    //     return $this->GetDateTo($month);
    // }

    //     // Set method declaration
    // public function SetMonth($var) {
    //     $this->MainVar = $var;
    // }


    // // Set method declaration
    // public function SetMonthStr($var) {
    //     foreach($this->YearMonthsArabic as $month)
    //     {
    //     ++$i;
    //     if($month == $var ){
    //         $this->MainVar = $i;
    //         return;
    //     }
    //     }
    // }

    // // Display method declaration
    // public function DisplayYear() {
    //     print $this->Year ;
    // }

    // // Get method declaration
    // public function GetYear() {
    //     return $this->Year;
    // }

    // // Get method declaration
    // public function GetPreviousYear() {
    //     return ($this->Year-1);
    // }

    // // Set method declaration
    // public function SetYear($var) {
    //     $this->Year = $var;
    // }


    //-------------------------------------------------------------------------------
    // echo a currency format
    //
    //
    //
    //-------------------------------------------------------------------------------
    public static function print_currency($currency)
    {
        echo number_format($currency, 2);
    }

    //-------------------------------------------------------------------------------
    // Make currency format
    //
    //
    //
    //-------------------------------------------------------------------------------
    public static function make_currency($currency, $thousands_separator = '', $currency_mark = '')
    {
        if (!empty($currency_mark)) {
            $currency_mark =  " $currency_mark ";
        }
        return number_format($currency, 2, '.', $thousands_separator) . $currency_mark;
    }

    //-------------------------------------------------------------------------------
    //
    //
    //
    //
    //-------------------------------------------------------------------------------
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    //-------------------------------------------------------------------------------
    //
    //
    //
    //
    //-------------------------------------------------------------------------------
    public static function getArabicMonth($month_number)
    {
        $YearMonthsArabic = array(
            '1' => "جانفي",
            '2' => "فيفري",
            '3' => "مارس",
            '4' => "أفريل",
            '5' => "ماي",
            '6' => "جوان",
            '7' => "جويلية",
            '8' => "أوت",
            '9' => "سبتمبر",
            '10' => "أكتوبر",
            '11' => "نوفمبر",
            '12' => "ديسمبر"
        );
        return $YearMonthsArabic[$month_number];
    }

    //-------------------------------------------------------------------------------
    //
    //
    //
    //
    //-------------------------------------------------------------------------------
    public static function getMonthDaysNumber($year, $month)
    {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }
    public static function getDateFormat($str)
    {
        if (empty($str)) {
            return '/';
        }

        return date("Y/m/d", strtotime($str));
    }

    public static function getYearRange($start, $end)
    {
        return  range($start, $end); // => [2010, 2009, 2008, ... ]

    }
    public static function getRendament($rendament)
    {
        switch ($rendament) {
            case 1:
                return "الثلاثي الأول";
            case 2:
                return "الثلاثي الثاني";
            case 3:
                return "الثلاثي الثالث";
            case 4:
                return "الثلاثي الرابع";
        }
    }


    public static function getTrimestre($month_number)
    {
        switch ($month_number) {
            case 1:
            case 2:
            case 3:
                return 1;
            case 4:
            case 5:
            case 6:
                return 2;
            case 7:
            case 8:
            case 9:
                return 3;
            case 10:
            case 11:
            case 12:
                return 4;
        }
    }

    public static function getRappelType($type)
    {
        switch ($type) {
            case 1:
                return "درجة";
            case 2:
                return "منحة المنطقة";
            case 3:
                return "منحة الجنوب";
            case 4:
                return "منحة السكن";
            case 5:
                return "الأجر الوحيد";
            case 6:
                return "المنح العائلية";
            case 7:
                return "  أكبر من 10 سنوات";
        }
    }
    public static function getAbsenceType($type)
    {
        switch ($type) {

            case 1:
                return "عطلة أمومة";
            case 2:
                return "عطلة مرضية";
            case 3:
                return "غرض شخصي";
            case 4:
                return "غياب عن الحراسة";
            case 5:
         return "غياب عن  تكوين أو مجلس ";
            case 6:
                return "غير مبرر";
            case -1:
                return "إضراب";
        }

    }
}
