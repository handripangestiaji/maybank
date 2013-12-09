<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slugging'))
{
    function slugging($text = '')
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
      
        // trim
        $text = trim($text, '-');
      
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      
        // lowercase
        $text = strtolower($text);
      
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
      
        if (empty($text))
        {
          return 'n-a';
        }
      
        return $text;
    }
}


function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}

function convertDate($dateSrc, $timeZone){
    $dateTime = new DateTime($dateSrc); 
    $dateTime->setTimeZone(new DateTimeZone($timeZone)); 
    return $dateTime;
}


function get_timezone_list(){
    $timezones = array(
        'Pacific/Midway'    => "(GMT-11:00) Midway Island",
        'US/Samoa'          => "(GMT-11:00) Samoa",
        'US/Hawaii'         => "(GMT-10:00) Hawaii",
        'US/Alaska'         => "(GMT-09:00) Alaska",
        'US/Pacific'        => "(GMT-08:00) Pacific Time (US &amp; Canada)",
        'America/Tijuana'   => "(GMT-08:00) Tijuana",
        'US/Arizona'        => "(GMT-07:00) Arizona",
        'US/Mountain'       => "(GMT-07:00) Mountain Time (US &amp; Canada)",
        'America/Chihuahua' => "(GMT-07:00) Chihuahua",
        'America/Mazatlan'  => "(GMT-07:00) Mazatlan",
        'America/Mexico_City' => "(GMT-06:00) Mexico City",
        'America/Monterrey' => "(GMT-06:00) Monterrey",
        'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
        'US/Central'        => "(GMT-06:00) Central Time (US &amp; Canada)",
        'US/Eastern'        => "(GMT-05:00) Eastern Time (US &amp; Canada)",
        'US/East-Indiana'   => "(GMT-05:00) Indiana (East)",
        'America/Bogota'    => "(GMT-05:00) Bogota",
        'America/Lima'      => "(GMT-05:00) Lima",
        'America/Caracas'   => "(GMT-04:30) Caracas",
        'Canada/Atlantic'   => "(GMT-04:00) Atlantic Time (Canada)",
        'America/La_Paz'    => "(GMT-04:00) La Paz",
        'America/Santiago'  => "(GMT-04:00) Santiago",
        'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
        'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
        'Greenland'         => "(GMT-03:00) Greenland",
        'Atlantic/Stanley'  => "(GMT-02:00) Stanley",
        'Atlantic/Azores'   => "(GMT-01:00) Azores",
        'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
        'Africa/Casablanca' => "(GMT) Casablanca",
        'Europe/Dublin'     => "(GMT) Dublin",
        'Europe/Lisbon'     => "(GMT) Lisbon",
        'Europe/London'     => "(GMT) London",
        'Africa/Monrovia'   => "(GMT) Monrovia",
        'Europe/Amsterdam'  => "(GMT+01:00) Amsterdam",
        'Europe/Belgrade'   => "(GMT+01:00) Belgrade",
        'Europe/Berlin'     => "(GMT+01:00) Berlin",
        'Europe/Bratislava' => "(GMT+01:00) Bratislava",
        'Europe/Brussels'   => "(GMT+01:00) Brussels",
        'Europe/Budapest'   => "(GMT+01:00) Budapest",
        'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
        'Europe/Ljubljana'  => "(GMT+01:00) Ljubljana",
        'Europe/Madrid'     => "(GMT+01:00) Madrid",
        'Europe/Paris'      => "(GMT+01:00) Paris",
        'Europe/Prague'     => "(GMT+01:00) Prague",
        'Europe/Rome'       => "(GMT+01:00) Rome",
        'Europe/Sarajevo'   => "(GMT+01:00) Sarajevo",
        'Europe/Skopje'     => "(GMT+01:00) Skopje",
        'Europe/Stockholm'  => "(GMT+01:00) Stockholm",
        'Europe/Vienna'     => "(GMT+01:00) Vienna",
        'Europe/Warsaw'     => "(GMT+01:00) Warsaw",
        'Europe/Zagreb'     => "(GMT+01:00) Zagreb",
        'Europe/Athens'     => "(GMT+02:00) Athens",
        'Europe/Bucharest'  => "(GMT+02:00) Bucharest",
        'Africa/Cairo'      => "(GMT+02:00) Cairo",
        'Africa/Harare'     => "(GMT+02:00) Harare",
        'Europe/Helsinki'   => "(GMT+02:00) Helsinki",
        'Europe/Istanbul'   => "(GMT+02:00) Istanbul",
        'Asia/Jerusalem'    => "(GMT+02:00) Jerusalem",
        'Europe/Kiev'       => "(GMT+02:00) Kyiv",
        'Europe/Minsk'      => "(GMT+02:00) Minsk",
        'Europe/Riga'       => "(GMT+02:00) Riga",
        'Europe/Sofia'      => "(GMT+02:00) Sofia",
        'Europe/Tallinn'    => "(GMT+02:00) Tallinn",
        'Europe/Vilnius'    => "(GMT+02:00) Vilnius",
        'Asia/Baghdad'      => "(GMT+03:00) Baghdad",
        'Asia/Kuwait'       => "(GMT+03:00) Kuwait",
        'Europe/Moscow'     => "(GMT+03:00) Moscow",
        'Africa/Nairobi'    => "(GMT+03:00) Nairobi",
        'Asia/Riyadh'       => "(GMT+03:00) Riyadh",
        'Europe/Volgograd'  => "(GMT+03:00) Volgograd",
        'Asia/Tehran'       => "(GMT+03:30) Tehran",
        'Asia/Baku'         => "(GMT+04:00) Baku",
        'Asia/Muscat'       => "(GMT+04:00) Muscat",
        'Asia/Tbilisi'      => "(GMT+04:00) Tbilisi",
        'Asia/Yerevan'      => "(GMT+04:00) Yerevan",
        'Asia/Kabul'        => "(GMT+04:30) Kabul",
        'Asia/Yekaterinburg' => "(GMT+05:00) Ekaterinburg",
        'Asia/Karachi'      => "(GMT+05:00) Karachi",
        'Asia/Tashkent'     => "(GMT+05:00) Tashkent",
        'Asia/Kolkata'      => "(GMT+05:30) Kolkata",
        'Asia/Kathmandu'    => "(GMT+05:45) Kathmandu",
        'Asia/Almaty'       => "(GMT+06:00) Almaty",
        'Asia/Dhaka'        => "(GMT+06:00) Dhaka",
        'Asia/Novosibirsk'  => "(GMT+06:00) Novosibirsk",
        'Asia/Bangkok'      => "(GMT+07:00) Bangkok",
        'Asia/Jakarta'      => "(GMT+07:00) Jakarta",
        'Asia/Krasnoyarsk'  => "(GMT+07:00) Krasnoyarsk",
        'Asia/Chongqing'    => "(GMT+08:00) Chongqing",
        'Asia/Hong_Kong'    => "(GMT+08:00) Hong Kong",
        'Asia/Irkutsk'      => "(GMT+08:00) Irkutsk",
        'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
        'Australia/Perth'   => "(GMT+08:00) Perth",
        'Asia/Singapore'    => "(GMT+08:00) Singapore",
        'Asia/Taipei'       => "(GMT+08:00) Taipei",
        'Asia/Ulaanbaatar'  => "(GMT+08:00) Ulaan Bataar",
        'Asia/Urumqi'       => "(GMT+08:00) Urumqi",
        'Asia/Seoul'        => "(GMT+09:00) Seoul",
        'Asia/Tokyo'        => "(GMT+09:00) Tokyo",
        'Asia/Yakutsk'      => "(GMT+09:00) Yakutsk",
        'Australia/Adelaide' => "(GMT+09:30) Adelaide",
        'Australia/Darwin'  => "(GMT+09:30) Darwin",
        'Australia/Brisbane' => "(GMT+10:00) Brisbane",
        'Australia/Canberra' => "(GMT+10:00) Canberra",
        'Pacific/Guam'      => "(GMT+10:00) Guam",
        'Australia/Hobart'  => "(GMT+10:00) Hobart",
        'Australia/Melbourne' => "(GMT+10:00) Melbourne",
        'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
        'Australia/Sydney'  => "(GMT+10:00) Sydney",
        'Asia/Vladivostok'  => "(GMT+10:00) Vladivostok",
        'Asia/Magadan'      => "(GMT+11:00) Magadan",
        'Pacific/Auckland'  => "(GMT+12:00) Auckland",
        'Pacific/Fiji'      => "(GMT+12:00) Fiji",
        'Asia/Kamchatka'    => "(GMT+12:00) Kamchatka",
    );
    return $timezones;
}


function curl_get_file_contents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
     curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt( $c, CURLOPT_ENCODING, "UTF-8" );
    curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $c, CURLOPT_AUTOREFERER, true );
    curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 60 );
    curl_setopt( $c, CURLOPT_TIMEOUT, 60 );
    curl_setopt( $c, CURLOPT_MAXREDIRS, 10 );
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
  }
  
function facebook_request($path, $attachment = null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/'.$path);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POST, true);
    if($attachment != null)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function open_api_template($url){
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_USERAGENT, "Giziku Mobile Web" );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        'app_id: 2147483647',
        'app_secret: abcdef3a1278af1238ab123ba123'
        ));
    $content = curl_exec( $ch );

    return $content;
}


function fb_dummy_accesstoken($access_token = 'CAAFm2lqzuUgBAPRYLUQcU0smQCWJhNM9ZCVFzZASrYdPvdPxhZBbwtwbYEX9F3ABgktReqHhSnY81GNG8b0ZC4Q43QA9ZBpvNewblrZCuIW53c3h7DvhVszMR4ZBQ12T64p9ZA59PyqD1uizVYn3pa5Q1avZA8V5nImMRnyrh1c8bz54Xrq76MiPC'){
    $account = json_decode(open_api_template('https://graph.facebook.com/me/accounts?access_token='.$access_token));
    return $account->data[0]->access_token;
}

function facebook_page_manage($access_token = 'CAAFm2lqzuUgBAPRYLUQcU0smQCWJhNM9ZCVFzZASrYdPvdPxhZBbwtwbYEX9F3ABgktReqHhSnY81GNG8b0ZC4Q43QA9ZBpvNewblrZCuIW53c3h7DvhVszMR4ZBQ12T64p9ZA59PyqD1uizVYn3pa5Q1avZA8V5nImMRnyrh1c8bz54Xrq76MiPC'){
    $account = json_decode(open_api_template('https://graph.facebook.com/me/accounts?access_token='.$access_token));
    return $account->data;
}

function CheckValidation($dataToValidated, $validationObj){
    $error = array();
    for($i=0;$i<count($dataToValidated);$i++)
    {
        $validation = $validationObj->set($dataToValidated[$i]['type'],$dataToValidated[$i]['name'],$dataToValidated[$i]['value'],
                                          $dataToValidated[$i]['fine_name']);
        
        if($validation['result'] == FALSE){
            $error[] = $validation;
        }
    }
    
    return count($error) > 0 ? $error : true ;
}


function linkify($string, $twitter=false, $url=false) {

    // reg exp pattern
    $pattern = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $new_string = $string;
    // convert string URLs to active links
    if($url)
        $new_string = preg_replace($pattern, "<a href=\"\\0\">\\0</a>", $string);

    if ($twitter) {
        $pattern = '/@([a-zA-Z0-9_]+)/';
        $replace = '<a href="http://twitter.com/\1" target="_blank">@\1</a>';
        $new_string = preg_replace($pattern, $replace, $new_string);
    }

    return $new_string;
}


function find_anchors($html)
{
    $links = array();
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $navbars = $doc->getElementsByTagName('div');
    foreach ($navbars as $navbar) {
        $id = $navbar->getAttribute('id');
        if ($id === "anchors") {
            $anchors = $navbar->getElementsByTagName('a');
            foreach ($anchors as $a) {
                $links[] = $doc->saveHTML($a);
            }
        }
    }
    return $links;
}