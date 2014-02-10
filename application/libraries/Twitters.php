<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitters {

     private $connection;
	   
    function __construct()
	{
		parent::__construct();
		// Loading TwitterOauth library. 
    }
    
    
	public function index()
	{
       //$data['directmessage']=$this->connection->get('direct_messages');  
    echo "<br><br><br><br><br><br><br><br>";
	}
    
    private function replaytweet(){
       $replayrext=$_POST['replayContent'];
        
    }
    

}