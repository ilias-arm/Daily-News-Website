<?php
    session_start();

    //Ανάλογα με το κουμπί που έχει πατήσει ο χρήστης, εκτελείται και το αντίστοιχο κομμάτι κώδικα 
    
    //Αλλαγή στοιχείων του άρθρου
    if(isset($_POST['change_article_button'])) {
        
        $selected_article_id = $_POST['article_title'];
        
        $_SESSION['selected_article_id'] = $selected_article_id;
        
        include ('../scripts/db_connect.php');

        $query = "SELECT * FROM `Άρθρο` WHERE `id-άρθρου` = '$selected_article_id'";
        $result = mysqli_query($dbc, $query);
        $rows = mysqli_num_rows($result);
        
        if ($rows == 0) {
		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Πρόβλημα στη φόρτωση του άρθρου, προσπαθήστε ξανά!"); document.location="../pages/edit_my_articles.php";</script></html>';
        } else {
            $user_rec = mysqli_fetch_row($result);
            
            $title = $user_rec[1];
            $article_text = $user_rec[2];
            $publish_date = $user_rec[3];
            $availability = $user_rec[5];
            $category = $user_rec[6];
            
            $_SESSION['selected_title'] = $title;
            $_SESSION['selected_article_text'] = $article_text;
            $_SESSION['selected_publish_date'] = $publish_date;
            $_SESSION['selected_availability'] = $availability;
            $_SESSION['selected_category'] = $category;
            
            header("Location: ../pages/change_article.php");
            exit;
        }
        
    //Διαγραφή του άρθρου    
    } else if(isset($_POST['delete_article_button'])) {
        
        $_SESSION['selected_article_id'] = $_POST['article_title'];
        
        header("Location: delete_article.php");
        exit;
      
    //Προβολή άρθρου   
    } else if(isset($_POST['view_article_button'])) {
        
        $selected_article_id = $_POST['article_title'];
        
        $_SESSION['selected_article_id'] = $selected_article_id;
        
        include ('../scripts/db_connect.php');

        $query = "SELECT * FROM `Άρθρο` WHERE `id-άρθρου` = '$selected_article_id'";
        $result = mysqli_query($dbc, $query);
        $rows = mysqli_num_rows($result);
        
        if ($rows == 0) {
		    echo '<html><meta charset="UTF-8"><script language="javascript">alert("Πρόβλημα στη φόρτωση του άρθρου, προσπαθήστε ξανά!"); document.location="../pages/edit_my_articles.php";</script></html>';
        } else {
            $user_rec = mysqli_fetch_row($result);
            
            $title = $user_rec[1];
            $article_text = $user_rec[2];
            $publish_date = $user_rec[3];
            $availability = $user_rec[5];
            $category = $user_rec[6];
            
            $_SESSION['selected_title'] = $title;
            $_SESSION['selected_article_text'] = $article_text;
            $_SESSION['selected_publish_date'] = $publish_date;
            $_SESSION['selected_availability'] = $availability;
            $_SESSION['selected_category'] = $category;
            
            header("Location: ../pages/view_article.php");
            exit;
        }
    }
?>