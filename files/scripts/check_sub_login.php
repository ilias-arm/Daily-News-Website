<?php
    

        session_start();

        $email = $_POST['email'];
        $password = $_POST['password'];
        
        include('db_connect.php');
        
        $query = "SELECT * FROM `Συνδρομητής` WHERE `E-mail` = '$email' AND `Password` = '$password'";
        $result = mysqli_query($dbc, $query);
        $rows = mysqli_num_rows($result);
        
        if ($rows == 0) {
		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Λάθος στοιχεία, προσπαθήστε ξανά!"); document.location="../pages/login.php";</script></html>';
        } else {
            $user_rec = mysqli_fetch_row($result);
            $id = $user_rec[0];
            $fname = $user_rec[1];
            $lname = $user_rec[2];
            $email = $user_rec[3];
            $password = $user_rec[4];
            $age = $user_rec[5];
            $sex = $user_rec[6];
            
            $_SESSION['logged_in_id'] = $id;
            $_SESSION['logged_in_fname'] = $fname;
            $_SESSION['logged_in_lname'] = $lname;
            $_SESSION['logged_in_email'] = $email;
            $_SESSION['logged_in_password'] = $password;
            $_SESSION['logged_in_age'] = $age;
            $_SESSION['logged_in_sex'] = $sex;
            
		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Συνδεθήκατε με επιτυχία!"); document.location="../index.php";</script></html>';
        }
    
    	mysqli_close($dbc);
    	
    
    
?>

