<?php
/*
    This library was made to retrieve ratings and other complicated library on current youtube library...
    
    created by: Eko Purnomo
    date created: December 31, 2013
*/

class youtube_libs{
    protected $devKey = array(), $access_token, $CI;
    private $youtubeBaseUrl = "http://gdata.youtube.com/feeds/api/videos/";
    public function __construct(){
     $this->CI = & get_instance();  
    }
    public function setDeveloperKey(){
        $this->devKey = $developer_key;
    }
    public function SetAccessToken($access_token){
        $this->access_token = $access_token;
    }
    
    public function ReadVideoRatings($videoId){
        return $this->AccessFeeds("videos/$videoId");
    }
    
    
    protected function AccessFeeds($part = "videos", $get_parameter = array()){
        
        $parameter = array_merge($get_parameter, array("v" => 2, "alt" => "jsonc"));
        $url = "http://gdata.youtube.com/feeds/api/$part?".http_build_query($parameter);
        
        $curlhandle = curl_init();
        curl_setopt($curlhandle, CURLOPT_URL, $url);
        curl_setopt($curlhandle, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curlhandle);
        curl_close($curlhandle);
        
        return json_decode($response);
    }
}

