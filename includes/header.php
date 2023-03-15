<?php
ob_start();
global $user;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['userType'])){
    $user->setUserType($_POST['userType']);
  }
}
?>
<nav class="navbar navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Motueka B&B</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php
        $pages = array(
          "Home" => "/",
          "Bookings" => "/bookings",
          "Rooms" => "/rooms",
          "About" => "/about",
          "Contact" => "/contact"
        );
        $bookingOptions = array(
          "Create" => array("Guest" => true, "Customer" => true, "Admin" => true, "URL" => "/bookings/create"),
          "View My Bookings" => array("Guest" => false, "Customer" => true, "Admin" => false, "URL" => "/bookings"),
          "List All Bookings" => array("Guest" => false, "Customer" => false, "Admin" => true, "URL" => "/bookings"),
        );
        $route = $_SERVER['REQUEST_URI'];
        $route = explode('/', $route);
        foreach ($pages as $page => $url) {
          if ($page != "Bookings") {
            if ($url == "/$route[1]") {
              echo "<a class=\"nav-link active\" aria-current=\"page\" href=\"$url\">$page</a>";
            } else {
              echo "<a class=\"nav-link\" href=\"$url\">$page</a>";
            }
          } else {
            echo "
              <div class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle";
            if ($route[1] == "bookings") {
              echo " active";
            }
            echo "\" href=\"#\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                  $page
                </a>
                <ul class=\"dropdown-menu\">";
            foreach ($bookingOptions as $bookingOptionName => $bookingOptionValue) {
              $userType = $user->getUserType();
              if ($bookingOptionValue[$userType] == true) {
                echo "<li><a class=\"dropdown-item\" href=";
                echo $bookingOptionValue["URL"];
                echo ">$bookingOptionName</a></li>";
              }
            }
            echo "</ul></div>";
          }
        }
        ?>
      </div>
      <?php
      $username = $user->getUsername();
      if ($username == "Guest") {
        echo "<button class=\"btn btn-outline-success\" type=\"submit\" data-bs-toggle=\"modal\" data-bs-target=\"#loginModal\">Login</button>";
      } else {
        echo "<span>$username</span>";
      }
      ?>
    </div>
  </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <p>Login in as:</p>
        <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method = "post">
          <select class="form-select" id="userType" name="userType">
            <option <?php if ($userType == "Guest") { echo "selected"; } ?>>Guest</option>
            <option <?php if ($userType == "Customer") { echo "selected"; } ?>>Customer</option>
            <option <?php if ($userType == "Admin") { echo "selected"; } ?>>Admin</option>
          </select>
          <button type="submit" class="btn btn-primary mt-3" data-bs-dismiss="modal">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>