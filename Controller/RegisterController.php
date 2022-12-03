<?php

    if(isset($_POST["reg_submit"]))
    {
        include '../Model/LoginRegModel.php';

        $reg = new LoginRegModel();
        $userName = $_POST["reg_username"];
        $password = $_POST["reg_password"];
        $name =$_POST["reg_name"] ;
        $cityID = 1;
        $email = $_POST["reg_email"];
        $nationalID = $_POST["reg_nationalID"];
        $phoneNUmber = $_POST["reg_phonenumber"];

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
                           $reg->registeration($userName,$password,$nationalID,$name,$cityID,$email,$phoneNUmber);
                           header("location: ../View/login.php");
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

