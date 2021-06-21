<?php
class Config{

  /*
  const DB_HOST = "localhost";
  const DB_USERNAME = "pepejam";
  const DB_PASSWORD = "Pepejam123";
  const DB_SCHEME = "pepejam";

  const SMTP_HOST = "smtp.gmail.com";
  const SMTP_PORT = 587;
  const SMTP_USER = "email@gmail.com";
  const SMTP_PASSWORD = "gmailpassword";
  */

  const DATE_FORMAT = "Y-m-d H:i:s";

  public static function DB_HOST(){
    return Config::get_env("DB_HOST", "localhost");
  }
  public static function DB_USERNAME(){
    return Config::get_env("DB_USERNAME", "pepejam");
  }
  public static function DB_PASSWORD(){
    return Config::get_env("DB_PASSWORD", "Pepejam123");
  }
  public static function DB_SCHEME(){
    return Config::get_env("DB_SCHEME", "pepejam");
  }
  public static function DB_PORT(){
    return Config::get_env("DB_PORT", "3306");
  }


  public static function SMTP_HOST(){
    return Config::get_env("SMTP_HOST", "smtp.gmail.com");
  }
  public static function SMTP_PORT(){
    return Config::get_env("SMTP_PORT", "587");
  }
  //gmail email
  public static function SMTP_USER(){
    return Config::get_env("SMTP_USER", NULL);
  }

  //gmail password
  public static function SMTP_PASSWORD(){
    return Config::get_env("SMTP_PASSWORD", NULL);
  }

  //Digital ocean CDN config
  public static function CDN_KEY(){
    return Config::get_env("CDN_KEY", "DBPFCE2LIAAZQQQK7JWD");
  }
  public static function CDN_SECRET(){
    return Config::get_env("CDN_SECRET", "YkdhHQDGlV4jJQoZG88Gzv812l7ssQtKPfaA96uod70");
  }
  public static function CDN_SPACE(){
    return Config::get_env("CDN_SPACE", "cdn.pepejam");
  }
  public static function CDN_BASE_URL(){
    return Config::get_env("CDN_BASE_URL", "https://fra1.digitaloceanspaces.com");
  }
  public static function CDN_REGION(){
    return Config::get_env("CDN_REGION", "fra1");
  }

  const JWT_SECRET = "srsEyAkbQUP38Zoh";
  const JWT_TOKEN_TIME = 604800;

  public static function get_env($name, $default){
    return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
  }
}

?>
