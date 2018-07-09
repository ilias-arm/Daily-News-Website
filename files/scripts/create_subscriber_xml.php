<?php 
                //Όλα τα παρακάτω queries μας επιστρέφουν τα αποτελέσματα ταξινομημένα με αλφαβητική σειρά των συνδρομητών
            
                $dom = new DomDocument("1.0", "UTF-8");

                // Δημιουργία κεφαλίδας όπου αναφέρουμε το εξωτερικό DTD αρχείο για το validation του xml
                $implementation = new DOMImplementation();

                $dom->appendChild($implementation->createDocumentType('lista_sindromiti SYSTEM "../scripts/xml_sindromitis.dtd"'));
                
                //Δημιουργούμε το root element, το οποίο είναι το "lista_sindromiti"
                $root = $dom->appendChild($dom->createElement('lista_sindromiti'));
                            
                //Σύνδεση με τη ΒΔ                
                include('../scripts/db_connect.php');
                
                //Query που εμφανίζει τα στοιχεία των συνδρομητών που έχουν κάνει συνδρομή σε μία ή περισσότερες κατηγορίες.
                $query1 = "SELECT DISTINCT s.`id-συνδρομητή`, s.`Όνομα`, s.`Επώνυμο`, s.`E-mail`, s.`Password`, s.`Ηλικία`, s.`Φύλο` 
                          FROM `Συνδρομητής επιλέγει κατηγορίες` se 
                          JOIN `Συνδρομητής` s ON se.`id-συνδρομητή` = s.`id-συνδρομητή`
                          ORDER BY s.`Επώνυμο`, s.`Όνομα`";
                $result1 = mysqli_query($dbc, $query1);
                
                //Για όλους τους συνδρομητές
                while($user_rec1 = mysqli_fetch_row($result1)) { 

                    //Δημιουργία των elements που αφορούν τα στοιχεία του συνδρομητή

                    $sindromitis = $dom->createElement("sindromitis");
                    $root->appendChild($sindromitis);
                
                    $stoixeia_sindromiti = $dom->createElement("stoixeia_sindromiti");
                    $sindromitis->appendChild($stoixeia_sindromiti);
            
                    $id_sindromiti = $dom->createElement("id_sindromiti", $user_rec1[0]);
                    $stoixeia_sindromiti->appendChild($id_sindromiti);
                
                    $onoma = $dom->createElement("onoma", $user_rec1[1]);
                    $stoixeia_sindromiti->appendChild($onoma);
                    
                    $eponimo = $dom->createElement("eponimo", $user_rec1[2]);
                    $stoixeia_sindromiti->appendChild($eponimo);
                    
                    $email = $dom->createElement("email", $user_rec1[3]);
                    $stoixeia_sindromiti->appendChild($email);
                    
                    $kodikos = $dom->createElement("kodikos", $user_rec1[4]);
                    $stoixeia_sindromiti->appendChild($kodikos);
                    
                    $ilikia = $dom->createElement("ilikia", $user_rec1[5]);
                    $stoixeia_sindromiti->appendChild($ilikia);
                    
                    $filo = $dom->createElement("filo", $user_rec1[6]);
                    $stoixeia_sindromiti->appendChild($filo);
                    
                    //Query που εμφανίζει τα στοιχεία των κατηγοριών που έχει κάνει συνδρομή ο συνδρομητής
                    $query2 = "SELECT k.`id-κατηγορίας`, k.`Τίτλος`, k.`Κόστος` 
                              FROM `Συνδρομητής επιλέγει κατηγορίες` se 
                              JOIN `Συνδρομητής` s ON se.`id-συνδρομητή` = s.`id-συνδρομητή`
                              JOIN `Κατηγορία άρθρου` k ON se.`id-κατηγορίας` = k.`id-κατηγορίας`
                              WHERE s.`id-συνδρομητή` = $user_rec1[0]
                              ORDER BY s.`Επώνυμο`, s.`Όνομα`";
                    $result2 = mysqli_query($dbc, $query2);
                    
                    //Για όλες τις κατηγορίες του κάθε συνδρομητή
                    while($user_rec2 = mysqli_fetch_row($result2)) { 
                        
                        //Δημιουργία των elements που αφορούν τα στοιχεία των συνδρομών
                    
                        $sindromi = $dom->createElement("sindromi");
                        $sindromitis->appendChild($sindromi);
                        
                        $katigories_sindromiti = $dom->createElement("katigories_sindromiti");
                        $sindromi->appendChild($katigories_sindromiti);
                        
                        $stoixeia_katigorias = $dom->createElement("stoixeia_katigorias");
                        $katigories_sindromiti->appendChild($stoixeia_katigorias);
                        
                        $id_katigorias = $dom->createElement("id_katigorias", $user_rec2[0]);
                        $stoixeia_katigorias->appendChild($id_katigorias);
                        
                        $titlos = $dom->createElement("titlos", $user_rec2[1]);
                        $stoixeia_katigorias->appendChild($titlos);
                        
                        $kostos = $dom->createElement("kostos", $user_rec2[2]);
                        $stoixeia_katigorias->appendChild($kostos);
                        
                        //Query που εμφανίζει το συνολικό μηνιαίο κόστος του συνδρομητή
                        $query3 = "SELECT SUM(k.`Κόστος`)
                                  FROM `Συνδρομητής επιλέγει κατηγορίες` se 
                                  JOIN `Συνδρομητής` s ON se.`id-συνδρομητή` = s.`id-συνδρομητή`
                                  JOIN `Κατηγορία άρθρου` k ON se.`id-κατηγορίας` = k.`id-κατηγορίας`
                                  WHERE s.`id-συνδρομητή` = $user_rec1[0]
                                  GROUP BY s.`id-συνδρομητή`
                                  ORDER BY s.`Επώνυμο`, s.`Όνομα`";
                        $result3 = mysqli_query($dbc, $query3);
                    }
                    
                    while($user_rec3 = mysqli_fetch_row($result3)) { 
                        
                        //Δημιουργία των elements που αφορούν ταο ετήσιο κόστος
                    
                        $etisio_kostos = $dom->createElement("etisio_kostos");
                        $sindromitis->appendChild($etisio_kostos);
                            
                        //Για τον υπολογισμό του ετήσιου κόστους πολλαπλασιάζουμε το μηνιαίο κόστος με το 12.    
                        $timi = $dom->createElement("timi", ($user_rec3[0]*12));
                        $etisio_kostos->appendChild($timi);
                    }
                
                }
                
                //Εμφάνιση σε μορφή xml
                $dom->formatOutput = true;
                
                //Θέτουμε στη μεταβλητή final_xml το xml που παράξαμε σε μορφή string
                $final_xml = $dom->saveXML();
                
?>