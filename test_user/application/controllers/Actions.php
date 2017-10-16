<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actions extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function info()
        {
            $info = array('name' => 'Second', 'username' => 'seconduser', 'password' => 'secondpass', 
                        'gender' => 'Female', 'address' => '"http://seconduser.com"', 'email' => 'seconduser@gmail.com',
                        'mobile' => '1234567890', 'pincode' => '305002', 'occupation' => 'Self Employed',
                        'dateofbirth' => '1990-01-01');
            $info_json = json_encode($info);
        
            echo $info_json;
        }
}
?>
