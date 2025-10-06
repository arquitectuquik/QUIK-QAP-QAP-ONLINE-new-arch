<?php


/**
 * MySQL Compatibility Layer para PHP 7+
 * 
 * Este archivo proporciona funciones mysql_* obsoletas usando mysqli
 * Compatible con PHP 7.0 - 8.2
 * 
 * @version 2.0
 * @author QAP Migration Tool
 * @created 2025
 */

// Variables globales para conexiones
if (!isset($GLOBALS['mysql_link'])) {
    $GLOBALS['mysql_link'] = null;
}

if (!isset($GLOBALS['mysql_last_connection'])) {
    $GLOBALS['mysql_last_connection'] = null;
}

if (!isset($GLOBALS['mysql_last_error'])) {
    $GLOBALS['mysql_last_error'] = '';
}

if (!function_exists('mysql_connect')) {
    /**
     * Emulate mysql_connect using mysqli
     * 
     * @param string $server Server hostname or IP
     * @param string $username Username
     * @param string $password Password
     * @param bool $new_link Force new connection (ignored for compatibility)
     * @param int $client_flags Client flags (ignored for compatibility)
     * @return mysqli|false Connection resource or false on failure
     */
    function mysql_connect($server, $username, $password, $new_link = false, $client_flags = 0) {
        // Handle legacy connection strings and Docker compatibility
        $port = 3306;
        if (strpos($server, ':') !== false) {
            list($server, $port) = explode(':', $server);
            $port = intval($port);
        }
        
        // Docker compatibility
        if ($server === 'mysql_qaponline' || ($server === 'localhost' && defined('DOCKER_ENV'))) {
            $server = 'mysql_qaponline';
        }
        
        // Suppress warnings and handle errors manually
        $link = @mysqli_connect($server, $username, $password, '', $port);
        
        if ($link) {
            $GLOBALS['mysql_link'] = $link;
            $GLOBALS['mysql_last_connection'] = $link;
            $GLOBALS['mysql_last_error'] = '';
            
            // Set UTF-8 charset by default
            mysqli_set_charset($link, 'utf8');
        } else {
            $GLOBALS['mysql_last_error'] = 'Connection failed: ' . mysqli_connect_error();
        }
        
        return $link;
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database, $connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        return mysqli_select_db($connection, $database);
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        return mysqli_query($connection, $query);
    }
}

if (!function_exists('mysql_error')) {
    /**
     * Get MySQL error message
     * 
     * @param mysqli $connection Connection resource
     * @return string Error message
     */
    function mysql_error($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        
        if ($connection === null || $connection === false) {
            return $GLOBALS['mysql_last_error'] ?: "No MySQL connection available";
        }
        
        $error = mysqli_error($connection);
        $GLOBALS['mysql_last_error'] = $error;
        return $error;
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result) {
            return false;
        }
        return mysqli_fetch_array($result, $result_type);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if (!$result) {
            return 0;
        }
        return mysqli_num_rows($result);
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        $result = mysqli_close($connection);
        if ($connection === $GLOBALS['mysql_link']) {
            $GLOBALS['mysql_link'] = null;
        }
        return $result;
    }
}

if (!function_exists('mysql_set_charset')) {
    function mysql_set_charset($charset, $connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        return mysqli_set_charset($connection, $charset);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        if (!$result) {
            return false;
        }
        return mysqli_fetch_assoc($result);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        return mysqli_insert_id($connection);
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return false;
        }
        return mysqli_affected_rows($connection);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    /**
     * Escape string for MySQL query
     * 
     * @param string $string String to escape
     * @param mysqli $connection Connection resource
     * @return string Escaped string
     */
    function mysql_real_escape_string($string, $connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        
        if ($connection === null || $connection === false) {
            // Enhanced fallback for PHP 7+ compatibility
            return str_replace(
                ['\\', "\0", "\n", "\r", "'", '"', "\x1a"],
                ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'],
                $string
            );
        }
        
        return mysqli_real_escape_string($connection, $string);
    }
}

if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        return mysql_real_escape_string($string);
    }
}

if (!function_exists('mysql_get_client_info')) {
    function mysql_get_client_info() {
        return "MySQL compatibility layer via mysqli";
    }
}

if (!function_exists('mysql_get_server_info')) {
    function mysql_get_server_info($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return "Unknown";
        }
        return mysqli_get_server_info($connection);
    }
}

if (!function_exists('mysql_errno')) {
    function mysql_errno($connection = null) {
        if ($connection === null) {
            $connection = $GLOBALS['mysql_link'];
        }
        if ($connection === null || $connection === false) {
            return 0;
        }
        return mysqli_errno($connection);
    }
}
?>