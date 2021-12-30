<?php

class Session_Controller extends Controller{

    function __construct(){
        parent::__construct();
    }

    function index(){
       
    }


    //Providing display to create sessiosn
    function viewCreate(){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach"){
            $this->view->render('Session/create');
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/viewCreate";
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();
        }            
    }    


    //Creating Virtual Gym Sessions or redirects for payments
    function create(){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach"){
            if(isset($_SESSION['payment_data']) && $_SESSION['payment_data']['Item_id']==-1 &&
            $_SESSION['payment_data']['Payer_Email']===$_SESSION['logged_user']['email'] &&
            $_SESSION['payment_data']['Payment_Type']==PAYMENT_SESSION_CREATE){
                Session::create($_SESSION['payment_request_data']);
                unset($_SESSION['payment_data']);
                header("Location:".BASE_DIR."Session/createdByMe");
            }else{
                //do validations TODO
                $_POST["startTime"].=":00";
                $_POST["endTime"].=":00";
                $_SESSION['payment_request_data'] =  array("Coach_Email"=>$_SESSION['logged_user']['email'],
                "Session_Name"=>$_POST['sessionName'],"Date"=>$_POST["date"],"Start_Time"=>$_POST["startTime"],
                "End_Time"=>$_POST["endTime"],"Num_Participants"=>$_POST["maxParticipants"],"price"=>$_POST["price"],
                "Details"=>$_POST["details"]) ;          
                header("Location:".BASE_DIR."Payment/viewPayment/".PAYMENT_SESSION_CREATE);
            }
            die();                


        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/viewCreate";
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();
        }
    }


    //Displaying Gym Sessons created by himself
    function createdByMe(){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach"){
            $_SESSION['data'] = Session::createdSessions($_SESSION['logged_user']['email']);
            $this->view->render('Session/createdSessionsByACoach');  
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/createdByMe";
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();
        }  
    }
    
                
    //Displaying the selected session
    function view($session_id){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach"){
            $_SESSION['data'] = $this->model->getData();
            if($_SESSION['logged_user']['email']===$this->model->getCreatedCoach()){   //view by creator
                $this->view->render("Session/view/creator");  
            }else{     //view by another coach
                $this->view->render("Session/view/coach");
            }
        }elseif(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Customer"){  //view by a customer
            $_SESSION['data'] = $this->model->getData();
            $_SESSION['data']['isRegistered'] = $this->model->isCustomerRegistered($_SESSION['logged_user']['email']);
            $this->view->render("Session/view/customer");
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/view/".$session_id;
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();
        } 
    }


    //Displaying all available sessions
    function viewAll(){
        $_SESSION['data'] = Session::getAllSessions();
        $this->view->render("Session/viewAll");
    }


    //Delecting the session
    function delete($session_id){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach" && $_SESSION['logged_user']['email']===$this->model->getCreatedCoach()){
            $this->model->delete($session_id); 
            header("Location:".BASE_DIR."Session/createdByMe");
            die();     
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/delete/".$session_id;
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();              
        }
    }


    //Editing the seesiosn
    function edit($session_id){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Coach" && $_SESSION['logged_user']['email']===$this->model->getCreatedCoach()){
            $this->model->edit(array("Coach_Email"=>$_SESSION['logged_user']['email'],
            "Session_Name"=>$_POST['session_name'],"Date"=>$_POST["date"],"Start_Time"=>$_POST["startTime"],
            "End_Time"=>$_POST["endTime"],"Num_Participants"=>$_POST["num_participants"],
            "Price"=>$_POST["price"],"Details"=>$_POST["details"]),"ssssssds");         
            header("Location:".BASE_DIR."Session/view/".$session_id);
            die();
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/delete/".$session_id;
            header("Location:".BASE_DIR."Auth/login/Coach");
            die();              
        }        
    }    


    //registering current customer for the session or redirecting for payments
    //Observable
    function register($session_id){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Customer"){ 
            if(isset($_SESSION['payment_data']) && $_SESSION['payment_data']['Item_id']===$session_id &&
            $_SESSION['payment_data']['Payer_Email']===$_SESSION['logged_user']['email'] &&
            $_SESSION['payment_data']['Payment_Type']==PAYMENT_SESSION_REGISTER){
                $this->model->register($_SESSION['logged_user']['email'],$session_id);   
                unset($_SESSION['payment_data']);
                header("Location:".BASE_DIR."Session/view/".$session_id);   
            }else{
                $_SESSION['payment_request_data'] = array("price"=>$_POST['price'],"session_id"=>$session_id);                 
                header("Location:".BASE_DIR."Payment/viewPayment/".PAYMENT_SESSION_REGISTER);
            }
            die();    
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/register/".$session_id;
            header("Location:".BASE_DIR."Auth/login/Customer");
            die();            
        }
    }


    //Unregister current customer from the session
    //Observable
    function unregister($session_id){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Customer"){ 
            $this->model->unregister($_SESSION['logged_user']['email'],$session_id);
            header("Location:".BASE_DIR."Session/view/".$session_id);
            die();    
        }else{
            $_SESSION['requested_address'] = BASE_DIR."Session/unregister/".$session_id;
            header("Location:".BASE_DIR."Auth/login/Customer");
            die();  
        }       
    }


    //Displaying registered sessions by a customer
    function registeredByMe(){
        if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']['type']==="Customer"){ 
            $_SESSION['data'] = Session::registeredSessions($_SESSION['logged_user']['email']);
            $this->view->render('session/registeredSessionsByACustomer');  
        }else{
            header("Location:".BASE_DIR."Auth/login/Customer");
            die();  
        }       
    }

}