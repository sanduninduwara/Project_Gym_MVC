<?php
require_once 'models/User.php';
class Admin extends User{

function __construct($data=-1){
    parent::__construct("Admin",$data);
}

function get_reports(){
    return $this->db->select("report");
}

function ignore_report($email){
    $this->db->delete("report",$email); //should change
}















}
?>