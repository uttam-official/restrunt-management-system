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
        $query->bindValue(2,1,PDO::PARAM_INT);
        $query->execute();
        $pro=$query->fetchAll(PDO::FETCH_OBJ);
                    
    }




?>





<?php include_once "../includes/header.php"; ?>

    <?php if($query->rowCount()<1) {
    echo "You made no Order Yet !";
    }else{?>
        <table class="table table-striped">
            <tr>
                <th>SL No</th><th>Title</th><th>Quantity</th><th>Price</th><th>Order <br>Date & Time </th>
            </tr>
        
        <?php
            $i=1; 
            foreach($pro as $order){
            $p_id=$order->p_id;
            $q=$connect->prepare("select * from product where p_id=:p_id");
            $q->execute([':p_id'=>$p_id]);
            if($q->rowCount()>0){
                $product=$q->fetch(PDO::FETCH_OBJ);?>
                <tr>
                    <td><?=$i;?></td><td><?=$product->title;?></td><td><?=$order->o_qty;?></td><td><?=$order->amount;?></td>
                    <td>
                       <?=$order->date;?>
                    </td>
                </tr>
                

            <?php
                

            }
            $i++;
            

        }
        
    } 
    ?>
        
    
    </table>
    










<?php include_once "../includes/footer.php" ?>