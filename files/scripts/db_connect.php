<?php 
    
    //Ορίζουμε ως σταθερές (constant) τις παραμέτρους που χρειαζόμαστε για τη σύνσεση στη ΒΔ
    DEFINE ('DB_USER', 'root');
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_NAME', 'armatas_db');
    
    //Μεταβλητή για τη σύνδεση με τη ΒΔ. Σε περίπτωση σφάλματος τερματίζει εμφανίζοντας σχετικό μήνυμα
    $dbc = @mysqli_connect(DB_HOST, DB_USER) or die("Cannot connect to the database");
    
    //Για τη σωστή αποθήκευση ελληνικών χαρακτήρων στα πεδία των πινάκων της βάσης δεδομένων
    @mysqli_set_charset($dbc, "utf8"); 

    //Επιλογή της βάσης δεδομένων. Σε περίπτωση που δεν υπάρχει η βάση, τερματίζει εμφανίζοντας σχετικό μήνυμα
    @mysqli_select_db($dbc,DB_NAME) or die("Database doesn't exist");

?>
