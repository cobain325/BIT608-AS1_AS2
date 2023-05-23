<?php
ob_start();
global $user;
?>
<nav class="navbar navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Motueka B&B</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php
        $pages = array(
          "Home" => "/",
        );
        if ($user->getUserType() != "Guest") {
          $pages += array(
            "Bookings" => "/bookings"
          );
        }
        $pages += array(
          "Rooms" => "/rooms",
          "About" => "/about",
          "Contact" => "/contact"
        );
        $bookingOptions = array(
          "Create" => array("Guest" => false, "Customer" => true, "Admin" => true, "URL" => "/bookings/create"),
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
                echo "<li><a class=\"dropdown-item\" href=" . $bookingOptionValue["URL"] . ">$bookingOptionName</a></li>";
              }
            }
            echo "</ul></div>";
          }
        }
        ?>
      </div>
      <?php
      if ($user->getUserType() == "Guest") {
        echo "<button class=\"btn btn-outline-success\" type=\"submit\" data-bs-toggle=\"modal\" data-bs-target=\"#loginModal\">Login</button>";
      } else {
        echo "<div><span class=\"mx-2\">" . $user->getFirstName() . "</span><button class=\"btn btn-outline-success\" type=\"submit\" id=\"logout\" onclick=\"logoutConfirm()\">Logout</button></div>";
      }
      ?>
    </div>
  </div>
</nav>
<div class="card mx-3 mb-3 pb-0">
  <nav class="breadcrumb-nav" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <?php
      $longURL = "";
      $route = array_filter($route);
      foreach ($route as $index => $crumb) {
        $longURL .= $crumb . "/";
        if ($index == count($route)) {
          echo "<li class=\"breadcrumb-item active\">" . ucfirst($crumb) . "</li>";
        } else {
          echo "<li class=\"breadcrumb-item\"><a href=\"/$longURL\">" . ucfirst($crumb) . "</a></li>";
        }
      }
      ?>
    </ol>
  </nav>
</div>
<div class="modal" id="logoutModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="logout()">Logout</button>
      </div>
    </div>
  </div>
</div>
<?php
if ($user->getUserType() == "Guest") {
  include "includes/helpers/loginModal.php";
} else {
?>
<script>
  function logoutConfirm(){
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'))
    logoutModal.show();
  }
  async function logout() {
    const response = await fetch('/logout', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ user: <?php echo $user->getUserID() ?> })
    });
    const content = await response.json();
    if (content.message == "success") {
      console.log(content)
      location.href = "<?php echo $_SERVER['REQUEST_URI'] ?>"
    }
  }
</script>
<?php
}
?>