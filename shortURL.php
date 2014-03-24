
<?php
    $expectedURL = trim($_SERVER['REQUEST_URI']);
    $expectedURL = substr(str_replace($_SERVER['SCRIPT_NAME'], '', $expectedURL), 1);
    
    // security: strip all but alphanumerics & dashes
    //$shortURL = preg_replace("/[^a-z0-9-]+/i", "", $shortURL);
    
    $isShortURL = false;
    $result = getLongURL($expectedURL);
    if ($result) { $isShortURL = true; }
    $longURL = $result['long_url'];
 
    if ($isShortURL)
    {
            redirectTo($longURL, $shortURL);
    } else {
            show404();  // no shortURL found, display standard 404 page
    }
    
    function getLongURL($s)
    {
        // define these variables for your system
        $host = "127.0.0.1"; $user = "root"; $pass = ""; $db = "maybank";
        $mysqli = new mysqli($host, $user, $pass, $db);
        // you may just want to fall thru to 404 here if connection error
        if (mysqli_connect_errno()) { die("Unable to connect !"); }
        $query = "SELECT * FROM short_urls WHERE short_code = '$s';";
        
        if ($result = $mysqli->query($query)) {
            
            if ($result->num_rows > 0) {
                $query2 = "Update short_urls set increment = increment + 1 where short_url = '$s'";
                $mysqli->query($query2);
                while($row = $result->fetch_assoc()) {
                        return($row);
                }
            } else {
                return false;
            }
        } else {
                return false;
        }
        
        $mysqli->close();
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