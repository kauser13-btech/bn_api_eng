<?php 
namespace App\Helpers;
use App\Http\Controllers\MonthlyFolderController;
use Carbon\Carbon;

class customCalendar {


    public static function fFormatDateEn2Bn(){
		$dtHourDifference=6;
		$dtTimeDifference=60*60*$dtHourDifference;

		$bn=new BanglaDate(time());
		$bn->set_time(time(), 6);
		$date=$bn->get_date();
		$location='ঢাকা, ';
		$dtDay=gmdate("l", time()+$dtTimeDifference)."&nbsp;"; //Local
		$dtDateBN=$date[0]."&nbsp;".$date[1]."&nbsp;".$date[2];
		$dtDateEN=gmdate("d F Y", time()+$dtTimeDifference);
		$dtTime=gmdate("g:i a", time()+$dtTimeDifference).", &nbsp;";
		// $dtDateShow=$location.$dtDay.$dtDateBN.$dtDateEN;

		//Convert a English date to Bangla date
		$en=array("AM","PM","am","pm","Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","January","February","March","April","May","June","July","August","September","October","November","December","0","1","2","3","4","5","6","7","8","9");
		$bn=array("এএম","পিএম","পূর্বাহ্ণ","অপরাহ্ণ","শনিবার","রবিবার","সোমবার","মঙ্গলবার","বুধবার","বৃহস্পতিবার","শুক্রবার","জানুয়ারি","ফেব্রুয়ারি","মার্চ","এপ্রিল","মে","জুন","জুলাই","আগস্ট","সেপ্টেম্বর","অক্টোবর","নভেম্বর","ডিসেম্বর","০","১","২","৩","৪","৫","৬","৭","৮","৯");
		// $BDDate=str_replace($en,$bn,$dtDateShow);

		$getDay = str_replace($en,$bn,$dtDay);
		$getDtDateBN = str_replace($en,$bn,$dtDateBN);
		$getDtDateEN = str_replace($en,$bn,$dtDateEN);

		$dtDateShow = $location.$getDay.$getDtDateEN.' <br /> '.$getDtDateBN;

		return $dtDateShow;
	}

    public static function hijri(){
        $format="YYYY/MM/DD";
        $date=Carbon::now()->setTimezone('Asia/Dhaka');
        // $date=date('Y-m-d', time() + 86500);
        $DateConv=new Hijri_GregorianConvert;
        $hijriday=$DateConv->GregorianToHijri($date,$format);
        return $hijriday;
    }
    public function fFormatDateTimeEn2Bn($datetime){
        //Convert a English date to Bangla date
        $en=array("AM","PM","am","pm","Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","January","February","March","April","May","June","July","August","September","October","November","December","0","1","2","3","4","5","6","7","8","9");
        $bn=array("এএম","পিএম","পূর্বাহ্ণ","অপরাহ্ণ","শনিবার","রবিবার","সোমবার","মঙ্গলবার","বুধবার","বৃহস্পতিবার","শুক্রবার","জানুয়ারি","ফেব্রুয়ারি","মার্চ","এপ্রিল","মে","জুন","জুলাই","আগস্ট","সেপ্টেম্বর","অক্টোবর","নভেম্বর","ডিসেম্বর","০","১","২","৩","৪","৫","৬","৭","৮","৯");
        $BDDate=str_replace($en,$bn,$datetime);
        return $BDDate;
    }

    public static function getUploadImageAllBGPath(){
        $sMonthlyImageFolder=MonthlyFolderController::getLastMonthlyImageFolder();
        $sPath=config('emythconfig.MediaPath')."$sMonthlyImageFolder/bg";
        return $sPath;
    }
    public static function getUploadImageAllSMPath(){
        $sMonthlyImageFolder=MonthlyFolderController::getLastMonthlyImageFolder();
        $sPath=config('emythconfig.MediaPath')."$sMonthlyImageFolder/sm";
        return $sPath;
    }

    public static function getGalleryImagePath(){
        $sMonthlyImageFolder=MonthlyFolderController::getLastMonthlyImageFolder();
        $sPath=config('emythconfig.Gallery')."$sMonthlyImageFolder";
        return $sPath;
    }


    public function stripe($file){
        $File = str_replace(' ', '-', $file);
        $arrWords = array(":", "�", "�", "/", "'", "`", "?", "&", "(", ")", "!");
        $File = str_replace($arrWords, ' ', $File);
        $File = strip_tags($File);
        $File = html_entity_decode($File);
        $File = str_replace(' ', '', $File);;
        $compressFile = strtolower($File);
        return $compressFile;
    }
    public function after ($mark, $inthat){
        if (!is_bool(strpos($inthat, $mark)))
            return substr($inthat, strpos($inthat,$mark)+strlen($mark));
    }

    public function fFormatURL($s){
        global $connEMM;
        //Excludes HTML tags from a text
        $sStr=trim($s);
        $arrWords=array(":","‘","’","/","'","`","?", "“", ",", "  ", '"', "<", ">", "~", "`", "!", "@", "$", "%", "^", "&", "*", "(", ")", "[", "]", "{", "}", "+", "|");
        $sStr=str_replace($arrWords, "", $sStr);
        $sStr=strip_tags($sStr);//Strip HTML and PHP tags from a string
        $sStr=html_entity_decode($sStr);
        $sStr=str_replace(" ", "-", $sStr);
        return $sStr;
    }
}

class BanglaDate{
    private $timestamp;	//timestamp as input
    private $morning;	//when the date will change?
    private $engHour;	//Current hour of English Date
    private $engDate;	//Current date of English Date
    private $engMonth;	//Current month of English Date
    private $engYear;	//Current year of English Date
    private $bangDate;	//generated Bangla Date
    private $bangMonth;	//generated Bangla Month
    private $bangYear;	//generated Bangla	Year
    function __construct($timestamp, $hour = 6){$this->BanglaDate($timestamp, $hour);}
    function BanglaDate($timestamp, $hour = 6){
        $this->engDate = date('d', $timestamp);
        $this->engMonth = date('m', $timestamp);
        $this->engYear = date('Y', $timestamp);
        $this->morning = $hour;
        $this->engHour = date('G', $timestamp);
        $this->calculate_date();//calculate the bangla date
        $this->calculate_year();//now call calculate_year for setting the bangla year
        $this->convert();//convert english numbers to Bangla
    }
    function set_time($timestamp, $hour = 6){$this->BanglaDate($timestamp, $hour);}
    /*Calculate the Bangla date and month*/
    function calculate_date(){
        //when English month is January
        if($this->engMonth == 1){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "পৌষ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "পৌষ";}
            }
            else if($this->engDate < 14 && $this->engDate > 1) // Date 2-13
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "পৌষ";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "পৌষ";}
            }
            else if($this->engDate == 14) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "মাঘ";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "পৌষ";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "মাঘ";}
                else{
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "মাঘ";}
            }
        }
        //when English month is February
        else if($this->engMonth == 2){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 18;
                    $this->bangMonth = "মাঘ";}
                else{
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "মাঘ";}
            }else if($this->engDate < 14 && $this->engDate > 1) // Date 2-12
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "মাঘ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "মাঘ";}
            }else if($this->engDate == 14) //Date 13
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "ফাল্গুন";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "মাঘ";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "ফাল্গুন";}
                else{
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "ফাল্গুন";}
            }
        }
        //when English month is March
        else if($this->engMonth == 3){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    if($this->is_leapyear())$this->bangDate = $this->engDate + 17;
                    else $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "ফাল্গুন";}
                else{
                    if($this->is_leapyear()) $this->bangDate = $this->engDate + 16;
                    else $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "ফাল্গুন";}
            }
            else if($this->engDate < 15 && $this->engDate > 1) // Date 2-13
            {
                if($this->engHour >=$this->morning){
                    if($this->is_leapyear()) $this->bangDate = $this->engDate + 17;
                    else $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "ফাল্গুন";}
                else{
                    if($this->is_leapyear()) $this->bangDate = $this->engDate + 16;
                    else $this->bangDate = $this->engDate + 14;
                    $this->bangMonth = "ফাল্গুন";}
            }			else if($this->engDate == 15) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "চৈত্র";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "ফাল্গুন";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "চৈত্র";}
                else{
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "চৈত্র";}
            }
        }
        //when English month is April
        else if($this->engMonth == 4){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "চৈত্র";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "চৈত্র";}
            }
            else if($this->engDate < 14 && $this->engDate > 1) // Date 2-13
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "চৈত্র";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "চৈত্র";}
            }
            else if($this->engDate == 14) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "বৈশাখ";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "চৈত্র";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "বৈশাখ";}
                else{
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "বৈশাখ";}
            }
        }
        //when English month is May
        else if($this->engMonth == 5){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "বৈশাখ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "বৈশাখ";}
            }
            else if($this->engDate < 15 && $this->engDate > 1) // Date 2-14
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "বৈশাখ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "বৈশাখ";}
            }
            else if($this->engDate == 15) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
                else{
                    $this->bangDate = 31;
                    $this->bangMonth = "চৈত্র";}
            }
            else //Date 16-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
                else{
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
            }
        }
        //when English month is June
        else if($this->engMonth == 6){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
            }
            else if($this->engDate < 15 && $this->engDate > 1) // Date 2-14
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 17;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
                else{
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
            }			else if($this->engDate == 15) //Date 15
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "আষাঢ়";}
                else{
                    $this->bangDate = 31;
                    $this->bangMonth = "জ্যৈষ্ঠ";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "আষাঢ়";}
                else{
                    $this->bangDate = $this->engDate - 13;
                    $this->bangMonth = "আষাঢ়";}
            }
        }
        //when English month is July
        else if($this->engMonth == 7){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "আষাঢ়";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "আষাঢ়";}
            }
            else if($this->engDate < 16 && $this->engDate > 1) // Date 2-15
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "আষাঢ়";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "আষাঢ়";}
            }
            else if($this->engDate == 16) //Date 16
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "শ্রাবণ";}
                else{
                    $this->bangDate = 31;
                    $this->bangMonth = "আষাঢ়";}
            }
            else //Date 17-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "শ্রাবণ";}
                else{
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "শ্রাবণ";}
            }
        }
        //when English month is August
        else if($this->engMonth == 8){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "শ্রাবণ";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "শ্রাবণ";}
            }
            else if($this->engDate < 16 && $this->engDate > 1) // Date 2-15
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "শ্রাবণ";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "শ্রাবণ";}
            }
            else if($this->engDate == 16) //Date 16
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "ভাদ্র";}
                else{
                    $this->bangDate = 31;
                    $this->bangMonth = "শ্রাবণ";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "ভাদ্র";}
                else{
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "ভাদ্র";}
            }
        }
        //when English month is September
        else if($this->engMonth == 9){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "ভাদ্র";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "ভাদ্র";}
            }
            else if($this->engDate < 16 && $this->engDate > 1) // Date 2-15
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "ভাদ্র";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "ভাদ্র";}
            }
            else if($this->engDate == 16) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "আশ্বিন";}
                else{
                    $this->bangDate = 31;
                    $this->bangMonth = "ভাদ্র";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "আশ্বিন";}
                else{
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "আশ্বিন";}
            }
        }
        //when English month is October
        else if($this->engMonth == 10){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "আশ্বিন";}
                else{
                    $this->bangDate = $this->engDate + 14;
                    $this->bangMonth = "আশ্বিন";}
            }
            else if($this->engDate < 16 && $this->engDate > 1) // Date 2-15
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "আশ্বিন";}
                else{
                    $this->bangDate = $this->engDate + 14;
                    $this->bangMonth = "আশ্বিন";}
            }
            else if($this->engDate == 16) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "কার্তিক";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "আশ্বিন";}
            }
            else //Date 17-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "কার্তিক";}
                else{
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "কার্তিক";}
            }
        }
        //when English month is November
        else if($this->engMonth == 11){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "কার্তিক";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "কার্তিক";}
            }
            else if($this->engDate < 15 && $this->engDate > 1) // Date 2-14
            {
                if($this->engHour >=$this->morning){
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "কার্তিক";}
                else{
                    $this->bangDate = $this->engDate + 14;
                    $this->bangMonth = "কার্তিক";}
            }
            else if($this->engDate == 15) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "অগ্রহায়ণ";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "কার্তিক";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "অগ্রহায়ণ";}
                else{
                    $this->bangDate = $this->engDate - 16;
                    $this->bangMonth = "অগ্রহায়ণ";}
            }
        }
        //when English month is December
        else if($this->engMonth == 12){
            if($this->engDate == 1) //Date 1
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate + 16;
                    $this->bangMonth = "অগ্রহায়ণ";}
                else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "অগ্রহায়ণ";}
            }
            else if($this->engDate < 15 && $this->engDate > 1) // Date 2-14
            {
                //robin vai
                // if($this->engHour >=$this->morning){
                //     $this->bangDate = $this->engDate + 16;
                //     $this->bangMonth = "অগ্রহায়ণ";}
                // else{
                    $this->bangDate = $this->engDate + 15;
                    $this->bangMonth = "অগ্রহায়ণ";
                // }
            }
            else if($this->engDate == 15) //Date 14
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 14;
                    $this->bangMonth = "পৌষ";}
                else{
                    $this->bangDate = 30;
                    $this->bangMonth = "অগ্রহায়ণ";}
            }
            else //Date 15-31
            {
                if($this->engHour >= $this->morning){
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "পৌষ";}
                else{
                    $this->bangDate = $this->engDate - 15;
                    $this->bangMonth = "পৌষ";}
            }
        }
    }
    /*Checks, if the date is leapyear or not. @return boolen. True if it's leap year or returns false*/
    function is_leapyear(){
        if($this->engYear%400 ==0 || ($this->engYear%100 != 0 && $this->engYear%4 == 0))
            return true;
        else
            return false;}
    /*Calculate the Bangla Year*/
    function calculate_year(){
        if($this->engMonth >= 4){
            if($this->engMonth == 4 && $this->engDate < 14){ //1-13 on april when hour is greater than 6
                $this->bangYear = $this->engYear - 594;}
            else if($this->engMonth == 4 && $this->engDate == 14 && $this->engHour <=5){
                $this->bangYear = $this->engYear - 594;}
            else if($this->engMonth == 4 && $this->engDate == 14 && $this->engHour >=6){
                $this->bangYear = $this->engYear - 593;}
            /*else if($this->engMonth == 4 && ($this->engDate == 14 && $this->engDate) && $this->engHour <=5) //1-13 on april when hour is greater than 6{$this->bangYear = $this->engYear - 593;}*/
            else
                $this->bangYear = $this->engYear - 593;}
        else $this->bangYear = $this->engYear - 594;}
    /*Convert the English character to Bangla. @param int any integer number. @return string as converted number to bangla*/
    function bangla_number($int){
        $engNumber = array(1,2,3,4,5,6,7,8,9,0);
        $bangNumber = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
        $converted = str_replace($engNumber, $bangNumber, $int);
        return $converted;}
    /*Calls the converter to convert numbers to equivalent Bangla number*/
    function convert(){
        $this->bangDate = $this->bangla_number($this->bangDate);
        $this->bangYear = $this->bangla_number($this->bangYear);}
    /*Returns the calculated Bangla Date. @return array of converted Bangla Date*/
    function get_date(){
        return array($this->bangDate, $this->bangMonth, $this->bangYear);}
}

// This class Convert Hijri date to Gregorian Date & vise versa, made by Layth A. Ibraheeim - 24-2-2011
// to test if the results are ok, please visit (http://www.oriold.uzh.ch/static/hegira.html)..

class Hijri_GregorianConvert
{
	var $Day;
	var $Month;
	var $Year;


	function intPart($floatNum)
	{
		if ($floatNum< -0.0000001)
		{
			return ceil($floatNum-0.0000001);
		}
		return floor($floatNum+0.0000001);
	}

	function ConstractDayMonthYear($date,$format) // extract day, month, year out of the date based on the format.
	{
		$this->Day="";
		$this->Month="";
		$this->Year="";

		$format=strtoupper($format);
		$format_Ar= str_split($format);
		$srcDate_Ar=str_split($date);

		for ($i=0;$i<count($format_Ar);$i++)
		{

			switch($format_Ar[$i])
			{
				case "D":
					$this->Day.=$srcDate_Ar[$i];
					break;
				case "M":
					$this->Month.=$srcDate_Ar[$i];
					break;
				case "Y":
					$this->Year.=$srcDate_Ar[$i];
					break;
			}
		}

	}


	function HijriToGregorian($date,$format) // $date like 10121400, $format like DDMMYYYY, take date & check if its hijri then convert to gregorian date in format (DD-MM-YYYY), if it gregorian the return empty;
	{

		$this->ConstractDayMonthYear($date,$format);
		$d=intval($this->Day);
		$m=intval($this->Month);
		$y=intval($this->Year);

		if ($y<1700)
		{

			$jd=$this->intPart((11*$y+3)/30)+354*$y+30*$m-$this->intPart(($m-1)/2)+$d+1948440-385;

			if ($jd> 2299160 )
			{
				$l=$jd+68569;
				$n=$this->intPart((4*$l)/146097);
				$l=$l-$this->intPart((146097*$n+3)/4);
				$i=$this->intPart((4000*($l+1))/1461001);
				$l=$l-$this->intPart((1461*$i)/4)+31;
				$j=$this->intPart((80*$l)/2447);
				$d=$l-$this->intPart((2447*$j)/80);
				$l=$this->intPart($j/11);
				$m=$j+2-12*$l;
				$y=100*($n-49)+$i+$l;
			}
			else
			{
				$j=$jd+1402;
				$k=$this->intPart(($j-1)/1461);
				$l=$j-1461*$k;
				$n=$this->intPart(($l-1)/365)-$this->intPart($l/1461);
				$i=$l-365*$n+30;
				$j=$this->intPart((80*$i)/2447);
				$d=$i-$this->intPart((2447*$j)/80);
				$i=$this->intPart($j/11);
				$m=$j+2-12*$i;
				$y=4*$k+$n+$i-4716;
			}

			if ($d<10)
				$d="0".$d;

			if ($m<10)
				$m="0".$m;

			return $d."-".$m."-".$y;
		}
		else
			return "";
	}



	function GregorianToHijri($date,$format) // $date like 10122011, $format like DDMMYYYY, take date & check if its gregorian then convert to hijri date in format (DD-MM-YYYY), if it hijri the return empty;
	{
		$this->ConstractDayMonthYear($date,$format);
		$d=intval($this->Day);
		$m=intval($this->Month);
		$y=intval($this->Year);
        
		if ($y>1700)
		{
			if (($y>1582)||(($y==1582)&&($m>10))||(($y==1582)&&($m==10)&&($d>14)))
			{
				$jd=$this->intPart((1461*($y+4800+$this->intPart(($m-14)/12)))/4)+$this->intPart((367*($m-2-12*($this->intPart(($m-14)/12))))/12)-$this->intPart((3*($this->intPart(($y+4900+$this->intPart(($m-14)/12))/100)))/4)+$d-32075;
			}
			else
			{
				$jd = 367*$y-$this->intPart((7*($y+5001+$this->intPart(($m-9)/7)))/4)+$this->intPart((275*$m)/9)+$d+1729777;
			}

			$l=$jd-1948440+10632;
			$n=$this->intPart(($l-1)/10631);
			$l=$l-10631*$n+354;
			$j=($this->intPart((10985-$l)/5316))*($this->intPart((50*$l)/17719))+($this->intPart($l/5670))*($this->intPart((43*$l)/15238));
			$l=$l-($this->intPart((30-$j)/15))*($this->intPart((17719*$j)/50))-($this->intPart($j/16))*($this->intPart((15238*$j)/43))+29;

			$m=$this->intPart((24*$l)/709);
            // date + or - rabin
            $d=$l-$this->intPart((709*$m)/24)-1;
			// $d=$l-$this->intPart((709*$m)/24);
			$y=30*$n+$j-30;

			if ($d<10)
				$d="0".$d;

            if($d==00){return '';}
            
			if ($m<10)
				$m="0".$m;
			if($m==1){$month = 'মহররম';}
			if($m==2){$month = 'সফর';}
			if($m==3){$month = 'রবিউল আউয়াল';}
			if($m==4){$month = 'রবিউস সানি';}
			if($m==5){$month = 'জমাদিউল আউয়াল';}
			if($m==6){$month = 'জমাদিউস সানি';}
			if($m==7){$month = 'রজব';}
			if($m==8){$month = 'শাবান';}
			if($m==9){$month = 'রমজান';}
			if($m==10){$month = 'শাওয়াল';}
			if($m==11){$month = 'জিলকদ';}
			if($m==12){$month = 'জিলহজ';}
			$m=$this->number_to_month($m);
			$d=$this->bangla_number($d);
			$y=$this->bangla_number($y);
			return ",&nbsp;".$d." ".$month." ".$y;
		}
		else
			return "";
	}
	function number_to_month($int)
	{
		$engNumber = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$bangNumber = array('মহররম','সফর','রবিউল আউয়াল','রবিউস সানি','জমাদিউল আউয়াল','জমাদিউস সানি','রজব','শাবান','রমজান','শাওয়াল','জিলকদ','জিলহজ');
		$converted = str_replace($engNumber, $bangNumber, $int);
		return $converted;
	}
	function bangla_number($int)
	{
		$engNumber = array(1,2,3,4,5,6,7,8,9,0);
		$bangNumber = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
		$converted = str_replace($engNumber, $bangNumber, $int);
		return $converted;
	}


}

