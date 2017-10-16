<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Including the required libraries here
*/ 
require(APPPATH . '/libraries/REST_Controller.php');
 
/**
 * Description of RestController
 */
class Rest extends REST_Controller {

    /*
    * Loading the model in Constructor
    */
    function __construct() {
        parent::__construct();
        $this->load->model('LoginModel', 'lm');
    }
   
    /*
    * Function to Signup user data
    */
    function signup_post()
    {
        $data = $this->post();

        $result = $this->lm->signup_user($data);

        $this->response($result);
    }
    
    /*
    * Function to check user Login
    */
    function login_post()
    {
        $data = $this->post();
        $result = $this->lm->login_user($data);
        $this->response($result);
    }
    
    /*
    * Function to get the Menus
    */
    function get_menu_get()
    {
        $result = $this->lm->fetch_menus();
        $this->response($result);
    }
}

?>