
<?php
    define (LIVEDOMAIN, "http://dcms.cloudmotion.co/");
    $expectedURL = trim($_SERVER['REQUEST_URI']);
    $expectedURL = substr(str_replace($_SERVER['SCRIPT_NAME'], '', $expectedURL), 1);
    
    // security: strip all but alphanumerics & dashes
    //$shortURL = preg_replace("/[^a-z0-9-]+/i", "", $shortURL);
    
    $isShortURL = false;
    $result = getLongURL($expectedURL);
    if ($result->long_url != null) 
        redirectTo($result->long_url);
    else {
            show404();  // no shortURL found, display standard 404 page
    }
    
    function getLongURL($s)
    {
        $data =  curl_get_file_contents(LIVEDOMAIN.'cronjob/lookupshorturl?short_url='.$s);
        return $data;
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
        curl_setopt($c, CURLOPT_FRESH_CONNECT, TRUE);
        $contents = curl_exec($c);
        $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
        curl_close($c);
        if ($contents) return $contents;
        else return FALSE;
    }
      
    
    function redirectTo($longURL)
    {
        echo $longURL;
        // change this to your domain
        header("Referer: http://www.maybk.co");
        // use a 301 redirect to your destination
        header("Location: $longURL", TRUE, 301);
        exit;
    }
    
    function show404()
    {
        // display/include your standard 404 page here
        echo "404 Page Not Found.";
        exit;
    }
?>