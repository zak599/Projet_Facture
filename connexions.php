<?php
$conn = mysqli_connect('localhost','root', 'root', 'projet_facture') or die(mysqli_error());
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];

$req="INSERT INTO utilisateurs (nom,prenom,username,email,password,cpassword) values('$nom','$prenom','$username','$email','$password','$cpassword')";

$res=mysqli_query($conn,$req);

if($conn!=0) // nom d'utilisateur correct
        {
           $_SESSION['username'] = $username;
           header('Location: index.php');
        }