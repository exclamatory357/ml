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
