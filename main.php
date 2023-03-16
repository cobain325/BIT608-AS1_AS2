
<html data-bs-theme="dark">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="/includes/style.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.13.2/themes/vader/jquery-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <?php
        foreach($_SESSION['alertList'] as $alertMessage => $alertData){
            if($alertData['viewed'] == 0 ) {
                echo "<div class=\"alert alert-";
                echo $alertData['type']; 
                echo " alert-dismissible fade show\" role=\"alert\">
                    $alertMessage
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
                $_SESSION['alertList'][$alertMessage]['viewed']++;
            }
        }
        include "./includes/user.php";
        if(!isset($_SESSION['user'])) {
            $user = new User();
        } else {
            $user = unserialize($_SESSION['user']);
        }
        include "includes/header.php";
        ?>
        <div class="container">
            <div class="card">
                <?php
                include "routes.php";
                ?>
            </div>
        </div>
        <?php
        include "includes/footer.php";
        ?>
    </div>
</body>

</html>

<script>
    const alertList = document.querySelectorAll('.alert')
    const alerts = [...alertList].map(element => new bootstrap.Alert(element))
</script>