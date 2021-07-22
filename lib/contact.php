<?php
  define( 'WP_USE_THEMES', FALSE );
  require( '../../../../wp-load.php' );

if($_POST) {
  $to_Email = get_field('cemail', 'option');
  $dev_Email = "szabogabor@hydrogene.hu";
  $subject = __('MARRAKESH | Webes ajánlatkérés.','marrakesh');
  $resp_subject = "MARRAKESH | Érdeklődésedet rögzítettük";

  if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    $output = json_encode(
    array(
      'type'=>'error',
      'text' => 'Request must come from Ajax'
    ));

    die($output);
  }

  if( !isset($_POST["userName"]) || !isset($_POST["userEmail"]) ) {
    $output = json_encode(array('type'=>'error', 'text' => __('Hiányzó kötelező mezők','marrakesh') ));
    die($output);
  }
  $user_Name = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
  $user_Email = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
  $user_Tel = filter_var($_POST["userTel"], FILTER_SANITIZE_STRING);
  $user_Message = filter_var($_POST["userMsg"], FILTER_SANITIZE_STRING);
  $user_Product = filter_var($_POST["userProduct"], FILTER_SANITIZE_STRING);
  $user_Amount = filter_var($_POST["userAmount"], FILTER_SANITIZE_STRING);

  $user_Message = str_replace("\&#39;", "'", $user_Message);
  $user_Message = str_replace("&#39;", "'", $user_Message);

  if(strlen($user_Name)<4) {
    $output = json_encode(array('type'=>'error', 'text' => __('Teljes nevet adj meg','marrakesh')));
    die($output);
  }
  if(!filter_var($user_Email, FILTER_VALIDATE_EMAIL)) {
    $output = json_encode(array('type'=>'error', 'text' => __('Érvénytelen e-mail cím','marrakesh')));
    die($output);
  }

  $headers = array(
      'From: '.$user_Email,
      'Reply-To: '.$user_Email,
    //   'BCC: '.$dev_Email,
      'X-Mailer: PHP/' . phpversion(),
      'Content-Type: text/html; charset=UTF-8'
  );

  ?>
  <?php ob_start(); ?>
    <p><strong>Name:</strong> <?= $user_Name ?></p>
    <p><strong>E-mail</strong> <?= $user_Email ?></p>
    <p><strong>Phone:</strong> <?= $user_Tel ?></p>
    <p><strong>Product:</strong> <a href="<?= get_permalink($user_Product) ?>"><?= get_the_title($user_Product) ?></a></p>
    <p><strong>Amount:</strong> <?= $user_Amount ?></p>
    <p><strong>Message:</strong> <?= $user_Message ?></p>
    <br><hr><br>
    <?php $htmlcontent = ob_get_clean(); ?>

  <?php

  $sentMail = @wp_mail($to_Email, $subject, $htmlcontent, $headers);

  if(!$sentMail) {
    $output = json_encode(array('type'=>'error', 'text' => __('Hiba történt a küldéskor. Kérlek vedd fel velünk a kapcsolatot emailben vagy telefonon.','marrakesh')));
    die($output);
  } else {

    $resp_headers = 'From: '.$to_Email.'' . "\r\n" .
    'Reply-To: '.$to_Email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $resp_text=__('Kedves','marrakesh').' '.$user_Name.'!'."\r\n\n".
    __('Köszönjük megkeresésedet. Munkatársunk hamarosan jelentkezik elérhetőségeid egyikén.','marrakesh')."\r\n\n".
    'Üdvözlettel'."\r\n".'MARRAKESH Cementlap';
    @wp_mail($user_Email, $resp_subject, $resp_text, $resp_headers);
    $output = json_encode(array('type'=>'message', 'text' => __('Köszönjük megkeresésedet. Munkatársunk hamarosan jelentkezik elérhetőségeid egyikén.','marrakesh')));
    die($output);
  }
}

?>
