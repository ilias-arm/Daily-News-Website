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
            
            <!-- Κατηγορίες που έιναι εγγεγραμένος ο συνδρομητής -->
            <div id="my_subs">
                
                <h3>Οι συνδρομές μου</h3>
                <br>
                
                <table id="categories_table">
                    <tr>
                        <th>    
                            Κατηγορία
                        </th>
                        <th>
                            Κόστος
                        </th>
                    </tr>

                <?php
                
                session_start();
                
                $id = $_SESSION['logged_in_id'];

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

                ?>
                        <tr>
                            <td>
                                <?php echo $category_name ?>
                            </td>
                            <td>
                                <?php echo $cost ?>
                            </td>
                        </tr>                    
                        
                <?php }
                    
                    
                } ?>
                    
                 </table> 
                 <br>
                 <p>Συνολικό μηνιαίο κόστος: <strong><?php echo $total_cost ?></strong></p>
                
                <?php mysqli_close($dbc); ?>
                
            </div>    

            <!-- Κατηγορίες στις οποίες δεν είναι εγγεγραμένος ο συνδρομητής -->
            <div id="available_categories">
                
                <h3>Διαθέσιμες κατηγορίες για συνδρομή</h3>
                <br>
                
                <table id="categories_table">
                    <tr>
                        <th>    
                            Κατηγορία
                        </th>
                        <th>
                            Κόστος
                        </th>
                    </tr>
                    
                
                <?php
                
                session_start();
                
                $id = $_SESSION['logged_in_id'];

                include('../scripts/db_connect.php');
                
                //Επιλέγουμε τις κατηγορίες που είναι εγγεγραμένος ο χρήστης
                //για να τις εμφανίσουμε μαζί με το κόστος τους σε μορφή πίνακα
                $query = "SELECT * FROM `Κατηγορία άρθρου`
                          WHERE `id-κατηγορίας` NOT IN
                                                    (SELECT `id-κατηγορίας` 
                                                    FROM `Συνδρομητής επιλέγει κατηγορίες`
                                                    WHERE `id-συνδρομητή` = '$id')";
                                                
                $result = mysqli_query($dbc, $query);
                
                if ($result == 0) {
		            echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν είστε εγγεγραμένος σε καμία κατηγορία!"); document.location="../pages/register.html";</script></html>';
                } else { 
                
                    while($user_rec = mysqli_fetch_row($result)) { 
                        
                    $category_name = $user_rec[1];
                    $cost = $user_rec[2];

                ?>
                        <tr>
                            <td>
                                <?php echo $category_name ?>
                            </td>
                            <td>
                                <?php echo $cost ?>
                            </td>
                        </tr>                    
                        
                <?php }
                    
                    
                } ?>
                    
                 </table> 
                
                <?php mysqli_close($dbc); ?>
                
            </div> 

            <!-- Φόρμα οπου οσ υνδρομητής μπορεί να επιλέξει μία ή περισσότερες
            κατηγορίες για να εγγραφεί -->
            <form id="add_subscribe" method="post">
                
                <h3>Συνδρομή</h3>
                <br>
                <?php

                include('../scripts/db_connect.php');
                
                //Επιλέγουμε τις κατηγορίες που δεν είναι εγγεγραμένος ο χρήστης
                //για να τις εμφανίσουμε στην παρακάτω drop down list
                $query = "SELECT * FROM `Κατηγορία άρθρου`
                          WHERE `id-κατηγορίας` NOT IN
                                                    (SELECT `id-κατηγορίας` 
                                                    FROM `Συνδρομητής επιλέγει κατηγορίες`
                                                    WHERE `id-συνδρομητή` = '$id')";
                
                $result = mysqli_query($dbc, $query);

                ?>

                <select multiple style="width: 200px; height: 200px;" id="category_drop_down_menu" name="category_drop_down_menu[]">
                    <option disabled selected>Επιλέξτε κατηγορία/ες</option>
                    <?php while($user_rec = mysqli_fetch_row($result)) { ?>
                        <option value="<?php echo $user_rec[0] ?>"><?php echo $user_rec[1]?></option>
                    <?php } ?>
                </select>

                <?php mysqli_close($dbc); ?> 
                <br>
                <br>
                <!-- Πατώντας το κουμπί εμαφανίζεται νέα φόρμα όπου έχει υπολογισμένο το νέο κόστος,
                όπως αυτό προκύπτει απο την επιλογή της κατηγορίας που έκανε -->
                <button type="submit" id="calculate_cost_submit" name="calculate_cost_submit" formaction="">Υπολογισμός κόστους</button>
                <br>
                <br>
                <!-- Πατώντας το κουμπί, πραγματοποιείται συνδρομή στην επιλεγμένη/ες κατηγορία/ες -->
                <button type="submit" name="add_sub_submit" id="add_sub_submit" formaction="../scripts/add_subscribe.php">Συνδρομή</button>
            
            </form>
            
            <!-- Κατάργηση της συνδρομής ή των συνδρομών που επέλεξε ο χρήστης -->
            <form id="delete_subscribe" action="../scripts/delete_subscribe.php" method="post">
                
                <h3>Κατάργηση συνδρομής</h3>
                <br>
                
                <?php

                include('../scripts/db_connect.php');
                
                //Επιλέγουμε τις κατηγορίες που δεν είναι εγγεγραμένος ο χρήστης
                //για να τις εμφανίσουμε στην παρακάτω drop down list
                $query = "SELECT * FROM `Κατηγορία άρθρου`
                          WHERE `id-κατηγορίας` IN
                                                (SELECT `id-κατηγορίας` 
                                                FROM `Συνδρομητής επιλέγει κατηγορίες`
                                                WHERE `id-συνδρομητή` = '$id')";
                
                $result = mysqli_query($dbc, $query);

                ?>

                <select multiple style="width: 200px; height: 200px;" id="category_drop_down_menu" name="category_drop_down_menu[]">
                    <option disabled selected>Επιλέξτε κατηγορία/ες</option>
                    <?php while($user_rec = mysqli_fetch_row($result)) { ?>
                        <option value="<?php echo $user_rec[0] ?>"><?php echo $user_rec[1]?></option>
                    <?php } ?>
                </select>

                <?php mysqli_close($dbc); ?> 
                <br>
                <br>
                <button type="submit" id="delete_subscribe_submit" name="delete_subscribe_submit">Κατάργηση</button>

            </form> 
            
            <!-- Η φόρμα δημιουργείται μόνο όταν ο χρήστης επιλέξει "Υπολογισμός κόστους" -->
            <form id="selected_categories">
                    
                    <?php if(isset($_POST['calculate_cost_submit'])) { 
                    
                    
                        if(isset($_POST['category_drop_down_menu'])) { ?>
                    
                            <div id="calculated_infos">
                            
                            <p><strong>Έχετε επιλέξει τις κατηγορίες</strong></p>
                            
                            <?php
    
                            foreach ($_POST['category_drop_down_menu'] as $selectedOption) {
    
                                $category_id = $selectedOption;
                                
                                include('../scripts/db_connect.php');
                                
                                //Φέρνουμε απο τη ΒΔ την επιλεγμένη κατηγορία άρθρου
                                $query = ("SELECT * FROM `Κατηγορία άρθρου` WHERE `id-κατηγορίας` = '$category_id'");
                                $result = mysqli_query($dbc, $query);
                                
                                
                                while($user_rec = mysqli_fetch_row($result)) {
                                //Και επιλέγουμε το όνομα
                                $category_name = $user_rec[1];
                                //Και το κόστος της κατηγορίας
                                $category_cost = $user_rec[2];
                                
                                $new_total_cost += $category_cost;
                                
                                ?>
                                
                                    <ul id="calculated_list">
                                        <li>
                                        <?php echo $category_name ?>
                                        </li>
                                    </ul>
                                
                                <?php } ?>
                                
                            <?php } ?>
                                <br>
                                <p><strong>Με τις επιλεγμένες κατηγορίες, το νέο συνολικό κόστος των συνδρομών σας είναι: </strong><?php echo $new_total_cost + $total_cost ?><p>
                       
                            <?php } else {
                                
		                        echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν έχετε επιλέξει κατηγορία!");</script></html>';

                            }
                        }
                        
                        ?>
                 
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
