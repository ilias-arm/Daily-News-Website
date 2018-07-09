<?php
    session_start();
        
    $admin_id = $_SESSION['logged_in_id'];
       
    $title = $_POST['title'];
    $article_text = $_POST['article_text'];
    $publish_date = $_POST['publish_date'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];
        
    if($availability == "open") {
        $availability = "O";
    } else {
        $availability = "C";
    }

    include ('db_connect.php');

    $query = "INSERT INTO `Άρθρο` (`Τίτλος`, `Κείμενο`, `Ημερομηνία Δημοσίευσης`, `id-συντάκτη`, `Πρόσβαση`, `id-κατηγορίας`) VALUES ('$title', '$article_text', '$publish_date', '$admin_id', '$availability', '$category')";
    $result = mysqli_query($dbc, $query);
    
    if ($result == 0) {
	    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή του άρθρου!"); document.location="../pages/add_article.php";</script></html>';
    } else {
	    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η εισαγωγή του άρθρου ολοκληρώθηκε με επιτυχία!"); document.location="../index.php";</script></html>';
    }
        
    mysqli_close($dbc);
?>
