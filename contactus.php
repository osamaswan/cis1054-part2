<?php
require_once __DIR__.'/bootstrap.php';
require_once __DIR__.'/cleaninp.php';
echo $twig->render('contact.html');
$msgsent = false; //Initial state where no massages has been sent
if(isset($_POST['submit'])){ //if form is submitted continue else it's invalid
    if (isset($_POST['email']) && $_POST['email'] !=''){ //if email is set and isn't empty
        if (!empty($_POST["email"])) {
            $email = clean_input($_POST["email"]); //clean email
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){ // if email is valid (filter validate is ne of php validation filters)
                //submit form
                $username = $_POST['name'];
                $visitor_email = $_POST['email'];
                $message = $_POST['message'];

                $to = "email@example.com"; // email to recive massages
                $header .= "From: ".$visitor_email;
                $text = "Email From ".$name.".\n\n".$message;

                mail($to, $header, $text);
                $msgsent = true;
                
            }
            else{
                $invalid = "form-invalid";
            }
        }    

    }  
else{
    $msgsent = false;
}
}
