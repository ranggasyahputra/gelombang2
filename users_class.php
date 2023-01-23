<?php

class Users
{
  private $user_id;
  private $password;
  private $search_input;
  private $nama_lengkap;
  private $role;

  function set_login_data($user_id, $password)
  {
    $this->user_id = $user_id;
    $this->password = $password;
  }
  
  function get_user_id()
  {
    return $this->user_id;
  }
  
  function get_user_password()
  {
    return $this->password;
  }

  function set_user_data ($search_input) {
    $this->search_input = $search_input;
  }
  
  function get_user_data(){
    return $this->search_input;
  }
  
  function set_user_edit_data($user_id,$nama_lengkap, $role, $password){
    $this->user_id = $user_id;
    $this->nama_lengkap = $nama_lengkap;
    $this->role = $role;
    $this->password = $password;
  }

  function get_user_nama(){
    return $this->nama_lengkap;
  }
  function get_user_role(){
    return $this->role;
  }

}

?>