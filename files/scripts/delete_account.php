<?php 
        
    session_start();
       
    $logged_in_id = $_SESSION['logged_in_id'];
        
    include ('db_connect.php');
        
    $query = "DELETE FROM `Συνδρομητής` WHERE `id-συνδρομητή` = '$logged_in_id';";
    $result = mysqli_query($dbc, $query);
    
    if ($result == 0) {
        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά τη διαγραφή του λογαριασμού σας!"); document.location="../pages/edit_my_account.php";</script></html>';
    } else {
        $_SESSION['logged_in_id'] = NULL;
        
        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Επιτυχής διαγραφή του λογαριασμού σας!"); document.location="../index.php";</script></html>';
    }
        
	mysqli_close($dbc);

?>
