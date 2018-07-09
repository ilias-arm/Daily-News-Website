<?php

    if(isset($_POST['add_sub_submit'])){
        
        session_start();
        
        $subscriber_id = $_SESSION['logged_in_id'];
        
        $category_id = $_POST['category_drop_down_menu'];
        
        include('db_connect.php');
        
        if(isset($category_id)) {
        
            foreach($category_id as $id) {
    
                $query = "INSERT INTO `Συνδρομητής επιλέγει κατηγορίες` (`id-επιλογής`, `id-συνδρομητή`, `id-κατηγορίας`) VALUES (NULL, '$subscriber_id', '$id');";
            
                $result = mysqli_query($dbc, $query);
            
                if($result == 0) {
    		        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή της συνδρομής!"); document.location="../pages/edit_my_subs.php";</script></html>';
                } else {
    		        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η εισαγωγή της συνδρομής ολοκληρώθηκε με επιτυχία!"); document.location="../pages/edit_my_subs.php";</script></html>';
                }
                
            }
            
            mysqli_close($dbc);
        
        } else {
            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν έχετε επιλέξει κατηγορία!"); document.location="../pages/edit_my_subs.php";</script></html>';
        }    

    }

?>