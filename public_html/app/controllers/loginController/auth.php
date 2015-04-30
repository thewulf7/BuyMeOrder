<?php
/**
 * login_auth controller
 * User: johnnyutkin
 * Date: 30.04.15
 * Time: 19:46
 */

function login_auth(){

    if($_SERVER["REQUEST_METHOD"]=="POST"):

        $password = isset($_POST["password"]) ? $_POST["password"] : false;
        $email = isset($_POST["email"]) ? $_POST["email"] : false;



        if(!$password || !$email) return;

        loader_model("user");

        if(user_auth($email,$password)) header('Location: /');
        else header('Location: /login/do/?error=1');

    endif;

    return false;
}