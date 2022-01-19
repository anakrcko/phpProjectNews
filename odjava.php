<?php
    if(isset($_COOKIE['user']) && $_COOKIE['user']!=$korisnik['id'])
            {
                setcookie("user",null, mktime()-3600);
                setcookie("rola",null, mktime()-3600);
            }
            header("Location: login.php");