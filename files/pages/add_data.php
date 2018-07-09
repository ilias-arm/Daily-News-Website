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

        <section id="content_area">
            
            <?php 
            
            //Ελέγχουμε αν τα πεδία ηλικία και φύλο είναι συμπληρωμένα
            $age = $_SESSION['logged_in_age'];
            $sex = $_SESSION['logged_in_sex'];
            
            //Αν είναι και τα δύο τότε δεν μπορούμε να προσθέσουμε άλλα στοιχεία
            //και εμφανίζουμε σχετικό μήνυμα
            if(isset($age) && isset($sex)){
                echo '<html><meta charset="UTF-8"><script language="javascript">alert("Δεν μπορείτε να εισάγετε άλλα στοιχεία! Έχετε ήδη συμπληρώσει ηλικία και φύλο!"); document.location="../pages/edit_my_account.php";</script></html>';
            } else { ?>
                
                <!-- Αλλιώς δημιουργούμε φόρμα για συμπλήρωση όσων στοιχείων λείπουν -->
                <form action="../scripts/add_data.php" method="post">
                
                <h1>Προσθήκη στοιχείων</h1>
                <br>
            
            <!-- Εμφανίζουμε πεδία για συμπλήρωση μόνο για τα στοιχεία που μπορούν να συμπληρωθούν
            Αν και τα δύο είναι κενά, τότε εμφανίζουμε και για τα δύο (ηλικία και φύλο) -->
            
            <?php    if($age == 0) {  ?>
            <table id="register_table">
                <tr id="age_row">
                    <td>Ηλικία</td>
                    <td><input type="text" name="age" value="" id="age"></td>
                </tr>
            </table>
            <br>
            <?php } ?>
            
            <?php     if(empty($sex)) { ?>
            <table id="table">
                <tr id="sex_row">
                   <td id="sex_col">Φύλο</td>
                   <td id="radio_button_row">
                        <ul>
                            <li><input type="radio" name="sex" value="male" id="male"> Άνδρας </li>
                            <li><input type="radio" name="sex" value="female" id="female"> Γυναίκα </li>
                        </ul> 
                    </td>
                </tr>
            </table>
            <br>
            <?php    } ?>

                <div id="form_button">
                    <button type="submit">Υποβολή</button>
                    <button type="reset">Αρχικοποίηση</button>
                </div>
                    
            </form>
                
            <?php } ?>

        </section>

        <aside id="ads">
            <ul>
                <li><a href="#"><img src="../images/ad_1.jpg" alt="ad_1"></a></li>
                <li><a href="#"><img src="../images/ad_2.gif" alt="ad_2"></a></li>
            </ul>
        </aside>

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