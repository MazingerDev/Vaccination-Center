<?php

    if(isset($_POST["submit"]))
    {
        include '../Model/LoginRegModel.php';

        $reg = new LoginRegModel();
        $userName = $_POST["username"];
        $password = $_POST["password"];
        $name =$_POST["name"] ;
        $cityID =$_POST['city'];
        $email = $_POST["email"];
        $nationalID = $_POST["id"];
        $phoneNUmber = $_POST["phone"];

        if(empty($userName) || empty($password) || empty($name) || empty($email) || empty($nationalID) || empty($phoneNUmber))
        {
            header("location: http://localhost/vaccination-center/View/sign_up.php?signup=empty");
            exit()  ;
        }
        else
        {
            if (!preg_match('@[a-z]@', $password) || !preg_match('@[0-9]@', $password) || strlen($password) < 8)
            {
                header("location: ../View/sign_up.php?signup=invalidpass");
                exit();
            }

            else
            {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    header("location: ../View/sign_up.php?signup=invalidemail");
                    exit();
                }
                else
                {
                   if(preg_match('@[A-Z]@', $phoneNUmber) ||preg_match('@[a-z]@', $phoneNUmber))
                   {
                       header("location: ../View/sign_up.php?signup=invalidphone");
                       exit();
                   }
                   else
                   {
                       if(preg_match('@[A-Z]@', $nationalID) ||preg_match('@[a-z]@', $nationalID))
                       {
                           header("location: ../View/sign_up.php?signup=invalidID");
                           exit();
                       }
                       else
                       {
                           $registration = $reg->registeration($userName,$password,$nationalID,$name,$cityID,$email,$phoneNUmber);
                           if ($registration) {
                               header("location: ../View/login.php");
                           } else {
                               header("location: ../View/sign_up.php?signup=exists");
                           }
                       }

                   }
                }
            }
        }

    }
    else
    {
        header("location: ../View/sign_up.php");
        exit();
    }

