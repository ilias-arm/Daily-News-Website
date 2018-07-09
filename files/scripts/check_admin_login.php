<?php

    session_start();
    
    if(isset($_POST['admin_login_button'])){

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        include('db_connect.php');
        
        $query = "SELECT * FROM `Συντάκτης` WHERE `Username` = '$username' AND `Password` = '$password'";
        $result = mysqli_query($dbc, $query);
        $rows = mysqli_num_rows($result);
        
        if ($rows == 0) {
		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Λάθος στοιχεία, προσπαθήστε ξανά!"); document.location="../pages/login.php";</script></html>';
        } else {
            $user_rec = mysqli_fetch_row($result);
            $id = $user_rec[0];
            $username = $user_rec[1];
            $password = $user_rec[2];
            $fname = $user_rec[3];
            $lname = $user_rec[4];
            
            $_SESSION['logged_in_id'] = $id;
            $_SESSION['logged_in_username'] = $username;
            $_SESSION['logged_in_password'] = $password;
            $_SESSION['logged_in_fname'] = $fname;
            $_SESSION['logged_in_lname'] = $lname;

		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Συνδεθήκατε με επιτυχία!"); document.location="../index.php";</script></html>';
        }
    
    	mysqli_close($dbc);
    	
    }
    
?>

