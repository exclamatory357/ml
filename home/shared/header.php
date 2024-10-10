<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com;");
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none';");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");


// Redirect all HTTP requests to HTTPS if not already using HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
  header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
}



// Secure session cookie settings
ini_set('session.cookie_secure', '1');    // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');  // Prevents JavaScript from accessing session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF by limiting cross-site cookie usage


// Additional security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");


// Anti-XXE: Secure XML parsing
libxml_disable_entity_loader(true); // Disable loading of external entities
libxml_use_internal_errors(true);   // Suppress libxml errors for better handling

function parseXMLSecurely($xmlString) {
    $dom = new DOMDocument();
    
    // Load the XML string securely
    if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NOCDATA)) {
        throw new Exception('Error loading XML');
    }
    
    // Process the XML content safely
    return $dom;
}

// Example usage
try {
    $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
    $dom = parseXMLSecurely($xmlString);
    // Continue processing $dom...
} catch (Exception $e) {
    // Handle errors securely
    echo 'Error processing XML: ' . $e->getMessage();
}
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand"><b>DRMS</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li id="home"><a href="?home">Home</a></li>
            <li id="home"><a href="?gallery">Gallery</a></li>
            <?php
             if (!isset($_SESSION["username"])) {?>
               <!--# code...-->
            <?php } else {?>
              <li id="reserve"><a href="?request">Request</a></li>
            <?php }
             
            ?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <?php
           if (!isset($_SESSION["username"])) {?>
             <!-- code... -->
          <?php } else { ?>
            <ul class="nav navbar-nav">
          <!--  <li id="cart" class="dropdown tasks-menu"> !-->
              <!-- Menu Toggle Button -->
             <!-- <a href="?cart" class="dropdown-toggle">
                <i class="fa fa-shopping-cart"></i>
                <span class="label label-danger"><?php get_count($con, $_SESSION["user_id"], $_SESSION["trans_no"])?></span>
              </a> !-->
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">Welcome, <?php echo $_SESSION["username"]?></span>
              </a>
             <!-- <ul class="dropdown-menu" id="dropdown-width" width="100px">
                <li><a href="?my-res">My Reservation</a></li>
                <li><a href="#" data-toggle="modal" data-target="#modal-feedback">Give Feedback</a></li>
                <li class="divider"></li> !-->
                <li><a href="function/logout.php">Log Out</a></li>
              </ul>
            </li>
          </ul>
          <?php }
           
          ?>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>