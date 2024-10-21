

<?php
class Db {
    
    private static $mysqli = NULL;

    public static function connection() {
        if (is_null(self::$mysqli)) {
            self::$mysqli = new mysqli("localhost", "root", "", "peacecenterdb");
           
            // Check connection
            if (self::$mysqli->connect_error) {
                die("Connection failed: " . self::$mysqli->connect_error);
            }

            // Set charset
            if (!self::$mysqli->set_charset("utf8mb4")) {
                die("Error loading character set utf8: " . self::$mysqli->error);
            }
        }
        return self::$mysqli;
    }
}
?>
