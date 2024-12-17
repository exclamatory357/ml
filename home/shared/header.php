<?php
// ==============================
// Security Headers
// ==============================

// Content Security Policy: Restricts sources for content, scripts, and frames
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com; frame-ancestors 'none';");
header("Content-Security-Policy: script-src 'self'; object-src 'none';");

// Prevent clickjacking by disallowing framing
header("X-Frame-Options: DENY");

// Enforce HTTPS using Strict-Transport-Security
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Prevent MIME type sniffing
header("X-Content-Type-Options: nosniff");

// Enable basic XSS protection for older browsers
header("X-XSS-Protection: 1; mode=block");

// Control referrer information sent with requests
header("Referrer-Policy: no-referrer-when-downgrade");

// Restrict usage of certain browser features and APIs
header("Permissions-Policy: geolocation=(), camera=(), microphone=(), payment=()");



// ==============================
// Redirect HTTP to HTTPS
// ==============================
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// ==============================
// Secure Session Cookie Settings
// ==============================
ini_set('session.cookie_secure', '1');          // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');        // Prevents JavaScript access to session cookies
ini_set('session.cookie_samesite', 'Strict');   // Mitigates CSRF by limiting cross-site cookie usage

// Start a session securely
session_start();                                

// ==============================
// Anti-XXE: Secure XML Parsing
// ==============================

// Disable loading of external entities to prevent XXE attacks
libxml_disable_entity_loader(true);

// Suppress libxml errors to allow custom handling
libxml_use_internal_errors(true);

/**
 * Securely parses XML strings to prevent XXE vulnerabilities.
 *
 * @param string $xmlString The XML input as a string.
 * @return DOMDocument The parsed DOMDocument object.
 * @throws Exception If parsing fails.
 */
function parseXMLSecurely($xmlString) {
    $dom = new DOMDocument();

    // Load the XML string securely
    if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NOCDATA)) {
        throw new Exception('Error loading XML');
    }

    return $dom;
}

// ==============================
// Example Usage
// ==============================
try {
    $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
    $dom = parseXMLSecurely($xmlString);

    // Continue processing $dom...
    echo " ";
} catch (Exception $e) {
    // Handle XML processing errors securely
    echo 'Error processing XML: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
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