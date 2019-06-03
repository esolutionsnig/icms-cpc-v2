<?php
//Include database and object filesize
include 'app/core/session.php';
include_once 'app/config/database.php';
include_once 'app/objects/product.php';
include_once 'app/objects/category.php';

//Check user loggin stats and user level
if($session->logged_in){

    $pagename = 'Products';

    // Get DB connection
    $database = new Database();
    $db = $database->getConnection();

    // Pass connection to objects
    $product = new Product($db);
    $category = new Category($db);
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'layouts/e.php'; ?>
  <head>
    <?php include 'layouts/head.php'; ?>
  </head>
  <body>
    <!-- Start Page Loading -->
    <?php include 'layouts/loader.php'; ?>
    <!-- End Page Loading -->
    
    <!-- START HEADER -->
    <?php include 'layouts/header.php'; ?>
    <!-- END HEADER -->
    
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">

        <!-- START LEFT SIDEBAR NAV-->
        <?php include 'layouts/left_sidenav.php'; ?>
        <!-- END LEFT SIDEBAR NAV-->
        
        <!-- START CONTENT -->
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <?php include 'layouts/searchSmallScreen.php'; ?>
            <div class="container">
              <div class="row">
                <div class="col s10 m8 l8">
                  <h5 class="breadcrumbs-title">Blank Page</h5>
                  <ol class="breadcrumbs">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Blank Page</li>
                  </ol>
                </div>
                <div class="col s2 m4 l4">
                  <?php include 'layouts/liveClock.php'; ?>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">

                <?php
                // If the form was submitted 
                if($_POST){
                    // Set product property values
                    $product->name = $_POST['name'];
                    $product->price = $_POST['price'];
                    $product->description = $_POST['name'];
                    $product->category_id = $_POST['category_id'];

                    // Create the product
                    if($product->create()){
                        echo 'Product creation successful';
                    } else {
                        echo 'Product creation failed';
                    }
                }
                ?>
              
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type='text' name='name' placeholder="name" />
                    <input type='text' name='price' placeholder="price" />
                    <textarea name='description' placeholder="description"></textarea>
                    <?php
                    // Read product categories from database
                    $stmt = $category->read();

                    // Put them in a select drop-down
                    echo '<select name="category_id">';
                        echo '<option>Select catgeory...</option>';
                        while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row_category);
                            echo "<option value='".$id."'>".$name."</option>";
                        }
                    echo '</select>';
                    ?>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>
          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->

        <!-- START RIGHT SIDEBAR NAV-->
        <?php include 'layouts/right_sidenav.php'; ?>
        <!-- END RIGHT SIDEBAR NAV-->

      </div>
      <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    
    <!-- START FOOTER -->
    <?php include 'layouts/footer.php'; ?>
    <!-- END FOOTER -->
    
    <?php include 'layouts/foot.php'; ?>

    <script>
      Materialize.toast('Welcome back <?php echo $session->username; ?>', 5000, 'rounded')
    </script>

  </body>
</html>
<?php
} else {
    header("Location: authentication?location=" . urlencode($_SERVER['REQUEST_URI']));
}
?>