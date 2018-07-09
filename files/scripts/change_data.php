<?php
    
    if(isset($_POST['change_data_submit'])){
        
        session_start(); 
        include('db_connect.php');
        
        $email = $_POST['new_email'];
        
        //Ελέγχουμε αν το email που μας έδωσε ο χρήστης υπάρχει ήδη στη ΒΔ
        $check_query = "SELECT * FROM `Συνδρομητής` WHERE `E-mail` = '$email'";
        $check_result = mysqli_query($dbc, $check_query);
        $check_rows = mysqli_fetch_row($check_result);
        
        //Αν υπάρχει εγγραφή στη βάση
        if($check_rows != 0) {
            
            //Τότε ακυρώνουμε την εγγραφή
            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Το email χρησιμοποιείται ήδη, παρακαλώ επιλέξτε διαφορετικό email!"); document.location="../pages/change_data.php";</script></html>';
            
        //Αλλιώς συνεχίζουμε με την εγγραφή    
        } else {

            $id = $_SESSION['logged_in_id'];
            
            $fname = $_POST['new_fname'];
            $lname = $_POST['new_lname'];
            $password = $_POST['new_password'];
            $age = $_POST['new_age'];
            $sex = $_POST['new_sex'];
            
            if(empty($fname)){
                $fname = $_SESSION['logged_in_fname'];
            }
            
            if(empty($lname)){
                $lname = $_SESSION['logged_in_lname'];
            }
            
            if(empty($email)){
                $email = $_SESSION['logged_in_email'];
            }
            
            if(empty($password)){
                $password = $_SESSION['logged_in_password'];
            }
            
            if(empty($age)){
                $age = $_SESSION['logged_in_age'];
            }
            
            if($sex == "male"){
                $sex = "M";
            } else if($sex == "female") {
                $sex = "F";
            } else if(empty($sex)){
                $sex = $_SESSION['logged_in_sex'];
            }
            
            $query = "UPDATE `Συνδρομητής` SET `Όνομα` = '$fname', `Επώνυμο` = '$lname', `E-mail` = '$email', `password` = '$password', `Ηλικία` = '$age', `Φύλο` = '$sex' WHERE `id-συνδρομητή` = '$id';";
            
            $result = mysqli_query($dbc, $query);
        
            if ($result == 0) {
    		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή των στοιχείων"); document.location="../pages/change_data.php";</script></html>';
            } else {
                
                $_SESSION['logged_in_fname'] = $fname;
                $_SESSION['logged_in_lname'] = $lname;
                $_SESSION['logged_in_email'] = $email;
                $_SESSION['logged_in_password'] = $password;
                $_SESSION['logged_in_age'] = $age;
                $_SESSION['logged_in_sex'] = $sex;
                
    		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η εισαγωγή των στοιχείων ολοκληρώθηκε με επιτυχία!"); document.location="../pages/edit_my_account.php";</script></html>';
            
                
            }
            
        	mysqli_close($dbc);
        }

    }
    
?>