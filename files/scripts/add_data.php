<?php
    session_start(); 
            
    $logged_in_id = $_SESSION['logged_in_id'];
        
    $age = $_POST['age'];
    $sex = $_POST['sex'];
        
    include ('db_connect.php');
        
    if($sex == "male"){
        $sex = "M";
    } else {
        $sex = "F";
    }
        
    $query = "UPDATE `Συνδρομητής` SET `Ηλικία` = '$age', `Φύλο` = '$sex' WHERE `id-συνδρομητή` = 'logged_in_id';";
    $result = mysqli_query($dbc, $query);
    
    if ($result == 0) {
        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή των στοιχείων"); document.location="../pages/edit_my_account.php";</script></html>';
    } else {
            
    $_SESSION['logged_in_age'] = $age;
    $_SESSION['logged_in_sex'] = $sex;
            
	echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η εισαγωγή των στοιχείων ολοκληρώθηκε με επιτυχία!"); document.location="../pages/edit_my_account.php";</script></html>';

    }
        
    mysqli_close($dbc);
?>