
<?php
    session_start();
    $con = new mysqli("localhost", "root", "", "product_details");
    
    if(isset($_POST["add"])){
        if(isset($_SESSION["cart"])){
            $item_array_id = array($_SESSION["cart"], "product_id");
            if(!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>window.location="Cart.php"</script>';
            }else{
                echo '<script>alert("Product is already added to Cart")</script>';
                echo '<script>window.location="Cart.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][0] = $item_array;
                
        }
        
    }
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    echo '<script>alert("Product has been removed...!")</script>';
                    echo '<script>window.location="Cart.php"</script>';
                }
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="undefined" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="undefined" crossorigin="anonymous"></script>

    <section class="parallax">
      <img src="img/logo.png" alt="The Italian Job logo" class="logo">
      <div class="parallax-inner">
      
    <nav>
        <ul>
          <li><a href="">— Home —</a></li>
          <li><a href="">— About —</a></li>
          <li><a href="">— Contact —</a></li>
          <li><a href="">— Favourites —</a></li>
        </ul>
    </nav>
  </div>
</section>
<div class="margin"></div>
  
</header>
<body>
    
    <div class="container" style="width: 65%">
        <h2>Shopping Cart</h2>
        <?php
            $query = "SELECT * FROM Product ORDER BY id ASC";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0){

                while ($row = mysqli_fetch_array($result)){

                    ?>
                <div class="col-md-3">
                    <form method="post" action="Cart.php?action=add&id=<?php echo $row["id"] ?>">

                <div class="product">
                    <h5 class="text-info"><?php echo $row["pname"]; ?></h5>
                    <h5 class="text-danger"><?php echo $row["price"]; ?></h5>
                    <input type="text" name="quantity" class="form-control" value="1">
                    <input type="hidden" name="hidden-name" value="<?php echo $row["pname"]; ?>">
                    <input type="hidden" name="hidden-price" value="<?php echo $row["price"]; ?>">
                    <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success" value="Add to Cart">
                </div>

            </form>
                
        </div>
        <?php
       }        
    }
    ?>
    <div style="clear: both"></div>
    <h3 class="title2">Shopping Cart Details</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
        <tr>
            <th width="30%">Product Name</th>
            <th width="10%">Quantity</th>
            <th width="13%">Price Details</th>
            <th width="10%">Total Price</th>
            <th width="17%">Remove Items</th>
        </tr>
    <?php
        if(!empty($_SESSION["cart"])){
            $total = 0;
            foreach ($_SESSION["cart"] as $key => $value){
                ?>
            <tr>
                <td><?php echo $value["item_name"]; ?></td>
                <td><?php echo $value["item_quantity"]; ?></td>
                <td>€ <?php echo $value["product_price"]; ?></td>
                <td>€ <?php echo number_format($value["item_quantity"] * $value["product_price"], decimals: 2); ?></td>
                <td><a href="Cart.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span class="text-danger">Remove Item</span></a></td>
            
            </tr>
            <?php
                $total = $total + ($value["item_quantity"] * $value["product_price"]);
            }
            ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <th align="right">$ <?php echo number_format($total, decimals: 2); ?></th>
                <td></td>
            </tr>
            <?php
            }

            ?>
        </table>
        
    </div>        
</body>
</html>
