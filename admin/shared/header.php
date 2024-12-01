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

// Start Secure Session
session_start();

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
