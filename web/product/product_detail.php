<?php
require_once(dirname(dirname(__DIR__)) . "/conf/init.conf.php");
require_once(dirname(dirname(__DIR__)) . "/db_access/product.php");
require_once(dirname(dirname(__DIR__)) . "/db_access/rating.php");

$title = "Product Detail";
$page = "product_detail";

$product_info = null;

if (
  !isset($_GET["id"])
  || !($product_info = get_product_info($_GET["id"]))
) {
  http_response_code(404);
  include_once(dirname(dirname(__DIR__)) . "/template/not_found.php");
  exit();
}

$product_image_sources = get_product_image_sources($_GET["id"]);
$image_count = count($product_image_sources);

// add comment
if (isset($_POST["add_comment_btn"])) {
  // check whether comment is empty
  if (strlen(trim($_POST["comment"]))) {
    $account_id = $_SESSION["account_info"]["id"];
    $product_id = $_GET["id"];
    $comment = $_POST["comment"];

    add_rating($account_id, $product_id, $comment);

    $_SESSION["error_code"] = 0;
    $_SESSION["error_message"] = "Comment added successfully!";
  } else {
    $_SESSION["error_code"] = 1;
    $_SESSION["error_message"] = "Comment must not be empty!";
  }
}
?>

<?php include_once(dirname(dirname(__DIR__)) . "/template/header.php") ?>

<div class="text-center">
  <h1 class="mt-4">Add Product</h1>

  <!-- Display error message -->
  <?php if (isset($_SESSION["error_code"])) : ?>
    <div class="alert <?php echo $_SESSION["error_code"] == 0 ? "alert-success" : "alert-danger"; ?>" role="alert">
      <?php
      echo $_SESSION["error_message"];
      unset($_SESSION["error_code"]);
      unset($_SESSION["error_message"]);
      ?>
    </div>
  <?php endif; ?>
</div>

<div class="container">
  <div class="row mt-5">

    <!-- Product's images -->
    <div class="col-md-6">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <?php for ($i = 0; $i < $image_count; ++$i) : ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" <?php echo $i == 0 ? 'class="active"' : ""; ?> aria-current="true" aria-label="Slide <?php echo $i; ?>"></button>
          <?php endfor; ?>
        </div>
        <div class="carousel-inner">
          <?php for ($i = 0; $i < $image_count; ++$i) : ?>
            <div class="carousel-item <?php echo $i == 0 ? "active" : ""; ?>">
              <img src="<?php echo $product_image_sources[$i]; ?>" class="d-block w-100" style="height: 500px;" alt="...">
            </div>
          <?php endfor; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <!-- Product's information -->
    <div class="col-md-6">
      <div class="product-name">
        <h1><?php echo $product_info["product_name"]; ?></h1>
      </div>

      <div class="favorites mt-4">
        <i class="bi bi-heart-fill"></i>
        <h5 style="display: inline;">19</h5>
      </div>

      <div class="product-price mt-4">
        <h4 class="text-danger" style="display: inline;">VND <?php echo number_format($product_info["price"], 2); ?></h4>
      </div>

      <div class="product-quantity mt-4">
        <label for="quantity">Quantity:</label>
        <input name="quantity" id="quantity" type="number" value="1" />
        (<?php echo $product_info["quantity_in_stock"]; ?> in stock)
      </div>

      <?php if (isset($_SESSION["account_info"])) : ?>
        <div class="container mt-4">
          <div class="row">
            <div class="col-4">
              <a class="btn btn-primary" href="">Add to cart</a>
            </div>

            <div class="col-8">
              <a class="btn btn-info" href="">Add to favorites</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row mt-5">
    <div class="col-md-12">
      <h2>Description</h2>
      <p>
        <?php echo $product_info["description"]; ?>
      </p>
    </div>
  </div>
  <div class="row mt-5">
    <h2>Comments</h2>
  </div>
  <?php if (isset($_SESSION["account_info"])) : ?>
    <div class="row">
      <form action="" method="post">
        <div class="col-md-12">
          <textarea class="form-control" placeholder="Enter comment here..." name="comment" id="comment" style="height: 150px"></textarea>
        </div>
        <div>
          <button class="btn btn-primary mt-2" type="submit" name="add_comment_btn" id="add_comment_btn">Add comment</button>
        </div>
      </form>
    </div>
  <?php endif; ?>
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Lê Anh Tài (leanhtai01@gmail.com)</h5>
          <p class="card-text">This product is very good!</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Nguyễn Thành Thái (nguyenthanhthai@gmail.com)</h5>
          <p class="card-text">The bad product ever. Wasted my money!</p>
          <p class="card-text"><small class="text-muted">Last updated 5 mins ago</small></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once(dirname(dirname(__DIR__)) . "/template/footer.php") ?>
