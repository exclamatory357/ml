<?php
// Security Headers
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com;");
header("Content-Security-Policy: frame-ancestors 'none';"); // Prevent framing
header("X-Frame-Options: DENY"); // Deny all framing attempts
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Enforce HTTPS
header("X-Content-Type-Options: nosniff"); // Prevent MIME-type sniffing
header("X-XSS-Protection: 1; mode=block"); // Enable XSS protection in legacy browsers

// Add Missing Security Headers
header("Referrer-Policy: no-referrer"); // Prevent sending referrer information
header("Permissions-Policy: geolocation=(), camera=(), microphone=(), payment=()"); // Restrict browser permissions

// Redirect HTTP to HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
    exit();
}

// Secure Session Settings
//ini_set('session.use_cookies', '1');        // Use cookies for session management
ini_set('session.cookie_secure', '1');     // Enforce HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');   // Prevent JavaScript access to session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevent CSRF by limiting cross-site requests


// Disable XML External Entities (XXE) to secure XML processing
libxml_disable_entity_loader(true); // Disable loading external entities
libxml_use_internal_errors(true);   // Suppress XML errors for better handling

/**
 * Securely parse an XML string.
 *
 * @param string $xmlString The XML string to parse.
 * @return DOMDocument The parsed XML document.
 * @throws Exception If the XML fails to load.
 */
function parseXMLSecurely($xmlString) {
    $dom = new DOMDocument();
    
    // Load XML securely with minimal risky flags
    if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_NONET | LIBXML_NOCDATA)) {
        throw new Exception('Error loading XML');
    }
    
    return $dom;
}

// Example Usage of XML Parsing
try {
    $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
    $dom = parseXMLSecurely($xmlString);
    // Further processing of the $dom object...
} catch (Exception $e) {
    // Secure error handling
    error_log('XML Parsing Error: ' . $e->getMessage()); // Log the error for debugging
    echo 'An error occurred while processing your request.';
}
?>

<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="?home" class="navbar-brand"><b>DRFAMS</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
  <li id="home"><a href="?home">Home</a></li>
  <li id="home"><a href="?gallery">Gallery</a></li>
  <?php if (!isset($_SESSION["username"])) { ?>
    <li id="home"><a href="?weather">Weather</a></li>
  <?php } ?>
  <?php if (isset($_SESSION["username"])) { ?>
    <li id="reserve"><a href="?request">Request</a></li>
  <?php } ?>
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
                <img src="../dist/img/icon.png" class="user-image" alt="User Image">
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