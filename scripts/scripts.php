<?php
include '../includes/session.php';
if(isset($_POST['addtocart'])){
    $output = array('error'=>true);
    $commodityID=$_POST['commodityID'];
    $qty=1;
    $query=mysqli_query($conn,"select * from cart where commodityID='$commodityID' and clientID='".$_SESSION['clientID']."'");
    if (mysqli_num_rows($query)>0){
        $output['error'] = true;
    }
    else{
        mysqli_query($conn,"insert into cart (clientID, commodityID, qty) values ('".$_SESSION['clientID']."', '$commodityID', '$qty')");
        $output['error'] = false;
    }
}
echo json_encode($output);
?>