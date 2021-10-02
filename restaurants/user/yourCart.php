<?php session_start();?>
<?php 
    if(!isset($_SESSION['user_id']) or !isset($_SESSION['email']) or $_SESSION['user_type'] != "user" ){
        header('location:login.php');

    }else{
        require_once "../includes/database.php";
        $u_id=$_SESSION['user_id'];
        $sql="select * from order_details  where u_id=? and status=? order by o_id desc";
        $query=$connect->prepare($sql);
        $query->bindValue(1,$u_id);
        $query->bindValue(2,0,PDO::PARAM_INT);
        $query->execute();
        $pro=$query->fetchAll(PDO::FETCH_OBJ);
                    
    }




?>





<?php include_once "../includes/header.php"; ?>

    <?php if($query->rowCount()<1) {
    echo "You Have Nothing in Your Cart !";
    }else{?>
        <table class="table table-striped">
            <tr>
                <th>SL No</th><th>Title</th><th>Quantity</th><th>Price</th><th>Action </th>
            </tr>
        
        <?php
            $i=1; $totalAmount=0;
            foreach($pro as $cart){
            $p_id=$cart->p_id;
            $q=$connect->prepare("select * from product where p_id=:p_id");
            $q->execute([':p_id'=>$p_id]);
            if($q->rowCount()>0){
                $product=$q->fetch(PDO::FETCH_OBJ);?>
                <tr>
                    <td><?=$i;?></td><td><?=$product->title;?></td><td><?=$cart->o_qty;?></td><td><?=$cart->amount;?></td>
                    <td>
                        <a href="../user/buyNow.php?id=<?=$p_id; ?>" class="btn btn-sm btn-success"><i class="fa fa-bolt" aria-hidden="true"></i> Buy</a> &nbsp;
                        <a href="../user/removeOrder.php?id=<?=$p_id; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"> </i> Remove </a>
                    </td>
                </tr>
                

            <?php
                $totalAmount+=$cart->amount;

            }
            $i++;
            

        }
        
    } 
    ?>
        <tr>
            <th></th><th></th><th>Cart Value</th><th><?=$totalAmount; ?></th><th> </th>
        </tr>
    </table>
    










<?php include_once "../includes/footer.php" ?>