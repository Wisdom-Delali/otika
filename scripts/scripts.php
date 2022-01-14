<?php
include '../includes/session.php';
if(isset($_POST['addtocart'])){
    $output = array('error'=>true);
    $commodityID=$_POST['commodityID'];
    $qty=$_POST['qty'];
    $query=mysqli_query($conn,"select * from cart where commodityID='$commodityID' and clientID='$client_id'");
    
    if (mysqli_num_rows($query)>0){
        $output['error'] = true;
    }else{
        mysqli_query($conn,"insert into cart (clientID, commodityID, qty) values ('$client_id', '$commodityID', '$qty')");
        $output['error'] = false;
    }

}elseif(isset($_POST['sell'])){
    $output = array('error'=>true);
    $commodityID=$_POST['commodityID'];
    $qty=$_POST['qty'];
    $query=mysqli_query($conn,"select * from sellcart where commodityID='$commodityID' and clientID='$client_id'");
    
    if (mysqli_num_rows($query)>0){
        $output['error'] = true;
    }else{
        mysqli_query($conn,"insert into sellcart (clientID, commodityID, qty) values ('$client_id', '$commodityID', '$qty')");
        $output['error'] = false;
    }

}elseif(isset($_POST['depositC'])){
    $output = array('error'=>true);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $orderID = filter_input(INPUT_POST, 'orderID', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
    $checkout = filter_input(INPUT_POST, 'depositC', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token'] || !$checkout || $checkout !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        $output['error'] = true;
    } else {
        mysqli_query($conn, "INSERT INTO `ttransactions`(`clientID`, `orderID`, `trantype`, `status`, `tranamount`, `tranmethod`) VALUES ('$client_id','$orderID',1,0,'$amount',1)");
        $output['error'] = false;
    }


}elseif(isset($_POST['checkout'])){
    $output = array('error'=>true);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $checkout = filter_input(INPUT_POST, 'checkout', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token'] || !$checkout || $checkout !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    } else {
        $balance = $profile_row['client_account_balance'];
        $total = $_POST['total'];
        
        if($total>$balance){
            $output['error'] = true;
            
        }else{
            $query=mysqli_query($conn,"select *, commodity.commodityID as newid from cart inner join commodity on cart.commodityID=commodity.commodityID where cart.clientID='$client_id'");
            if (mysqli_num_rows($query)<1){
                $output['error'] = true;
            }
            else{
                $order = $_POST['order'];
                $share_transaction=mysqli_query($conn, "INSERT INTO `share_transactions`(`orderID`, `clientID`, `amount`, `trantype`,  `status`) VALUES ('$order','$client_id','$total',1, 0)");
                while($chk_row=mysqli_fetch_array($query)){
                    $commodityID = $chk_row['newid'];
                    $qty = $chk_row['qty'];
                    $price = $chk_row['price'];
                    mysqli_query($conn, "INSERT INTO `share_transactions_details`(`orderID`, `clientID`, `commodityID`, `qty`, `tranprice`) VALUES ('$order','$client_id','$commodityID','$qty','$price')");
                    $add_q=mysqli_query($conn, "SELECT * FROM tclientshares where clientID='$client_id' and commodityID='$commodityID'");
                    $add_row=mysqli_fetch_array($add_q);
                    if(mysqli_num_rows($add_q)<1){
                        mysqli_query($conn, "INSERT INTO `tclientshares`(`clientID`, `commodityID`, `shareamount`, `pricebefore`, `balance`) VALUES ('$client_id','$commodityID','$qty','$price',0)");
                    }else{
                        
                        $oldamount = $add_row['shareamount'];
                        $newamount = $oldamount+$qty;
                        mysqli_query($conn, "UPDATE tclientshares set shareamount='$newamount' where clientID='$client_id' and commodityID='$commodityID'");
                    }
                }
                $newclientbalance=$balance-$total;
                mysqli_query($conn, "UPDATE share_transactions set status=1 where orderID='$order' and clientID='$client_id'");
                mysqli_query($conn, "UPDATE tclient set client_account_balance='$newclientbalance' where clientID='$client_id'");
                mysqli_query($conn, "DELETE FROM cart where clientID='$client_id'");
                $output['error'] = false;
            }
        }
        

    }
    
}elseif(isset($_POST['sellC'])){
    $output = array('error'=>true);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $checkout = filter_input(INPUT_POST, 'sellC', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token'] || !$checkout || $checkout !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    } else {
        $balance = $profile_row['client_account_balance'];
        $total = $_POST['total'];
        
        if($total==0){
            $output['error'] = true;
            
        }else{
            $query=mysqli_query($conn,"select *, commodity.commodityID as newid from sellcart inner join commodity on sellcart.commodityID=commodity.commodityID where sellcart.clientID='$client_id'");
            if (mysqli_num_rows($query)<1){
                $output['error'] = true;
            }
            else{
                $order = $_POST['order'];
                $share_transaction=mysqli_query($conn, "INSERT INTO `share_transactions`(`orderID`, `clientID`, `amount`, `trantype`,  `status`) VALUES ('$order','$client_id','$total',2, 0)");
                while($chk_row=mysqli_fetch_array($query)){
                    $commodityID = $chk_row['newid'];
                    $qty = $chk_row['qty'];
                    $price = $chk_row['price'];
                    
                    $add_q=mysqli_query($conn, "SELECT * FROM tclientshares where clientID='$client_id' and commodityID='$commodityID'");
                    $add_row=mysqli_fetch_array($add_q);
                    if(mysqli_num_rows($add_q)<1){
                        $output['error'] = true;
                    }else{
                        $oldamount = $add_row['shareamount'];
                        if($oldamount>=$qty){
                            $newamount = $oldamount-$qty;
                            mysqli_query($conn, "UPDATE tclientshares set shareamount='$newamount' where clientID='$client_id' and commodityID='$commodityID'");
                            mysqli_query($conn, "INSERT INTO `share_transactions_details`(`orderID`, `clientID`, `commodityID`, `qty`, `tranprice`) VALUES ('$order','$client_id','$commodityID','$qty','$price')");
                        }else{
                            $output['error'] = true;
                        }
                        
                    }
                }
                $newclientbalance=$balance+$total;
                mysqli_query($conn, "UPDATE share_transactions set status=1 where orderID='$order' and clientID='$client_id'");
                mysqli_query($conn, "UPDATE tclient set client_account_balance='$newclientbalance' where clientID='$client_id'");
                mysqli_query($conn, "DELETE FROM sellcart where clientID='$client_id'");
                $output['error'] = false;
            }
        }
        

    }
    
}
echo json_encode($output);
?>