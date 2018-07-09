<?php

    // Παίρνουμε το id του άρθρου που επέλεξε ο συντάκτης στη σελίδα "edit_my_articles"
    session_start();

    $selected_article = $_SESSION['selected_article_id'];
    
    include ('db_connect.php');
        
    $query = "DELETE FROM `Άρθρο` WHERE `id-άρθρου` = '$selected_article';";
    $result = mysqli_query($dbc, $query);
    
    if ($result == 0) {
        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά τη διαγραφή του άρθρου σας!"); document.location="../pages/edit_my_articles.php";</script></html>';
    } else {
        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Επιτυχής διαγραφή του άρθρου σας!"); document.location="../pages/edit_my_articles.php";</script></html>';
    }
        
	mysqli_close($dbc);

?>