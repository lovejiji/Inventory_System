<?php


$db = mysqli_connect('localhost', 'root', '', 'inventory'); // Assuming correct connection details

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Get tool information from query parameter
$id = $_GET['id'];

// Write a query to retrieve tool information
$stmt = mysqli_prepare($db, "SELECT * FROM tools WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", id); // Bind the parameter as integer (optional, based on your tool_id data type)
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (isset($_GET['id'])) {
  $tool_id = $_GET['id'];
  // ... rest of your code using $tool_id
} else {
  // Handle missing tool_id case (e.g., display error message)
  echo "Error: Tool ID not found in the URL.";
  exit(); // Stop script execution
}

mysqli_close($db); // Close connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CPE TOOL</title>
  <script src="borrowItems.js"></script>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=https://fonts.googleapis.com/css?family=Inconsolata:400,500,600,700|Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="borrowItems.js"></script>

</head> 

<body>

  <!-- ======= Navbar ======= -->
  <div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
      <div class="row align-items-start">
        <div class="col-md-2">
          <ul class="custom-menu">
            <li><a href="index.html">Home</a></li>
          
        </div>
        
      </div>

    </div>
  </div>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">CPE Hand Tools.</a>
      <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </nav>

  <main id="main">

  <section class="section">
  <div class="container">
    <div class="row mb-4 align-items-center">
      <div class="col-md-6" data-aos="fade-up">
        <h2>Wire Cutter</h2>
        <p>-A wire cutter is a hand tool designed for cutting wires and cables. It typically consists of two sharp blades that are forced together to cleanly cut through the wire.</p>
        <a href="work-single.php?tool=wire-cutter" class="btn btn-primary">View Details</a>
      </div>
    </div>
  </div>

  <div class="site-section pb-0">
    <div class="container">
      <div class="row align-items-stretch">
        <div class="col-md-8" data-aos="fade-up">
          <img src="assets/img/Wire Cutter.jpg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-3 ml-auto" data-aos="fade-up" data-aos-delay="100">
          </div>
      </div>
    </div>
  </div>
</section>

               

                <button id="borrow-item-btn">Borrow Item</button>
          <div id="borrowed-items-list"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
          </div>
        </div>
       
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>