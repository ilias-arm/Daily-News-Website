<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <!-- Χρησιμοποιούμε μεταβλητό μήκος, ώστε να μπορούμε να βλέπουμε την ιστοσελίδα σε οποιαδήποτε συσκευή (pc, tablet, κινητό κλπ) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Χρησιμοποιούμε το συγκεκριμένο tag για να υπάρχει προσβασιμότητα απο όλους τους browser -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Express news!</title>
    
    <link rel="stylesheet" href="./css/myCss.css">

</head>

<?php session_start(); ?>

<body>

    <!-- Το header της ιστοσελίδας είναι κοινό για όλες τις html σελίδες -->
    <header id="website_header">

        <div id="upper_part">
            <!-- Ως upper_part ορίζουμε το σημείο της επικεφαλίδας που περιλαμβάνει το logo,
        τα links και τα κουμπιά εισοου και εγρραφής -->
            <div id="logo">
                <a href="index.php"><img src="./images/newspaper_logo.png" alt="logo"></a>
            </div>
            <div id="links">
                <!-- Τα links για τα κοινωνικά δίκτυα, το youtube και το rss. Ορίζουμε το ύψος των εικονιδίων
            στα 45 pixel -->
                <a href="https://facebook.com"><img src="./logos/facebook_logo.jpg" height="45" alt="facebook"></a>
                <a href="https://twitter.com"><img src="./logos/twitter_logo.png" height="45" alt="twitter"></a>
                <a href="https://youtube.com"><img src="./logos/youtube_logo.png" height="45" alt="youtube"></a>
                <a href="#"><img src="./logos/rss_logo.png" height="45" alt="rss"></a>
            </div>
            
            <?php  
                
                
                //Και ο συνδρομητής και ο συντάκτης έχουν id.
                $id = $_SESSION['logged_in_id'];
                
                //Οπότε θα χρησιμοποιήσουμε τη μεταβλητή "username" για να ελέγχουμε αν ο χρήστης 
                //είναι συντάκτης ή συνδρομητής.
                //Αν είναι συνδρομητής (δηλαδή το "username είναι κενό") εμφανίζεται το κουμπί "ο λογαριασμός μου", 
                //όπου επιτρέπεται η επεξεργασία των στοιχείων του.
                // Αν είναι συντάκτης εμφανίζεται το κουμπί "τα άρθρα μου", όπου επιτρέπεται η επεξεργασία των άρθρων του.
                $username = $_SESSION['logged_in_username'];
                
                //Αν οποιοδήποτε id δεν είναι κενό τότε έχουμε συνδεθεί
                if(isset($id)) { ?>
                    <div id="buttons">
                    <!-- Ανάλογα με την κατηγορία χρήστη (συνδρομητής ή συντάκτης) εμφανίζουμε τα κατάλληλα κουμπιά -->    
                    <?php if(isset($username)) { ?>
                        <div id="admin_buttons">
                            <a href="./pages/view_subscriber_xml.php"><button type="button" name="edit_my_articles">XML</button></a>
                            <a href="./pages/edit_my_articles.php"><button type="button" name="edit_my_articles">Τα άρθρα μου</button></a>
                            <a href="./pages/stats.php"><button type="button" name="stats">Στατιστικά</button></a>
                            <a href="./scripts/logout.php"><button type="button" name="logout">Αποσύνδεση</button></a>
                        </div>
                    <?php } else { ?>
                        <div id="sub_buttons">
                            <a href="./pages/edit_my_account.php"><button type="button" name="edit_my_account">Ο λογαριασμός μου</button></a>
                            <a href="./pages/edit_my_subs.php"><button type="button" name="edit_my_subs">Οι συνδρομές μου</button></a>
                            <a href="./pages/stats.php"><button type="button" name="stats">Στατιστικά</button></a>
                            <a href="./scripts/logout.php"><button type="button" name="logout">Αποσύνδεση</button></a>
                        </div>
                    <?php } ?>    
                    </div>    
                
                 <!-- Αν το id είναι κενό, τότε θεωρούμαστε επισκέπτες και εμφανίζουμε τα κατάλληλα κουμπιά -->
                 <?php } else { ?>
                            <div id="buttons">
                                <a href="./pages/register.php"><button type="button" name="register">Εγγραφή</button></a>
                                <a href="./pages/login.php"><button type="button" name="login">Είσοδος</button></a>
                            </div>
                <?php } ?>
            
        </div>

        <!-- Το menu επιλογών -->
        <nav id="top_menu">
            <!-- Χρησιμοποιούμε unordered list για την ταξινόμηση των κατηγοριών -->
            <ul>
                <li id="current"><a href="index.php">Αρχική</a></li>
                <!-- Χρησιμοποιούμε το id "current" για να μπορούμε
                να επισημάνουμε με διαφορετικό χρώμα την κατηγορία που βρισκόμαστε. Στην προκείμένη περίπτωση βρισκόμαστε στην "Αρχική" -->
                <li><a href="./pages/politiki.php">Πολιτική</a></li>
                <li><a href="./pages/oikonomia.php">Οικονομία</a></li>
                <li><a href="./pages/koinonia.php">Κοινωνία</a></li>
                <li><a href="./pages/athlitismos.php">Αθλητισμός</a></li>
                <li><a href="./pages/politismos.php">Πολιτισμός</a></li>
                <li><a href="./pages/kosmos.php">Κόσμος</a></li>
            </ul>
        </nav>
    </header>

    <div id="index">
        
        <section id="content_area">
            
                <?php 
                
                //Φέρνουμε σπο τη ΒΔ τα άρθρα που θα εμφανίζονται στην αρχική σελίδα.
                include('./scripts/db_connect.php');
            
                //Πρώτα φέρνουμε τα ανοιχτά, τα οποία εμφανίζονται σε όλους.
                $query = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'O'";
                $result = mysqli_query($dbc, $query);
                
                while($user_rec = mysqli_fetch_row($result)) { 
                
                    $id = $user_rec[0];
                    $title = $user_rec[1];
                    $article_text = $user_rec[2];
                    $publish_date = $user_rec[3];
                    $availability = $user_rec[5];
                    $category = $user_rec[6];
                    
                    //Μεταβλητή για την αποθήκευση του ονόματος της κατηγορίας.
                    //Θα χρησιμοποιηθεί για να φτιάξουμε το link στον τίτλο του άρθρου.
                    $category_name = NULL;
                    
                    switch ($category) {
                        case 1:
                            $category_name = "athlitismos";
                            break;
                        case 2:
                            $category_name = "politiki";
                            break;
                        case 3:
                            $category_name = "oikonomia";
                            break;
                        case 4:
                            $category_name = "politismos";
                            break;
                        case 5:
                            $category_name = "koinonia";
                            break;
                        case 6:
                            $category_name = "kosmos";
                            break;
                    } ?>
                    
                                <article id="index_article">
                                    <h1><a href="./pages/<?php echo $category_name ?>.php"> <?php echo $title ?> </a></h1>
                                    <a href="./pages/<?php echo $category_name ?>.php"><img src="./images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>"></a>
                                    <p> <?php echo $article_text ?> </p>
                                </article>

                <?php }
                
                //Αν είναι συνδεδεμένος ο συντάκτης εμφανίζονται και τα κλειστά άρθρα
                if(isset($username)) {
                    
                    $query_1 = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'C'";
                    $result_1 = mysqli_query($dbc, $query_1);

                    
                    while($user_rec_1 = mysqli_fetch_row($result_1)) {
                            
                            $id = $user_rec_1[0];
                            $title = $user_rec_1[1];
                            $article_text = $user_rec_1[2];
                            $publish_date = $user_rec_1[3];
                            $availability = $user_rec_1[5];
                            $category = $user_rec_1[6];
                            
                            //Μεταβλητή για την αποθήκευση του ονόματος της κατηγορίας.
                            //Θα χρησιμοποιηθεί για να φτιάξουμε το link στον τίτλο του άρθρου.
                            $category_name = NULL;
                            
                            switch ($category) {
                                case 1:
                                    $category_name = "athlitismos";
                                    break;
                                case 2:
                                    $category_name = "politiki";
                                    break;
                                case 3:
                                    $category_name = "oikonomia";
                                    break;
                                case 4:
                                    $category_name = "politismos";
                                    break;
                                case 5:
                                    $category_name = "koinonia";
                                    break;
                                case 6:
                                    $category_name = "kosmos";
                                    break;
                            } ?>
            
                                        <article id="index_article">
                                            <h1><a href="./pages/<?php echo $category_name ?>.php"> <?php echo $title ?> </a></h1>
                                            <a href="./pages/<?php echo $category_name ?>.php"><img src="./images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>"></a>
                                            <p> <?php echo $article_text ?> </p>
                                        </article>

                    <?php }
                    
                    }
                
                
                 mysqli_close($dbc); ?>
            
            <!-- Στη συνέχεια φέρνουμε και τα άρθρα στα οποία ο συνδεδεμένος χρήστης (συνδρομητής) είναι εγγεγραμένος. -->
            <?php 
                
                include('./scripts/db_connect.php');
            
                $query_1 = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'C'";
                $result_1 = mysqli_query($dbc, $query_1);

                $user_id = $_SESSION['logged_in_id'];
                
                while($user_rec_1 = mysqli_fetch_row($result_1)) {

                    $category_id = $user_rec_1[6];

                    $query_2 = "SELECT * FROM `Συνδρομητής επιλέγει κατηγορίες` WHERE `id-συνδρομητή` = '$user_id' AND `id-κατηγορίας` = '$category_id';";
                    $result_2 = mysqli_query($dbc, $query_2);
                    $rows = mysqli_num_rows($result_2);
                    
                        if($rows > 0) {
                            
                            $id = $user_rec_1[0];
                            $title = $user_rec_1[1];
                            $article_text = $user_rec_1[2];
                            $publish_date = $user_rec_1[3];
                            $availability = $user_rec_1[5];
                            $category = $user_rec_1[6];
                            
                            //Μεταβλητή για την αποθήκευση του ονόματος της κατηγορίας.
                            //Θα χρησιμοποιηθεί για να φτιάξουμε το link στον τίτλο του άρθρου.
                            $category_name = NULL;
                            
                            switch ($category) {
                                case 1:
                                    $category_name = "athlitismos";
                                    break;
                                case 2:
                                    $category_name = "politiki";
                                    break;
                                case 3:
                                    $category_name = "oikonomia";
                                    break;
                                case 4:
                                    $category_name = "politismos";
                                    break;
                                case 5:
                                    $category_name = "koinonia";
                                    break;
                                case 6:
                                    $category_name = "kosmos";
                                    break;
                            } ?>
            
                                        <article id="index_article">
                                            <h1><a href="./pages/<?php echo $category_name ?>.php"> <?php echo $title ?> </a></h1>
                                            <a href="./pages/<?php echo $category_name ?>.php"><img src="./images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>"></a>
                                            <p> <?php echo $article_text ?> </p>
                                        </article>
                    <?php }

                } 

            mysqli_close($dbc); ?>
            
        </section>

        <!-- Ο χώρος για τις διαφημίσεις (ads banner) είναι κοινός για όλες τις html σελίδες -->
        <aside id="ads">
            <!-- Χρησιμοποιούμε unordered list, ώστε να μπορούμε να προσθέτουμε ή να αφαιρούμε διαφημίσεις -->
            <ul>
                <li><a href="#"><img src="./images/ad_1.jpg" alt="ad_1"></a></li>
                <li><a href="#"><img src="./images/ad_2.gif" alt="ad_2"></a></li>
            </ul>
        </aside>
    </div>

    <!-- Το footer είναι κοινό για όλες τις html σελίδες -->
    <footer id="website_footer">
        <!-- Χρησιμοποιούμε unordered list για την ταξινόμηση των κατηγοριών -->
        <ul>
            <li><a href="index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a>
                <li><a href="#">ΟΡΟΙ ΧΡΗΣΗΣ</a></li>
                <li><a href="#">ΠΡΟΣΤΑΣΙΑ ΠΡΟΣΟΠΙΚΩΝ ΔΕΔΟΜΕΝΩΝ</a></li>
                <li><a href="#">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
            </li>
        </ul>
    </footer>

</body>

</html>
