<?php
$position = 1;
// Include library file
require_once 'email/notifikasiMail.php'; 
$notif = new notifikasiMail();

$notif->mail_from_name = "Mamat";
$notif->mail_from = "Mamat@gmail.com";

$notif->mail_to_name = "Mamat";
$notif->mail_to = "bangreymedia@gmail.com";

$notif->mail_reply_name = "Mamat";
$notif->mail_reply = "Mamat@gmail.com";

$notif->mail_reply_name = "Mamat";
$notif->mail_reply = "bangreymedia@gmail.com";

$notif->mail_cc(['mamat' => 'bangreymedia@gmail.com']);
// body 
$notif->mail_subject = "Tindak lanjut baru";
$notif->mail_body_sambutan = "YTH. Bapak/Ibu, admin aplikasi  <b>AMS BKKBN</b>";
$notif->mail_body_header_author("Tindak lanjut dibuat oleh", "mamat");
$notif->mail_body_header("cc", "mamat");
$notif->mail_body_ringkasan("ringkasan 1", "isi ringkasan");
$notif->mail_body_ringkasan("ringkasan 2", "isi ringkasan");
$notif->mail_body_informasi("isi ringkasan");
$notif->mail_body_informasi_link("isi ringkasan", "ams.com");
$notif->mail_body(true);

echo $notif->email_send();

?>