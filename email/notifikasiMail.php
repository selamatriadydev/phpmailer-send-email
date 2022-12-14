<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (@$position == 1) {
    require 'email/PHPMailer/src/Exception.php';
    require 'email/PHPMailer/src/PHPMailer.php';
    require 'email/PHPMailer/src/SMTP.php';
} else {
    require '../email/PHPMailer/src/Exception.php';
    require '../email/PHPMailer/src/PHPMailer.php';
    require '../email/PHPMailer/src/SMTP.php';
}

class notifikasiMail{
    public $mail_debug, $mail_host, $mai_port, $mail_auth_username,$mail_auth_password;
    public $mail_from, $mail_from_name, $mail_to, $mail_to_name, $mail_reply, $mail_cc, $mail_comment;
    public $mail_subject,$mail_body,$mail_body_header,$mail_body_header_author,$mail_body_sambutan, $mail_body_ringkasan, $mail_body_informasi, $mail_body_informasi_link;
    public $footer_link_app, $footer_name_app, $footer_release_app;

    public function __construct()
    {
        $this->footer_link_app = "name-app.com";
        $this->footer_name_app = "name app";
        $this->footer_release_app = "2022";
        $this->mail_debug = false;
        $this->mail_auth_username = "name-app-mail@gmail.com";
        $this->mail_auth_password = "password-app";
        $this->mail_host = "tls://smtp.gmail.com";
        $this->mail_port = 587;

        $this->mail_from = "mail-from@gmail.com";
        $this->mail_from_name = "name app";
        $this->mail_to = "";
        $this->mail_to_name = "";

        $this->mail_subject = "Aplikasi name app";
        $this->mail_reply =  "";
        $this->mail_reply_name =  "";
        $this->mail_cc =  [];
        $this->mail_body =  "Email";
        $this->mail_body_header =  "";
        $this->mail_body_sambutan = "Selamat Datang";
        $this->mail_body_author = "Admin";
        $this->mail_body_ringkasan = "";
        $this->mail_body_informasi = "";
        $this->mail_body_informasi_link = "";
    }

    public function mail_debug($debug){
        $this->mail_debug = $debug == true ? true : false ;
    }
    public function mail_subject($mail_subject){
        if($mail_subject){
            $this->mail_subject = $mail_subject;
        }
    }
    public function mail_from_name($mail_from_name){
        $this->mail_from_name = $mail_from_name;
    }
    public function mail_from($mail_from){
        $this->mail_from = $mail_from;
    }
    public function mail_to_name($mail_to_name){
        $this->mail_to_name = $mail_to_name;
    }
    public function mail_to($mail_to){
        $this->mail_to = $mail_to;
    }
    public function mail_reply_name($mail_reply_name){
        $this->mail_reply_name = $mail_reply_name;
    }
    public function mail_reply($mail_reply){
        $this->mail_reply = $mail_reply;
    }
    public function mail_cc($mail_cc = []){
        if( is_array($mail_cc) && count($mail_cc)){
            $set_cc = [];
            foreach($mail_cc as $name=>$mail){
                $set_cc[]=array('name' => $name, 'email' => $mail);
            }
            $this->mail_cc = $set_cc;
        }else{
            echo "Mail cc is array. example : array('name', 'email')"; exit;
        }
    }
    public function mail_body_sambutan($sambutan_awal){
        if($sambutan_awal){
            $this->mail_body_sambutan = $sambutan_awal;
        }
    }
    public function mail_body_header_author($title, $author){
        if($author){
            $title = $title ? $title : 'Tindak lanjut dibuat oleh';
            $header ='<br><span style="float: right;margin-top: 5px;">'.$title.' <b style="font-style: italic;">'.$author.'</b> </span>';
            $this->mail_body_header_author = $header;
        }
    }
    public function mail_body_header($link_logo, $name_app){
        if($link_logo && $name_app){
            $header = '<tr style="background-color:#001e3e">
                    <td style="padding:10px;width: 5%;background: white;"><img style="width:60px;" src="'.$link_logo.'" alt=""></td>
                    <td style="padding:10px;font-weight:bold;font-size: 20pt;color:white">'.$name_app.'</td>
                    <td style="padding:10px;font-weight:bold;font-size: 13pt;color:white;margin-top: 5px;float: right;">
                        <span style="float: right;">'.date('d F Y').' </span>';
                        if($this->mail_body_header_author){
                            $header .=  $this->mail_body_header_author;
                        }
            $header .= '</td>
                </tr>';
            $this->mail_body_header = $header;
        }
    }
    public function mail_body_ringkasan($title, $ringkasan){
        if($ringkasan){
            $title = $title ? $title : 'Ringkasan';
            $ringkasan_html ='<tr>
                                <td colspan="3" style="padding:10px;font-size: 12pt;font-family: arial;font-weight:bold;"></b>'.$title.'</b></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding:10px;font-size: 12pt;font-family: arial;border: 1px solid;">'.$ringkasan.'</td>
                            </tr>';
            $this->mail_body_ringkasan .= $ringkasan_html;
        }
    }
    public function mail_body_informasi($informasi){
        if($informasi){
            $informasi_html ='<tr>
                                <td colspan="3" style="padding:10px;font-size: 12pt;font-family: arial;font-weight:bold;"></b>Informasi</b></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding:10px;font-size: 12pt;font-family: arial;border: 1px solid;">'.$informasi.'</td>
                            </tr>';
            $this->mail_body_informasi = $informasi_html;
        }
    }
    public function mail_body_informasi_link($informasi, $link){
        if($link){
            $informasi = $informasi ? $informasi : 'Sebelum klik silakan login dahulu di aplikasi';
            $link_html ='<tr>
                                <td colspan="3" style="padding:10px;">
                                    Informasi TL <a style="text-decoration: none;"
                                    href="'.$link.'">Klik disini</a> (<span style="color:red">*) '.$informasi.'</span>
                                </td>
                            </tr>';
            $this->mail_body_informasi_link = $link_html;
        }
    }

    public function mail_body( bool $active = false){
        if($active){
        $body_email ='<div style="padding: 20px;background-color:#cac3c3;">
                        <table style="width: 100%;border-collapse: collapse;border: 1px solid white;background-color:white; font-family: roboto-regular">';
                            if($this->mail_body_header){
                                $body_email .=  $this->mail_body_header;
                            }

                $body_email .='<tr>
                                <td colspan="3" style="padding:10px;height: 10px;">&nbsp;</td>
                            </tr>';
                            if($this->mail_body_sambutan){
                            $body_email .=' <tr>
                                        <td colspan="3" style="padding:10px;font-size: 12pt;font-family: arial;">
                                        '.$this->mail_body_sambutan.'
                                        </td>
                                    </tr>';
                            }
                    $body_email .='<tr>
                            <td colspan="3" style="padding:10px;height: 10px;">&nbsp;</td>
                        </tr>';
                        if($this->mail_body_ringkasan){
                            $body_email .=  $this->mail_body_ringkasan;
                        }
                        if($this->mail_body_informasi_link){
                            $body_email .=  $this->mail_body_informasi_link;
                        }
                        if($this->mail_body_informasi){
                            $body_email .=  $this->mail_body_informasi;
                        }

                        if($this->footer_link_app){
                            $body_email .='<tr>
                                <td colspan="3" style="padding:10px;">
                                    <span style="float: right;margin-top: 5px;">
                                    <a href="'.$this->footer_link_app.'" style="text-decoration: none;cursor: pointer;"><b>'.$this->footer_name_app.'</b></a> @'.$this->footer_release_app.'</span>
                                </td>
                            </tr>';
                        }
                        $body_email .=' </table>
                    </div>';
        $this->mail_body = $body_email;
        }
    }

    public function email_send(){
        $mail_from = $this->mail_from;
        $mail_from_name = $this->mail_from_name;

        $mail_to = $this->mail_to;
        $mail_to_name = $this->mail_to_name;

        $mail_reply = $this->mail_reply;
        $mail_reply_name = $this->mail_reply_name;

        $mail_cc = $this->mail_cc;

        $mail_subject = $this->mail_subject;
        $mail_body = $this->mail_body;
        try {
            $mail = new PHPMailer(true);
             // konfig server 
            // SMTP::DEBUG_OFF (0): Disable debugging (you can also leave this out completely, 0 is the default).
            // SMTP::DEBUG_CLIENT (1): Output messages sent by the client.
            // SMTP::DEBUG_SERVER (2): as 1, plus responses received from the server (this is the most useful setting).
            // SMTP::DEBUG_CONNECTION (3): as 2, plus more information about the initial connection - this level can help diagnose STARTTLS failures.
            // SMTP::DEBUG_LOWLEVEL (4): as 3, plus even lower-level information, very verbose, don't use for debugging SMTP, only low-level problems.
            // $this->email->SMTPDebug = SMTP::DEBUG_OFF;     
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                               
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                               
            $mail->isSMTP();
            $mail->Host = $this->mail_host;
            $mail->SMTPAuth = true; 
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );       
            $mail->Username   = $this->mail_auth_username;                     //SMTP username
            $mail->Password   = $this->mail_auth_password;  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = $this->mail_port; 

            $mail->setFrom($mail_from, $mail_from_name);
            if ( !$mail->validateAddress($mail_from) ){
                return "Email from is not valid. Please check your email";
            }
            $mail->addAddress($mail_to, $mail_to_name);
            if ( !$mail->validateAddress($mail_to) ){
                return "Email to is not valid. Please check your email";
            }
            if($mail_reply){
                $mail_reply_name = $mail_reply_name ? $mail_reply_name : 'Pengirim';
                $mail->addReplyTo($mail_reply, $mail_reply_name);
            }
            
            if(is_array($mail_cc) && count($mail_cc)){
                foreach($mail_cc as $cc){
                    $mail->addCC($cc['email'], $cc['name']);
                }
            }
            //Content
            $mail->isHTML(true); 
            $mail->Subject = $mail_subject;
            $mail->Body    = $mail_body;
            $mail->AltBody = "Terima Kasih telah menggunakan aplikasi audit ".$this->footer_name_app;//plain text for non-HTML
            if(!$mail->send()) {
                return "Email send is faild. Email is not valid. Please check your email";
            }else{
                return "Email send is successfully. check your email";

                $mail->ClearAllRecipients();
            }
        } catch (Exception $e) {
            return "Email send is failed. check your email.";
        }
    }


}