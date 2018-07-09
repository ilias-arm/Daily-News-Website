<?php
    session_start(); 
            
    $selected_article_id = $_SESSION['selected_article_id'];
        
    $title = $_POST['new_title'];
    $article_text = $_POST['new_article_text'];
    $publish_date = $_POST['new_publish_date'];
    $availability = $_POST['new_availability'];
    $category = $_POST['new_category'];

    //Ελέγχουμε αν ο συντάκτης έχει αφήσει κενό κάποιο πεδίο.
    //Αν έχει αφήσει, τότε στη ΒΔ παραμένει ίδιο το πεδίο
    
    if(empty($title)){
        $title = $_SESSION['selected_title'];
    }
        
    if(empty($article_text)){
        $article_text = $_SESSION['selected_article_text'];
    }
    
    if(empty($publish_date)){
        $publish_date = $_SESSION['selected_publish_date'];
    }
        
    if(empty($availability)){
        $availability = $_SESSION['selected_availability'];
    }
        
    if(empty($category)){
        $category = $_SESSION['selected_category'];
    }
        
    if($availability == "open"){
        $availability = "O";
    } else if($availability == "only_members") {
        $availability = "C";
    } else if(empty($availability)){
        $availability = $_SESSION['selected_availability'];
    }
        
    include ('db_connect.php');
    
    $query = "UPDATE `Άρθρο` SET `Τίτλος` = '$title', `Κείμενο` = '$article_text', `Ημερομηνία Δημοσίευσης` = '$publish_date', `Πρόσβαση` = '$availability', `id-κατηγορίας` = '$category' WHERE `id-άρθρου` = '$selected_article_id'";
    $result = mysqli_query($dbc, $query);
    
    if ($result == 0) {
	    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Σφάλμα κατά την εισαγωγή των στοιχείων"); document.location="../pages/edit_my_articles.php";</script></html>';
    } else {
            
        $_SESSION['selected_title'] = $title;
        $_SESSION['selected_article_text'] = $article_text;
        $_SESSION['selected_publish_date'] = $publish_date;
        $_SESSION['selected_availability'] = $availability;
        $_SESSION['selected_category'] = $category;

	    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Η αλλαγή των στοιχείων του άρθρου ολοκληρώθηκε με επιτυχία!"); document.location="../pages/edit_my_articles.php";</script></html>';
        
    }
        
    mysqli_close($dbc);
?>