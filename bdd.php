<?php
try
{
$bdd = new PDO('mysql:host=localhost;dbname=', '', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
