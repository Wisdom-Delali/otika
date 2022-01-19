<?php
   include "../includes/getdb.php";
$orderID=$_POST['orderID'];
$clientID=$_POST['clientID'];
$amount1=$_POST['amount'];


$check=mysqli_query($conn, "SELECT * FROM `ttransactions` WHERE orderID='$orderID' AND clientID='$clientID' AND status=0");
if(mysqli_num_rows($check)==1){
    mysqli_query($conn, "UPDATE `ttransactions` SET `status`=1 WHERE orderID='$orderID' AND clientID='$clientID' AND status=0");
    $clientq=mysqli_query($conn, "SELECT * FROM `tclient` WHERE clientID='$clientID'");
    $clientrow=mysqli_fetch_array($clientq);
    $clientbalance = $clientrow['client_account_balance'];
    $newclientbalance = $clientbalance+$amount1;
    mysqli_query($conn, "UPDATE `tclient` SET `client_account_balance`='$newclientbalance' WHERE clientID='$clientID'");
    echo "Done";
    echo "<br>";
    echo $clientID;
    echo "<br>";
    echo $orderID;
    echo "<br>";
}


?>