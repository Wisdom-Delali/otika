<?php
include '../includes/session.php';
if(isset($_POST['fetchcart'])){

    $query=mysqli_query($conn,"SELECT * from cart left join commodity on cart.commodityID=commodity.commodityID where cart.clientID='".$_SESSION['clientID']."'");
    if (mysqli_num_rows($query)>0){
        ?>  
            <a href="#" class="dropdown-item dropdown-item-unread"> <span
                    class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc"> No products available in your cart! <span class="time">About a second ago</span>
                  </span>
                </a>
        <?php
    }
    else{
        while($cartrow=mysqli_fetch_array($query)){
            ?>
                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                    class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                  </span> <span class="dropdown-item-desc"> <?php echo $cartrow['commodityName'] ?> <span class="time"><?php echo $cartrow['qty'] ?></span>
                  </span>
                </a>
            <?php
        }

    }
}
?>