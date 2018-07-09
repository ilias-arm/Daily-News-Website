<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Express news!</title>
    <link rel="stylesheet" href="../css/myCss.css">

</head>

<body>
    <header id="website_header">
        <div id="upper_part">

            <div id="logo">
                <a href="../index.php"><img src="../images/newspaper_logo.png" alt="logo"></a>
            </div>

            <div id="links">
                <a href="https://facebook.com"><img src="../logos/facebook_logo.jpg" height="45" alt="facebook"></a>
                <a href="https://twitter.com"><img src="../logos/twitter_logo.png" height="45" alt="twitter"></a>
                <a href="https://youtube.com"><img src="../logos/youtube_logo.png" height="45" alt="youtube"></a>
                <a href="#"><img src="../logos/rss_logo.png" height="45" alt="rss"></a>
            </div>

            <?php  
                session_start();
                $id = $_SESSION['logged_in_id'];
                
                //Θα χρησιμοποιήσουμε τη μεταβλητή για να ελέγχουμε αν ο χρήστης είναι συντάκτης ή συνδρομητής
                //Αν είναι συνδρομητής εμφανίζεται το κουμπί "ο λογαριασμός μου", όπου επιτρέπεται η
                //επεξεργασία των στοιχείων του. Αν είναι συντάκτης εμφανίζεται το κουμπί "τα άρθρα μου", 
                //όπου επιτρέπεται η επξεργασία των άρθρων του.
                $username = $_SESSION['logged_in_username'];
                
                
                if(isset($id)) { ?>

                    <div id="buttons">
                        
                    <?php if(isset($username)) {  ?>
                        <div id="admin_buttons">
                            <a href="./pages/view_subscriber_xml.php"><button type="button" name="edit_my_articles">XML</button></a>
                            <a href="edit_my_articles.php"><button type="button" name="edit_my_articles">Τα άρθρα μου</button></a>
                            <a href="stats.php"><button type="button" name="stats">Στατιστικά</button></a>
                            <a href="../scripts/logout.php"><button type="button" name="logout">Αποσύνδεση</button></a>
                        </div>
                    <?php } else { ?>
                        <div id="sub_buttons">
                            <a href="edit_my_account.php"><button type="button" name="edit_my_account">Ο λογαριασμός μου</button></a>
                            <a href="edit_my_subs.php"><button type="button" name="edit_my_subs">Οι συνδρομές μου</button></a>
                            <a href="stats.php"><button type="button" name="stats">Στατιστικά</button></a>
                            <a href="../scripts/logout.php"><button type="button" name="logout">Αποσύνδεση</button></a>
                        </div>
                    <?php } ?>    

                    </div>    
                        
                 <?php } else { ?>
                            <div id="buttons">
                                <a href="register.php"><button type="button" name="register">Εγγραφή</button></a>
                                <a href="login.php"><button type="button" name="login">Είσοδος</button></a>
                            </div>
                <?php } ?>
        </div>
        <nav id="top_menu">
            <ul>
                <li><a href="../index.php">Αρχική</a></li>
                <li id="current"><a href="politiki.php">Πολιτική</a></li>
                <li><a href="oikonomia.php">Οικονομία</a></li>
                <li><a href="koinonia.php">Κοινωνία</a></li>
                <li><a href="athlitismos.php">Αθλητισμός</a></li>
                <li><a href="politismos.php">Πολιτισμός</a></li>
                <li><a href="kosmos.php">Κόσμος</a></li>
            </ul>
        </nav>
    </header>

    <div id="categories">
        <section id="content_area">
            <?php 

                //Φέρνουμε σπο τη ΒΔ τα άρθρα που θα εμφανίζονται στην κατηγορία
                include('../scripts/db_connect.php');
                
                $category_id = 2;
            
                //Πρώτα φέρνουμε τα ανοιχτά, τα οποία εμφανίζονται σε όλους.
                $query = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'O' AND `id-κατηγορίας` = '$category_id' ORDER BY `Ημερομηνία Δημοσίευσης` DESC";
                $result = mysqli_query($dbc, $query);

                while($user_rec = mysqli_fetch_row($result)) { 
                
                    $id = $user_rec[0];
                    $title = $user_rec[1];
                    $article_text = $user_rec[2];
                    $publish_date = $user_rec[3];
                    $author_id = $user_rec[4];
                    $availability = $user_rec[5];
                    $category = $user_rec[6];

                    //Βρίσκουμε το όνομα και το επώνυμο του συντάκτη
                    $query_1 = "SELECT * FROM `Συντάκτης` WHERE `id-συντάκτη` = '$author_id'";
                    $result_1 = mysqli_query($dbc, $query_1);
                    $user_rec_1 = mysqli_fetch_row($result_1);
                    
                    //Και τα καταχωρούμε σε μια μεταβλητή
                    $author_name = $user_rec_1[3] . " " . $user_rec_1[4];

                    //Μεταβλητή για την αποθήκευση του ονόματος της κατηγορίας.
                    //Θα χρησιμοποιηθεί για να φτιάξουμε το link στον τίτλο του άρθρου.
                    $category_name = NULL;
                    
                    switch ($category) {
                        case 1:
                            $category_name = "athlitismos";
                            break;
                        case 2:
                            $category_name = "politiki";;
                            break;
                        case 3:
                            $category_name = "oikonomia";;
                            break;
                        case 4:
                            $category_name = "politismos";;
                            break;
                        case 5:
                            $category_name = "koinonia";;
                            break;
                        case 6:
                            $category_name = "kosmos";;
                            break;
                    } ?>
    
                                <article id="category_article">
                                    <!-- Τίτλος άρθρου -->
                                    <h1> <?php echo $title ?> </h1>
                                    
                                    <table id="main_table">
                                        <tr>
                                            <!-- Εικόνα άρθρου. Χρησιμοποιεί δύο στήλες του πίνακα -->
                                            <td rowspan="2" id="logo_col">
                                                <img src="../images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>">
                                            </td>
                                            <!-- Στοιχεία άρθρου (συγγραφέας, ημερομηνία κλπ) -->
                                            <td id="data_col">
                                                <ul>
                                                    <li><?php echo $author_name ?></li>
                                                    <li><?php echo $publish_date ?></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Links για τα social media -->
                                            <td id="social_col">
                                                <a href="https://facebook.com"><img src="../logos/facebook_logo.jpg" height="50" alt="facebook"></a>
                                                <a href="https://twitter.com"><img src="../logos/twitter_logo.png" height="50" alt="twitter"></a>
                                                <a href="https://plus.google.com"><img src="../logos/googleplus_logo.png" height="50" alt="googleplus"></a>
                                            </td>
                                        </tr>
                                    </table>
                                    <p>
                                        <?php echo $article_text ?>
                                    </p>
                                </article>
                                <hr/>
                    
                <?php } ?> 
                
            <?php mysqli_close($dbc); ?>
            
            <?php
            //Αν είναι συνδεδεμένος ο συντάκτης εμφανίζονται και τα κλειστά άρθρα
                if(isset($username)) {
                    
                    include('../scripts/db_connect.php');
                    
                    $category_id = 2;
                    
                    $query_1 = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'C' AND `id-κατηγορίας` = $category_id ORDER BY `Ημερομηνία Δημοσίευσης` DESC";
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
            
                                    <article id="category_article">
                                    <!-- Τίτλος άρθρου -->
                                    <h1> <?php echo $title ?> </h1>
                                    
                                    <table id="main_table">
                                        <tr>
                                            <!-- Εικόνα άρθρου. Χρησιμοποιεί δύο στήλες του πίνακα -->
                                            <td rowspan="2" id="logo_col">
                                                <img src="../images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>">
                                            </td>
                                            <!-- Στοιχεία άρθρου (συγγραφέας, ημερομηνία κλπ) -->
                                            <td id="data_col">
                                                <ul>
                                                    <li><?php echo $author_name ?></li>
                                                    <li><?php echo $publish_date ?></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Links για τα social media -->
                                            <td id="social_col">
                                                <a href="https://facebook.com"><img src="../logos/facebook_logo.jpg" height="50" alt="facebook"></a>
                                                <a href="https://twitter.com"><img src="../logos/twitter_logo.png" height="50" alt="twitter"></a>
                                                <a href="https://plus.google.com"><img src="../logos/googleplus_logo.png" height="50" alt="googleplus"></a>
                                            </td>
                                        </tr>
                                    </table>
                                    <p>
                                        <?php echo $article_text ?>
                                    </p>
                                </article>   
                                <hr/>

                    <?php }
                    
                    mysqli_close($dbc); 
                    
                    } ?>
                
                
                 
            
            <!-- Στη συνέχεια φέρνουμε και τα άρθρα στα οποία ο συνδεδεμένος χρήστης (συνδρομητής) είναι εγγεγραμένος. -->
            <?php 
                include('../scripts/db_connect.php');
                $category_id = 2;
                
                $query_1 = "SELECT * FROM `Άρθρο` WHERE `Πρόσβαση` = 'C' AND `id-κατηγορίας` = '$category_id' ORDER BY `Ημερομηνία Δημοσίευσης` DESC";
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
                                    $category_name = "politiki";;
                                    break;
                                case 3:
                                    $category_name = "oikonomia";;
                                    break;
                                case 4:
                                    $category_name = "politismos";;
                                    break;
                                case 5:
                                    $category_name = "koinonia";;
                                    break;
                                case 6:
                                    $category_name = "kosmos";;
                                    break;
                            } ?>
            
                                <article id="category_article">
                                    <!-- Τίτλος άρθρου -->
                                    <h1> <?php echo $title ?> </h1>
                                    
                                    <table id="main_table">
                                        <tr>
                                            <!-- Εικόνα άρθρου. Χρησιμοποιεί δύο στήλες του πίνακα -->
                                            <td rowspan="2" id="logo_col">
                                                <img src="../images/<?php echo $category_name ?>.jpeg" alt="<?php echo $category_name ?>">
                                            </td>
                                            <!-- Στοιχεία άρθρου (συγγραφέας, ημερομηνία κλπ) -->
                                            <td id="data_col">
                                                <ul>
                                                    <li><?php echo $author_name ?></li>
                                                    <li><?php echo $publish_date ?></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Links για τα social media -->
                                            <td id="social_col">
                                                <a href="https://facebook.com"><img src="../logos/facebook_logo.jpg" height="50" alt="facebook"></a>
                                                <a href="https://twitter.com"><img src="../logos/twitter_logo.png" height="50" alt="twitter"></a>
                                                <a href="https://plus.google.com"><img src="../logos/googleplus_logo.png" height="50" alt="googleplus"></a>
                                            </td>
                                        </tr>
                                    </table>
                                    <p>
                                        <?php echo $article_text ?>
                                    </p>
                                </article>  
                                <hr/>

                    <?php }

                } 

            mysqli_close($dbc); ?>
        </section>


        <aside id="ads">
            <ul>
                <li><a href="#"><img src="../images/ad_1.jpg" alt="ad_1"></a></li>
                <li><a href="#"><img src="../images/ad_2.gif" alt="ad_2"></a></li>
            </ul>
        </aside>
    </div>

    <footer id="website_footer">
        <ul>
            <li><a href="../index.php">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</a>
                <li><a href="#">ΟΡΟΙ ΧΡΗΣΗΣ</a></li>
                <li><a href="#">ΠΡΟΣΤΑΣΙΑ ΠΡΟΣΟΠΙΚΩΝ ΔΕΔΟΜΕΝΩΝ</a></li>
                <li><a href="#">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
            </li>
        </ul>
    </footer>
</body>

</html>
