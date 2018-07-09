//Έλεγχος αν το email περιλαμβάνει το σύμβολο @
function checkEmail(){
    
    if(!document.getElementById('email').value.includes("@")) {
        alert("Παρακαλώ συμπληρώστε μια έγκυρη διεύθυνση email");
        
        document.getElementById('email').style.borderColor = "red";
        document.getElementById('email').value = '';
        document.getElementById('email').focus();
        
        return false;
    }
    
}

//Έλεγχος αν ο χρήστης πληκτρολόγησε τον ίδιο κωδικό και στο πεδίο "Κωδικός" και
//στο πεδίο "Επιβεβαίωση κωδικού"
function checkConfirmPassword(){
            
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
            
        if(password != confirmPassword) {
            alert("Παρακαλώ επιβεβαιώστε σωστά τον κωδικό σας!");
            
            document.getElementById('password').style.borderColor = "red";
            document.getElementById('confirm_password').style.borderColor = "red";
            document.getElementById('password').value = '';
            document.getElementById('confirm_password').value = '';
            document.getElementById('password').focus();
            
            return false;
        }
}

//Έλεγχος γαι το ελάχιστος μήκος κωδικού
function checkPasswordLength(){
            
    //Στην περιπτωσή μας ορίζεται στους 8 χαρακτήρες.
    var minLength = 8;
    //Ο κωδικός που πληκτρολόγησε ο χρήστης
    var password = document.getElementById('password').value;
            
        if(password.length < minLength) {
            alert("Ο κωδικός σας πρέπει να αποτελείται απο τουλάχιστον 8 χαρακτήρες");
            
            document.getElementById('password').style.borderColor = "red";
            document.getElementById('password').value = '';
            document.getElementById('password').focus();
            
            return false;
        }
        
}

//Έλεγχος για την ύπαρξη κενών πεδίων στη φόρμα εγγραφής (register)        
function checkForEmptyFields(){

    var errorMessage = "";
            
        if(document.getElementById('fname').value == ""){
            errorMessage += "Παρακαλώ συμπληρώστε το όνομα σας! \n"
            document.getElementById('fname').style.borderColor = "red";
        }
        if(document.getElementById('lname').value == ""){
            errorMessage += "Παρακαλώ συμπληρώστε το επώνυμο σας! \n"
            document.getElementById('lname').style.borderColor = "red";
        }
        if(document.getElementById('email').value == ""){
            errorMessage += "Παρακαλώ συμπληρώστε το email σας! \n"
            document.getElementById('email').style.borderColor = "red";
        }
        if(document.getElementById('password').value == ""){
            errorMessage += "Παρακαλώ συμπληρώστε τον κωδικό σας! \n"
            document.getElementById('password').style.borderColor = "red";
        }
        if(document.getElementById('confirm_password').value == ""){
            errorMessage += "Παρακαλώ συμπληρώστε την επιβεβαίωση του κωδικού σας! \n"
            document.getElementById('confirm_password').style.borderColor = "red";
        }
        if(errorMessage != ""){
            alert(errorMessage);
            return false;
        }
}
