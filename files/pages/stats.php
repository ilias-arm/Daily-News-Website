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
            
            <!-- Εμφανίζεται σε όλους τους εγγεγραμένους χρήστες (συντάκτες και συνδρομητές) η δημοφιλέστερη κατηγορία. -->
            <?php 
            
                include('../scripts/db_connect.php');
                
                //Μεταβλητή για την αποθήκευση της δημοφιλέστερης κατηγορίας
                $most_poular;
                
                //Φέρνουμε απο τη ΒΔ όλες τις συνδρομές, καταταγμένες σε φθίνουσα σειρά. 
                $query = "SELECT `id-κατηγορίας`, COUNT(`id-κατηγορίας`) FROM `Συνδρομητής επιλέγει κατηγορίες` GROUP BY `id-κατηγορίας` ORDER BY COUNT(`id-κατηγορίας`) DESC";
                $result = mysqli_query($dbc, $query);

                while($user_rec = mysqli_fetch_row($result)) { 
                
                    //Το id της κατηγορίας
                    $category_id = $user_rec[0];
                    //Ο αριθμός των συνδρομών της κατηγορίας
                    $count = $user_rec[1];
                
                    //Βρίσκουμε τον τίτλο της κατηγορίας, για να τον εμφανίσουμε παρακάτω
                    $query_1 = "SELECT * FROM `Κατηγορία άρθρου` WHERE `id-κατηγορίας` = '$category_id'";
                    $result_1 = mysqli_query($dbc, $query_1);
                    $user_rec_1 = mysqli_fetch_row($result_1);
                    
                    //Και τον καταχωρούμε σε μια μεταβλητή
                    $category_name = $user_rec_1[1];
                    
                    //Αποθηκεύουμε το όνομα της δημοφιλέστερης κατηγορίας
                    if($count > $most_poular) {
                        $most_poular = $category_name;
                    }

                    ?>
                    
                <?php } ?> 
                
                <br>
                <p id="most_popular_category">Η πιο δημοφιλής κατηγορία είναι: <strong><?php echo $most_poular ?></strong></p>
                
            <?php mysqli_close($dbc); ?>
            
            
            <!-- Αν είναι συνδεδεμένος ο συντάκτης εμφανίζονται και τα παρακάτω στατιστικά -->
            <?php
            
                //Αν έχει username τότε είναι συντάκτης
                if(isset($_SESSION['logged_in_username'])) { ?>
                    
                        <div id="category_stats">
                    
                        <h3>Στατιστικά κατηγοριών</h3>
                        <br>
                        
                        <table id="categories_table">
                            <tr>
                                <th>    
                                    Κατηγορία
                                </th>
                                <th>
                                    Αριθμός ενεργών συνδρομών
                                </th>
                                <th>
                                    Συνολικό κέρδος
                                </th>
                            </tr>
        
                    <?php 
                    
                        //Συνολικός αριθμός συνδρομών
                        $total_subs = 0;
                        
                        //Συνολικό κέρδος απο όλες τις συνδρομές
                        $total_profit = 0;
                    
                        include('../scripts/db_connect.php');
                        
                        //Φέρνουμε απο τη ΒΔ όλες τις συνδρομές, καταταγμένες σε φθίνουσα σειρά. 
                        $query = "SELECT `id-κατηγορίας`, COUNT(`id-κατηγορίας`) FROM `Συνδρομητής επιλέγει κατηγορίες` GROUP BY `id-κατηγορίας` ORDER BY COUNT(`id-κατηγορίας`) DESC";
                        $result = mysqli_query($dbc, $query);
        
                        while($user_rec = mysqli_fetch_row($result)) { 
                        
                            //Το id της κατηγορίας
                            $category_id = $user_rec[0];
                            //Ο αριθμός των συνδρομών της κατηγορίας
                            $sub_count = $user_rec[1];
                            
                            //Συνολικές συνδρομές
                            $total_subs += $sub_count;
                            
                            //Βρίσκουμε τον τίτλο της κατηγορίας, για να τον εμφανίσουμε παρακάτω
                            $query_1 = "SELECT * FROM `Κατηγορία άρθρου` WHERE `id-κατηγορίας` = '$category_id'";
                            $result_1 = mysqli_query($dbc, $query_1);
                            $user_rec_1 = mysqli_fetch_row($result_1);
                            
                            //Και τον καταχωρούμε σε μια μεταβλητή
                            $category_name = $user_rec_1[1];
                            
                            //Το κόστος της κατηγορίας
                            $cost = $user_rec_1[2];
 
                            //Το συνολικό κέρδος ανα κατηγορία. Προκύπτει απο τον πολλ/σμό του κόστους
                            //της κατηγορίας ($cost) και του αριθμού των συνδρομών της κατηγορίας ($count)
                            $profit = $sub_count * $cost;
                            
                            //Συνολικό κέρδος
                            $total_profit += $profit;

                            ?>
                            
                                <tr>
                                    <td>
                                        <?php echo $category_name ?>
                                    </td>
                                    <td>
                                        <?php echo $sub_count ?>
                                    </td>
                                    <td>
                                        <?php echo $profit ?>
                                    </td>
                                </tr> 
                                    
                        <?php } ?> 
                        
                    
                        </table>
                        <br>
                        <br>
                        <p>Οι συνολικές συνδρομές είναι: <strong><?php echo $total_subs ?></strong></p>
                        <br>
                        <p>Το συνολικό κέρδος απο όλες τις συνδρομές είναι: <strong><?php echo $total_profit ?></strong></p>

                    </div>    
                

                    <?php mysqli_close($dbc); 
                    
                    } ?>
            
            <!-- Αν είναι συνδεδεμένος ο συνδρομητής εμφανίζονται και τα παρακάτω στατιστικά -->
            
            <?php
            //Αν έχει email τότε είναι συνδρομητής
            if(isset($_SESSION['logged_in_email'])) {

                include('../scripts/db_connect.php');
                    
                //Επιλέγουμε τις κατηγορίες που είναι εγγεγραμένος ο χρήστης
                //για να τις εμφανίσουμε μαζί με το κόστος τους σε μορφή πίνακα
                $query = "SELECT * FROM `Κατηγορία άρθρου`
                            WHERE `id-κατηγορίας` IN
                                                (SELECT `id-κατηγορίας` 
                                                FROM `Συνδρομητής επιλέγει κατηγορίες`
                                                WHERE `id-συνδρομητή` = '$id')";
                                                    
                $result = mysqli_query($dbc, $query);
                    
                //Μεταβλητή για την αποθήκευση του συνολικού κόστους των συνδρομών του χρήστη
                $total_cost = 0;
                
                if ($result == 0) {
		            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν είστε εγγεγραμένος σε καμία κατηγορία!"); document.location="../pages/register.html";</script></html>';
                 } else { 
                        
                    while($user_rec = mysqli_fetch_row($result)) { 
                            
                    $category_name = $user_rec[1];
                    $cost = $user_rec[2];
                    $total_cost += $cost;
                            
                    }
                        
                    //Το συνολικό ετήσιο κόστος του συνδρομητή υπολογίζεται πολλαπλασιάζοντας το
                    //συνολικό μηνιαίο κόστος του με το 12 (όσοι οι μήνες του χρόνου)
                    $annual_total_cost = $total_cost * 12;
                        
                    ?>
                <div id="my_subs">   
                <p>Το μηνιαίο κόστος για όλες τις συνδρομές σας είναι: <strong><?php echo $total_cost ?></strong>
                <br>
                <br>
                <p>Το συνολικό ετήσιο κόστος είναι: <strong><?php echo $total_cost . " * 12 = " . $annual_total_cost ?></strong></p>
                </div>    
                <?php mysqli_close($dbc);   
    
                }
                    
            } ?>  
           
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
