<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
require(APPPATH . '/libraries/REST_Controller.php');
 
/**
 * Description of RestPostController
 *
 * @author http://roytuts.com
 */
class Rest extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('LoginModel', 'lm');
    }
    
    function signup_post() 
    {
        $data = $this->post();

        $result = $this->lm->signup_user($data);

        $this->response($result);
    }
    
    function login_post()
    {
        $data = $this->post();
        $result = $this->lm->login_user($data);
        $this->response($result);
    }
    
    function get_menu_get()
    {
        $result = $this->lm->fetch_menus();
        $this->response($result);
    }

    function get_users_post()
    {
        $result =  $this->lm->show_users();
        $this->response($result);
    }

    function get_menus_post()
    {
        $result =  $this->lm->show_menus();
        $this->response($result);
        
    }
}
?>