<?php
global $title;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $route = rtrim($_SERVER['REQUEST_URI'], '/');
    $getRequestsKeys = array_keys($getRequests);
    $route_params = [];
    foreach ($getRequestsKeys as $keyIndex => $getRequestKey) {
        $regexSearch = "";
        if ($route == $getRequestKey) {
            $title = $getRequests[$getRequestKey]['name'] . " - Motueka Bed and Breakfast";
            ?>
            <script type="text/javascript">
                document.title = "<?php echo $title ?>"
            </script>
            <?php
            call_user_func($getRequests[$getRequestKey]['function'], $route_params);
            break;
        } else {
            $keyParts = explode('/', $getRequestKey);
            $keyParts = array_filter($keyParts);
            $routeParts = explode('/', $route);
            $routeParts = array_filter($routeParts);
            foreach ($keyParts as $index => $keyPart)
                if (preg_match("/^[$]/", $keyPart)) {
                    $regexSearch .= "(\/.*)";
                    if (count($keyParts) == count($routeParts)) {
                        $route_params[ltrim($keyPart, '$')] = $routeParts[$index];
                    }
                } else {
                    $regexSearch .= "(\/" . $keyPart . ")";
                }
            if (preg_match('/^' . $regexSearch . '$/', $route)) {
                if (count($routeParts) == count($keyParts)) {
                    $title = $getRequests[$getRequestKey]['name'] . " - Motueka Bed and Breakfast";
                    ?>
                    <script type="text/javascript">
                        document.title = "<?php echo $title ?>"
                    </script>
                    <?php
                    call_user_func($getRequests[$getRequestKey]['function'], $route_params);
                    break;
                }
            } else {
                if ($keyIndex == count($getRequestsKeys) - 1) {
                    notFound();
                    break;
                }
            }
        }
    }

}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $route = rtrim($_SERVER['REQUEST_URI'], '/');
    $postRequestsKeys = array_keys($postRequests);
    $route_params = [];
    foreach ($postRequestsKeys as $keyIndex => $postRequestsKey) {
        $regexSearch = "";
        if ($route == $postRequestsKey) {
            call_user_func($postRequests[$postRequestsKey]['function']);
            break;
        } else {
            $keyParts = explode('/', $postRequestsKey);
            $keyParts = array_filter($keyParts);
            $routeParts = explode('/', $route);
            $routeParts = array_filter($routeParts);
            foreach ($keyParts as $index => $keyPart)
                if (preg_match("/^[$]/", $keyPart)) {
                    $regexSearch .= "(\/.*)";
                    if (count($keyParts) == count($routeParts)) {
                        $route_params[ltrim($keyPart, '$')] = $routeParts[$index];
                    }
                } else {
                    $regexSearch .= "(\/" . $keyPart . ")";
                }
            if (preg_match('/^' . $regexSearch . '$/', $route)) {
                if (count($routeParts) == count($keyParts)) {
                    call_user_func($postRequests[$postRequestsKey]['function'], $route_params);
                    break;
                }
            } else {
                if ($keyIndex == count($postRequestsKeys) - 1) {
                    notFound();
                    break;
                }
            }
        }
    }

}
function notFound()
{
    $title = "Page Not Found - Motueka Bed and Breakfast";
    ?>
    <script type="text/javascript">
        document.title = "<?php echo $title; ?>"
    </script>
    <?php
    include 'views/404.php';
}

?>