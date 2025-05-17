<?php

    include_once 'config.php';

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $username= $_POST['username'];
        $email = $_POST['email'];
        $tempPassword = $_POST['password'];
        $password = password_hash($tempPassword, PASSWORD_DEFAULT);

        if (empty($name) ||empty($username) ||empty($email) ||empty($password)){
            echo "You need to fill all the fields";

            header("refresh:3; url=signup.php");
        } else{
            $sql = "SELECT username from users WHERE username=:username";

            $tempSql = $conn->prepare($sql);
            $tempSql->bindParam(":username",$username);
            $tempSql->execute();

            if($tempSql->rowcount() > 0){
                echo "Username exists!";
                header("refresh:3; url=login.php");
            }else{
                $sql = "INSERT INTO users (emri,username,email,password, confirm_password, is_admin) VALUES (:name,:username,:email,:password,:confirm_password,:is_admin)";
                $isAdmin= 0 ;
                $tempSql = $conn->prepare($sql);
                $tempSql->bindParam(":name",$name);
                $tempSql->bindParam(":username",$username);
                $tempSql->bindParam(":email",$email);
                $tempSql->bindParam(":password",$password);
                $tempSql->bindParam(":confirm_password",$password);
                $tempSql->bindParam(":is_admin",$isAdmin);
                $tempSql->execute();

                echo "Data saved successfully!";
                header("refresh:3; url=login.php");
            }


    

        }
    

    }