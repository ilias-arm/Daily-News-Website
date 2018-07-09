<?php
    
        $name = $_POST['fname'];
        $surname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        
        include ('db_connect.php');
        
        //Ελέγχουμε αν το email που μας έδωσε ο χρήστης υπάρχει ήδη στη ΒΔ
        $check_query = "SELECT * FROM `Συνδρομητής` WHERE `E-mail` = '$email'";
        $check_result = mysqli_query($dbc, $check_query);
        $check_rows = mysqli_fetch_row($check_result);
        
        //Αν υπάρχει εγγραφή στη βάση
        if($check_rows != 0) {
            
            //Τότε ακυρώνουμε την εγγραφή
            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Το email χρησιμοποιείται ήδη, παρακαλώ επιλέξτε διαφορετικό email!"); document.location="../pages/register.php";</script></html>';
            
        //Αλλιώς συνεχίζουμε με την εγγραφή    
        } else {
            
            if(empty($age)) {
                $age = "NULL";
            }
        
            if($sex == "male"){
                $sex = "M";
            } else if ($sex == "female"){
                $sex = "F";
            } else {
                $sex = "NULL";
            }
        
            $query = "INSERT INTO `Συνδρομητής` (`id-συνδρομητή`, `Όνομα`, `Επώνυμο`, `E-mail`, `Password`, `Ηλικία`, `Φύλο`) VALUES (NULL, '$name', '$surname', '$email', '$password', '$age', '$sex');";
                
            $result = mysqli_query($dbc, $query);
            
            if ($result == 0) {
                echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή των στοιχείων"); document.location="../pages/register.php";</script></html>';
            } else {
        	    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Ο λογαριασμός σας δημιουργήθηκε με επιτιχία!"); document.location="../index.php";</script></html>';
                    
                session_start();
                    
                $query = "SELECT * FROM `Συνδρομητής` WHERE `E-mail` = '$email' AND `Password` = '$password'";
                $result = mysqli_query($dbc, $query);
                
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
                    
                }
                
        mysqli_close($dbc);
        
        }
    

?>
