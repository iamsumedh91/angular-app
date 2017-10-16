<?php
 
    defined('BASEPATH') OR exit('No direct script access allowed');
 
    /**
    * Description of ContactModel
    *
    * @author http://roytuts.com
    */
    class LoginModel extends CI_Model 
    {
        function __construct() 
        {
            parent::__construct();
        }
    
    private $user = 'user';
    

    function signup_user($data)
    {    
        /*
        * Check $data Validation
        */
        $errors = $this->check_validation($data);
        $data['password'] = md5($data['password']); //md5 password encryption used here

        $result = array();

        if(!empty($errors))
        {
            $result['status'] = "Validation Errors";
            $result['message'] = "Signup Falied";
            $result['errors'] = $errors;
        }
        else
        {
            $this->db->set('created', 'NOW()', FALSE); // set created date as now
            $this->db->set('modified', 'NOW()', FALSE); // set modified date as now
            // The FALSE in the set method prevents the NOW() being escaped

            if($this->db->insert('user', $data))
            {
                $result['status'] = "ok";
                $result['message'] = "Signup Successful";
            }
            else
            {
                $result['status'] = "Database query Failed";
                $result['message'] = "Signup Failed";
            }
        }
        return $result; 
            
    }

    function check_validation($check_data)
    {
        $errors = array();

        /*
        * Check if any field is blank
        */
        if(empty($check_data['name']))
        {    
            $errors['name'] = "Name should not be empty";
        }
        if(empty($check_data['username']))
        {
            $errors['username'] = "Username should not be empty";
        }

        /*
        * Check if username already exists
        */
        else
        {
            $username = $check_data['username'];
            $result = $this->username_exists($username);
            if($result)
            {
                $errors['username'] = "Username already exists";
            }
        }
        if(empty($check_data['password']))
        {
            $errors['password'] = "Password should not be empty";
        }
        if(empty($check_data['gender']))
        {
            $errors['gender'] = "Gender should not be empty";
        }
        if(empty($check_data['email']))
        {
            $errors['email'] = "Email should not be empty";
        }

        /*
        * Check if email already exists
        */
        else
        {
            $email = $check_data['email'];
            $result = $this->email_exists($email);
            if($result)
            {
                $errors['email'] = "Email already exists";
            }
        }

        return $errors;
    }

    /*
    * Cheking if Username $username Exists
    */
    function username_exists($username)
    {
        $this->db->select('*'); 
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
    * Cheking if Email $email Exists
    */
    function email_exists($email)
    {
        $this->db->select('*'); 
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function login_user($data)
    {
        /*
        * Check Login Credentials for $data
        */
        $user_exists = $this->check_details($data);
        $result = array();

        if(!empty($user_exists))
        {
            $result['status'] = "ok";
            $result['message'] = "Login Success";
            $result['username'] = $user_exists[0]['username'];
            $result['password'] = $user_exists[0]['password'];
        }
        else
        {
            $result['status'] = "Username Or Password Incorrect";
            $result['message'] = "Login Failed";
        }
        return $result;
    }
    
    function check_details($check_data)
    {   
        /*
        * Check $username and $password exist
        */
        $username = $check_data['username'];
        $password = $check_data['password'];
        $where = '(username = $username or email = $username)';
        $this->db->select('*'); 
        $this->db->from('user');
        $this->db->where("(username = '$username' OR email = '$username')");
        $this->db->where('password', md5($check_data['password'])); //md5 password encryption used here
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result_array();
    }

    function fetch_menus()
    {
        /*
        * Get a menus array $m
        */
        $query = $this->db->get('menu');
        $menus = $query->result_array();

        return $this->buildTree($menus);

        /*
        $m = array();

        
        foreach ($menus as $key => $field) 
        {
            if($field['parent_id'] > 0)
            {
                $m[$field['parent_id']]['submenu'][$field['id']] = $field;
            }
            else
            {
                $m[$field['id']] = $field;
            }
        }

        return $m;
        */
    }

    function buildTree( $ar, $pid = 0 ) 
    {
    
        $op = array();
        foreach( $ar as $item ) 
        {
            if( $item['parent_id'] == $pid ) 
            {   
                $op[$item['id']] = $item;
            

                // using recursion
                $children =  $this->buildTree( $ar, $item['id'] );
                if( $children ) 
                {
                    $op[$item['id']]['submenu'] = $children;
                }
            }
        }

        return $op;
    }

    function show_users()
    {
        $query = $this->db->get('user');
        $users = $query->result_array(); 
        return $users;
    }

    function show_menus()
    {
        $query = $this->db->get('menu');
        $menus = $query->result_array(); 
        return $menus;
    }
}
?>