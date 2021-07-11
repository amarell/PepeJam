<?php
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';
class SMTPClient {

  private $mailer;

  public function __construct(){
    $transport = (new Swift_SmtpTransport(Config::SMTP_HOST(), Config::SMTP_PORT(), "tls"))
      ->setUsername(Config::SMTP_USER())
      ->setPassword(Config::SMTP_PASSWORD())
    ;

    // Create the Mailer using your created Transport
    $this->mailer = new Swift_Mailer($transport);
  }

  public function send_token_to_registered_user($user){
    $message = (new Swift_Message('Confirm account'))
      ->setFrom(['pepejam@gmail.com' => 'PepeJam'])
      ->setTo([$user["email"]])
      ->setBody("This is the confirmation link: http://localhost:8080/api/confirm/". $user["token"])
      ;

      $result = $this->mailer->send($message);
  }

  public function send_recovery_token($user){
    $message = (new Swift_Message('Reset password for your PepeJam account'))
      ->setFrom(['pepejam@gmail.com' => 'PepeJam'])
      ->setTo([$user["email"]])
      ->setBody("This is the recovery token: http://localhost/webapp/login.html?token=". $user["token"])
      ;

      $result = $this->mailer->send($message);
  }

}
?>
