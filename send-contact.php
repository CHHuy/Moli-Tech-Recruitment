<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 require 'vendor/autoload.php';
function contentmail($post)
{
  $html = '
  <!DOCTYPE html>
    <html>
<head>
<meta charset="utf-8">
<title>MAIL</title>
</head>
<body>
<table width="620" cellspacing="0" cellpadding="0" border="0" align="center">
  <table width="100%">
      <tr>
        <td style="font-family:arial" width="3%">Name:</td>
        <td style="font-family:arial">' . $post['name'] . '</td>
      </tr>
      <tr>
        <td style="font-family:arial">Email:</td>
        <td style="font-family:arial">' . $post['email'] . '</td>
      </tr>
            <tr>
              <td style="font-family:arial" width="3%">Phone:</td>
              <td style="font-family:arial">' . $post['phone'] . '</td>
            </tr>
      <tr>
        <td style="font-family:arial">Message:</td>
        <td style="font-family:arial">' . $post['message'] . '</td>
      </tr>
    </table>
    <p style="border-top: 1px solid #aaa; padding-top: 15px;">Thanks!<br>
													<b>' . $post['name'] . '</b></p>
</table>
</body>
</html>
';
  return $html;
}

if($_SERVER['REQUEST_METHOD']=='POST') {

/*var_dump($_POST['name']);
exit();*/

  if (!$_POST['name'] || !$_POST['email'] || !$_POST['phone'] || !$_POST['message']) {
    $json = array('msg' => 'Please enter full information!', 'res' => 0);
  } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $json = array('msg' => 'Please input your email!', 'res' => 0);
  } else {
    $content = contentmail($_POST);
    $mail = new PHPMailer(true);

    try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->SMTPAuth = true;
      $mail->Host = 'smtp.gmail.com';
      $mail->Username = "chehoanghuy2013@gmail.com";
      $mail->Password = "hoanghuy";
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;

//      $mail->setFrom($_POST['email'], $_POST['name']);
//      $mail->addAddress('support@rightnative.com', 'RIGHTNATIVE');

      $mail->setFrom($_POST['email'], $_POST['name']);
      $mail->addAddress('chehoanghuy2015@gmail.com', 'Support');     // Add a recipient
//      $mail->addAddress('ellen@example.com');               // Name is optional
      $mail->addReplyTo($_POST['email'], $_POST['name']);
//      $mail->addCC('cc@example.com');
//      $mail->addBCC('');

      $mail->isHTML(true);
      $mail->Subject = 'MOLI Tech Recruitment';
      $mail->Body    = $content;
//      $mail->send();

      if (!$mail->send()) {
//        echo "Mailer Error: " . $mail->ErrorInfo;
        $json = array('msg' => 'Failed to send your message. Please try later or contact the administrator.', 'res' => 0);
      } else {
            $json = array('msg' => 'Your question has been sent to us. We will contact you soon. Please keep in touch with us.
            Thank you.', 'res' => 1);
      }

    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
  echo json_encode($json);

}


