<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Express news!</title>
    
    <link rel="stylesheet" href="../css/myCss.css">

</head>
<?php session_start(); ?>
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

                //Ελέγχουμε αν ο χρήστης είναι εγγεγραμένο μέλος (συνδρομητής ή συντάκτης) ή επισκέπτης
                $id = $_SESSION['logged_in_id'];
                
                //Θα χρησιμοποιήσουμε τη μεταβλητή για να ελέγχουμε αν ο χρήστης είναι συντάκτης ή συνδρομητής
                //Αν είναι συνδρομητής εμφανίζεται το κουμπί "ο λογαριασμός μου", όπου επιτρέπεται η
                //επεξεργασία των στοιχείων του. Αν είναι συντάκτης εμφανίζεται το κουμπί "τα άρθρα μου", 
                //όπου επιτρέπεται η επξεργασία των άρθρων του.
                $username = $_SESSION['logged_in_username'];
                
                //Αν ισχύει τότε είναι συνδρομητής
                if(isset($id)) { ?>
                    <div id="buttons">
                    <?php 
                        //Αν ισχύει τότε είναι συντάκτης
                        if(isset($username)) {  ?>
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
                <li><a href="politiki.php">Πολιτική</a></li>
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
            
            <!-- Παίρνουμε τα στοιχέια του άρθρου που επέλεξε ο συντάκτης στη σελίδα "edit_my_articles" -->
            <?php 
            
            $selected_article_id = $_SESSION['selected_article_id'];
            $title = $_SESSION['selected_title'];
            $article_text = $_SESSION['selected_article_text'];
            $publish_date = $_SESSION['selected_publish_date'];
            $availability = $_SESSION['selected_availability'];
            $category = $_SESSION['selected_category'];
            
            ?>
            
            <!-- Δημιουργούμε φόρμα για την αλλαγή των στοιχέιων του άρθρου -->
            <form action="../scripts/change_article.php" method="post">
                
                <h1>Αλλαγή άρθρου</h1>
                
                <table id="register_table">
                        <tr height = 20px></tr>
                        <tr>
                            <td><strong>Τίτλος</strong></td>
                            <td><?php echo $title; ?></td>
                        </tr>
                        <tr>
                            <td>Νέος τίτλος</td>
                            <td><input type="text" name="new_title" id="new_title"> </br> </td>
                        </tr>
                        <tr height = 20px></tr>
                        <tr>
                            <td><strong>Κέιμενο</strong></td>
                            <td><?php echo $article_text; ?></td>
                        </tr>
                        <tr>
                            <td>Νέο κειμενο</td>
                            <td><textarea name="new_article_text" rows="15" cols="60"></textarea></td>
                        </tr>
                        <tr height = 20px></tr>
                        <tr>
                            <td><strong>Ημερομηνία δημοσίευσης</strong></td>
                            <td><?php echo $publish_date; ?></td>
                        </tr>
                        <tr>
                            <td>Νέα ημερομηνία δημοσίευσης</td>
                            <td><input type="date" name="new_publish_date" id="new_publish_date"></td>
                        </tr>
                        <tr height = 20px></tr>
                        <tr>
                            <td><strong>Κατηγορία</strong></td>
                            <td>
                            <!-- Φέρνουμε απο τη ΒΔ το όνομα της κατηγορίας που ανήκει το άρθρο -->
                            <?php 
                                include ('../scripts/db_connect.php');
                            
                                $query = "SELECT * FROM `Κατηγορία άρθρου` WHERE `id-κατηγορίας` = '$category'";
                                $result = mysqli_query($dbc, $query);
                                $user_rec = mysqli_fetch_row($result);
                                echo $category_name = $user_rec[1];
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Νέα κατηγορία</td>
                            <td>
                            <!-- Δημιουργούμε drop down list με τα ονόματα των κατηγοριών -->    
                            <?php
                                include('../scripts/db_connect.php');
                                $query = "SELECT * FROM `Κατηγορία άρθρου`";
                                $result = mysqli_query($dbc, $query);
                            ?>
                            <select name="new_category">
                                <option selected disabled>Επιλέξτε κατηγορία</option>
                                <?php while($user_rec = mysqli_fetch_row($result)) { ?>
                                <option value="<?php echo $user_rec[0] ?>"><?php echo $user_rec[1] ?></option>
                                <?php } ?>
                            </select>
                            </td>
                        </tr>
                        <tr height = 20px></tr>
                        <tr>
                            <td><strong>Προσβασιμότητα</strong></td>
                            <td>
                                <?php
                                if($availability == "O") {
                                    echo 'Ελεύθερο για όλους';
                                } else if($availability == "C") {
                                    echo 'Μόνο για συνδρομητές'; } 
                                ?>
                            </td>
                        </tr>
                        <tr id="radio_button_row">
                            <td>Νέα προσβασιμότητα</td>
                            <td>
                                <ul>
                                    <li><input type="radio" name="new_availability" value="open" id="open"> Ελέύθερο για όλους </li>
                                    <li><input type="radio" name="new_availability" value="only_members" id="only_members"> Μόνο για συνδρομητές </li>
                                </ul> 
                            </td>
                        </tr>
                </table>
                
                <div id="form_buttons">
                    <button type="submit">Υποβολή</button>
                    <button type="reset">Αρχικοποίηση</button>
                </div>
            </form>

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
