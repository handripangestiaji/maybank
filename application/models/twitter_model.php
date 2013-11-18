<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class twitter_model extends CI_Model
{
    private $connection ;
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
        $this->load->library('Twitteroauth');
        
    }
    
    public function InitConnection($access_token, $access_secret){
        $this->connection = $this->twitteroauth->create("EXWkuGJlJ8zMUGccF04uMA","eUw0K1YuzMof6RqI0oYw22mV6JYH0UbePMscMSiDZk",$access_token,$access_secret);
    }
    
    public function Mentions(){
        
    }
    
    public function DirectMessages(){
        
    }
    
    public function OwnPost(){
        
    }
    
    public function HomeFeed(){
        
    }
}