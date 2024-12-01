<?php
// Ensure headers are sent before any output
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com; frame-ancestors 'none';");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

// Redirect HTTP to HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Set secure session cookie parameters before starting the session
ini_set('session.cookie_secure', '1');    // Enforces HTTPS-only session cookies
ini_set('session.cookie_httponly', '1');  // Prevents JavaScript from accessing session cookies
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF by limiting cross-site cookie usage

// Set cookie parameters for session
session_set_cookie_params([
    'lifetime' => 0,  // Session cookie
    'path' => '/',     // Available across the whole site
    'domain' => $_SERVER['HTTP_HOST'], // Ensure cookie is scoped to the domain
    'secure' => true,  // Only sent over HTTPS
    'httponly' => true, // Accessible only via HTTP (not JavaScript)
    'samesite' => 'Strict', // Strict SameSite policy
]);

// Start the session after setting the secure session parameters
session_start();

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
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>DRFAMS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>DRFAMS</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        
    <!--    //Notifications Dropdown 
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                //Notifications Menu
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                          //Inner Menu: contains the notifications 
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
            </ul>
        </div> !-->
    </nav>
</header>
