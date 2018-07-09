<?php

    if(isset($_POST['delete_subscribe_submit'])){
        
        session_start();
        
        $subscriber_id = $_SESSION['logged_in_id'];
        
        $category_id = $_POST['category_drop_down_menu'];
        
        if(isset($category_id)){
            
            include('db_connect.php');
        
            foreach($category_id as $id) {
            
                $query = "DELETE FROM `Συνδρομητής επιλέγει κατηγορίες` WHERE `id-συνδρομητή` = '$subscriber_id' AND `id-κατηγορίας` = '$id';";
        
                $result = mysqli_query($dbc, $query);
        
                if($result == 0) {
		            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά τη διαγραφή της συνδρομής!"); document.location="../pages/edit_my_subs.php";</script></html>';
                } else {
		            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η διαγραφή της συνδρομής ολοκληρώθηκε με επιτυχία!"); document.location="../pages/edit_my_subs.php";</script></html>';
                }
            
            }
        
        mysqli_close($dbc);

        } else {
            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν έχετε επιλέξει κατηγορία!"); document.location="../pages/edit_my_subs.php";</script></html>';
        }
        
        

    }

?>