<?php
Class User extends CI_Model
{
 function validate()
 {
   $this -> db -> where('username', $this->input->post('username'));
   $this -> db -> where('password', MD5($this->input->post('password')));
   
   $query = $this -> db -> get('users');
   
   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }
}
?>