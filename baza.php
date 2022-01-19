
<?php

    class bazaDB { 
            const ime_hosta = 'localhost'; 
            const korisnik = 'root'; 
            const sifra = ''; 
            const ime_baze = "press"; 
            
            public $dbh; 
            function __construct() 
            { 
                try 
                { 
                    $konekcioni_string="mysql:host=".self::ime_hosta.";dbname=".self::ime_baze; 
                $this->dbh = new PDO($konekcioni_string, self::korisnik, self::sifra); 
                
                } catch(PDOException $e) { echo "GRESKA: "; echo $e->getMessage(); } 
                
            } 
            function __destruct() {
                $this->dbh = null; 
                
            }
            
            //----- prikaz
            
            public function dajkategorije()
            {
                $rez = $this->dbh->query(
                "SELECT * FROM kategorija"
                );
                $niz = $rez->fetchAll(PDO::FETCH_ASSOC);
                foreach($niz as $kategorija)
                {
                    echo "<li class='kategorijeLista'><a href='prikaz.php?opcija=prikaz&idKategorije=".$kategorija['id']."'>".$kategorija['naziv']."</a></li> ";
                }
            }
            
            public function dajSveNovinare() {
                $rez = $this->dbh->query(
                "SELECT * FROM novinar"
                );
                $niz = $rez->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<div class='column left'><div class='novinar'>";
            
                if($niz != null)
                {
                    echo "<p>Spisak novinara koji su objavljivali vesti:</p>";
                    echo "<ul class='novinari'>";
                    foreach($niz as $novinarK)
                    {    
                        echo "<li class='novinarLista'><a href='prikaz.php?opcija=prikaz&idNovinara=".$novinarK['id']."'>".$novinarK['ime']." ".$novinarK['prezime']."</a> </li>";
                    }
                    echo "</ul>";
                }
                echo "</div></div>";
            }
            
            public function dajSveVesti()
            {
                $rezSVE = $this->dbh->query(
                    "SELECT * FROM vesti v join "
                    . "novinar n on v.novinar_id=n.id join "
                    . "kategorija k on k.id=v.kategorija_id"
                );
                $nizSVE = $rezSVE->fetchAll(PDO::FETCH_ASSOC);
                $this->stampajVesti($nizSVE);
            }
            
            public function stampajVesti($niz)
            {
                echo "<div class='column right'>";
                foreach($niz as $vesti)
                {
                    echo "<div class='vest'>";
                    echo "<h1 style='color:blue'>".$vesti['naslov']."</h1>";
                    echo "<p style='font-size: 12px;color:blue'><b style='color:red'>".$vesti['ime']." ".$vesti['prezime'];
                    echo "</b> - ".$vesti['godina']." - <b style='color:red'>".$vesti['naziv']."</b></p>";

                    echo "<p>".$vesti['opis']."</p>";
                    echo "</div></br>";
                }
                echo "</div>";
            }
            
            public function dajNovinareKat($idKategorije)
            {
                try{
                    $rez2 = $this->dbh->query(
                    "SELECT * FROM kategorija WHERE id = $idKategorije"
                    );
            
                    $niz2 = $rez2->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<div class='column left'><div class='novinar'>";
                    echo "<p>Spisak novinara koji su objavljivali vesti cija je kategorija ".$niz2[0]['naziv'].":</p>";

                    //prikazujemo novinare za tu kategoriju
                    $rezN = $this->dbh->query(
                            "SELECT DISTINCT(novinar_id),n.id,ime,prezime FROM vesti v join novinar n on v.novinar_id=n.id "
                            . "WHERE v.kategorija_id=$idKategorije"
                            );

                    $nizN = $rezN->fetchAll(PDO::FETCH_ASSOC);

                    echo "<ul class='novinari'>";
                    foreach($nizN as $novinarK)
                    {
                        echo "<li class='novinarLista'><a href='prikaz.php?opcija=prikaz&idKategorije=".$idKategorije."&idNovinara=".$novinarK['id']."'>".$novinarK['ime']." ".$novinarK['prezime']."</a> </li>";
                    }
                    echo "</ul></div></div>";  
                } catch (Exception $ex) {

                }
            }
            
            public function dajVestiNovinara($idNovinara) {
                $rezV = $this->dbh->query(
                    "SELECT * FROM vesti v join "
                    . "novinar n on v.novinar_id=n.id join "
                    . "kategorija k on k.id=v.kategorija_id "
                        . "WHERE novinar_id=$idNovinara"
                    );
            
                $nizVestiNovinara = $rezV->fetchAll(PDO::FETCH_ASSOC);
                $this->stampajVesti($nizVestiNovinara);
            }
            public function dajVestiNovinaraKategorija($idKategorije,$idNovinara) 
            {
                $rezV = $this->dbh->query(
                    "SELECT * FROM vesti v join "
                    . "novinar n on v.novinar_id=n.id join "
                    . "kategorija k on k.id=v.kategorija_id "
                        . "WHERE kategorija_id=$idKategorije AND novinar_id=$idNovinara"
                    );
            
                $nizVestiNovKat = $rezV->fetchAll(PDO::FETCH_ASSOC);
                $this->stampajVesti($nizVestiNovKat);
            }
            
            public function dajSveVestiPoKategoriji($idKategorije) {
                
                $rezV = $this->dbh->query(
                        "SELECT * FROM vesti v join kategorija k on v.kategorija_id=k.id "
                        ."join novinar n on n.id=v.novinar_id "
                        ."WHERE v.kategorija_id=$idKategorije "
                    );
                $nizVestiKat = $rezV->fetchAll(PDO::FETCH_ASSOC);
                $this->stampajVesti($nizVestiKat);
            }
            
            
            //-------------
            public function unesiKategoriju($naziv) {
                try {
                    $this->dbh->query("INSERT INTO kategorija(naziv) "
                    . "VALUES('$naziv')");
                    
                    return true;
            } catch (Exception $ex) {
                return false;
                }
            }
            
            //---------------
            public function unesiNovinara($ime,$prezime,$adresa) {
                try {
                    $this->dbh->query("INSERT INTO novinar(ime, prezime, adresa) "
                    . "VALUES('$ime','$prezime','$adresa')");
                    return true;
                } catch (Exception $ex) {
                    return false;
                }
            }
            
            //-------unosVesti
            public function vratiSveNovinare() {
                $opcije="";
                $rez = $this->dbh->query(
                        "SELECT * FROM novinar"
                        );
                $niz = $rez->fetchAll(PDO::FETCH_ASSOC);
                foreach($niz as $novinar)
                {
                    $opcije.="<option value='".$novinar['id']."'>".$novinar['ime']." ".$novinar['prezime']."</option>";
                }
                echo $opcije;
            }
            
            public function vratiSvekategorije() {
                $opcije2="";
                $rez2 = $this->dbh->query(
                        "SELECT * FROM kategorija"
                        );
                $niz2 = $rez2->fetchAll(PDO::FETCH_ASSOC);
                foreach($niz2 as $kategorija)
                {
                    $opcije2.="<option value='".$kategorija['id']."'>".$kategorija['naziv']."</option>";
                }
                echo $opcije2;
            }
            
            public function dodajVest($naslov,$opis,$godina,$kategorija, $ime) {
                 try {
                    $this->dbh->query("INSERT INTO vesti(naslov, opis, godina, kategorija_id, novinar_id) "
                    . "VALUES('$naslov','$opis',$godina, $kategorija, $ime)");
                    return true;
                } catch (Exception $ex) {
                    return false;
                }
            }
            
            //----
            function vratiKorisnika($email, $sifra) {
                try {
                    $rez = $this->dbh->query(
                            "SELECT * FROM user u join role r on u.role_id = r.id "
                            . "WHERE email='$email' and password='$sifra'"
                            );
                    if($rez == null)
                        return false;
                    $obj = $rez->fetch(PDO::FETCH_ASSOC);
                    if($obj != null)
                    {
                        return $obj;
                    }
                    else
                    {
                        return false;
                    }
                } catch (Exception $ex) {
                    return false;
                }

            }
            
            //---------
            
            public function kreirajKorisnika($ime,$prezime,$email,$sifra){
                try {
                    $this->dbh->query("INSERT INTO user(ime, prezime, email, password, role_id) "
                    . "VALUES('$ime','$prezime','$email','$sifra',2)");
                    return true;
                } catch (Exception $ex) {
                    return false;
                }
            }
    }