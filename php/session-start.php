<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");  
    header("Pragma: no-cache"); // Kompatibilität HTTP/1.0  
    header("Expires: 0"); // Kompatibilität für alte Proxies 
    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_set_cookie_params([
            'httponly' => true,
            'secure' => true,
            'samesite' => 'Strict'
        ]);
        session_start();
    }
?>