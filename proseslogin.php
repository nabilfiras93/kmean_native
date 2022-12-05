 <?php

include 'konek.php';
$username=$_POST['username'];
$password=$_POST['password'];

$query = mysqli_query($con,"SELECT * FROM admin WHERE username='$username' AND password = '$password'");
$row=mysqli_fetch_array($query);
if($row > 0)
{
    session_start();
    $_SESSION['username']=$username;
    $_SESSION['id_admin']=$row["id_admin"];
    header('location:dashboard.php?hal=menu_utama');
}else
{
    echo "<script>alert('Username atau Password salah.'); window.location = 'index.php'</script>";
}



?>