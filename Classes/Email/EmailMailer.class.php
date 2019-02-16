<?php
namespace Classes\Email;
require_once "vendor/autoload.php";


//Import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;


class EmailMailer{
        public function enviar($emailUsuario, $nome, $codigo){
                //Create a new PHPMailer instance
            $mail = new PHPMailer;

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;

            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "danielcost9009@gmail.com";

            //Password to use for SMTP authentication
            $mail->Password = "LordDaniel";

            //Set who the message is to be sent from
            $mail->setFrom('danielcost9009@gmail.com', 'Churros');

            //Set an alternative reply-to address
            //$mail->addReplyTo('replyto@example.com', 'First Last');

            //Set who the message is to be sent to
            $mail->addAddress($emailUsuario, $nome);

            //Set the subject line
            $mail->Subject = 'Recuperar Senha';

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($this->htmlEmail($codigo), __DIR__);

            //Replace the plain text body with one created manually
            $mail->AltBody = 'Ops, houve um erro';

            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                throw new \Exception("Não foi possível enviar o email", 1123);
                
            } else {
               return true;
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                #if (save_mail($mail)) {
                #    echo "Message saved!";
                #}
            }
        }

        public function htmlEmail($codigo){
            $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <meta charset="UTF-8"/>
              <meta http-equiv="Content-Type" content="text/plain; charset=utf-8"/>
              <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
              <meta name="MobileOptimized" content="320" />
              <meta name="HandHeldFriendly" content="true" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <style type="text/css">
                table {
                  border-collapse:collapse !important	
                }
                /*MOBILE*/
                @media only screen and (max-width: 600px){
                  .tableFull, .tableHAlf {
                    width:100% !important;
                    
                  }
                  .mobileContainer{
                    max-width: 90% !important;
                    align:center !important}
                  }
                  /*DESKTOP*/
                  @media only screen and (min-width: 481px){
                    
                    
                  }
                </style>
                <!--[if mso]>
                  <style type="text/css">
                    .tableFull {
                      width:600px !important;
                    }
                    .tableHAlf {
                      width:300px !important;
                    }
                  </style>
                  <![endif]-->
                  <title>S.O.S Cidad&atilde;o - redefinir senha</title>
                </head>
                <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" bgcolor="#009688" style="height:100%; width:100%; min-width:100%; margin:0; padding:0; background-color:#009688;">
                  
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                      <tr>
                        <td>
                          <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#009688" style="min-width:300px;" class="tableFull">
                            <tbody>
                              <tr>
                                <td height="20" style="height: 20px; line-height: 20px; font-size: 0">
                                  &nbsp;
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        
                        <td align="center">
                          
                          <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="min-width:300px; border-radius: 6px;background-color:#fff " class="tableFull mobileContainer">
                            <tbody>
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull">
                                    <tbody>
                                      <tr>
                                        <td height="20" style="height: 20px; line-height: 20px; font-size: 0">
                                          &nbsp;
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" class="tableFull" style="background-color:#fff">
                                    <tbody>
                                      
                                      <tr>
                                       
                                        <td>
                                          
                                          <table width="580"  cellpadding="0" cellspacing="0" border="0" align="center" style="margin: 0 auto"  class="tableFull">
                                            <tbody>
                                              <tr>
                                                <td align="center">
                                                  <img align="center" src="http://soscidadao.online/view/imagens/logo_oficial.png" width="120" style="max-width:120px; max-height: 64px; width: 100%; margin: 0 auto; display:block;" alt="#">
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" class="tableFull" style="background-color:#fff">
                                    <tbody>
                                      <tr>
                                        <td>
                                          <table cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull" style="border-bottom: 1px solid #e2e2e2; max-width: 80%; width: 90% ;background-color:#fff" >
                                            <tbody>
                                              <tr>
                                                <td height="15" style="height: 15px; line-height: 15px; font-size: 0">
                                                  &nbsp;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull" style="background-color:#fff">
                                    <tbody>
                                      <tr>
                                        <td height="45" style="height: 45px; line-height: 45px; font-size: 0">
                                          &nbsp;
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              
                              <!--MIOLO-->
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull" style="background-color:#fff">
                                    <tbody>
                                      <tr>
                                        <td>
                                          <table width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull" style="max-width: 90%; text-align: center;">
                                            <tbody>
                                              <tr>
                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px">
                                                  <strong style="font-size:22px; color: #303030">ESQUECEU</strong><br>
                                                  <strong style="font-size:18px;color: #303030 ">A SUA SENHA?</strong>
                                                  <br><br><br>
                                                  <span style="font-size: 15px; color: #292929">N&atilde;o se preocupe, clique no bot&atilde;o abaixo para trocar a sua senha.</span>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull">
                                            <tbody>
                                              <tr>
                                                <td height="35" style="height: 35px; line-height: 35px; font-size: 0">
                                                  &nbsp;
                                                </td>
                                              </tr>
                                            </tbody>
                                            </table>
                                          <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull">
                                              <tbody>
                                                <tr>
                                                  <td>
                                                    <table align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto">
                                                      <tr>
                                                        <td align="center" style="border-radius: 3px; display: block; height: 45px; width: 150px" bgcolor="#EF3C1E">
                                                          <a href="localhost/RepositorioTcc/TCC/redefinir-senha/'.$codigo.'" target="_blank" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #fff; text-decoration: none; border-radius: 3px; display: block; height: 45px; line-height: 45px; width: 150px">Trocar senha</a>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull">
                                            <tbody>
                                              <tr>
                                                <td height="35" style="height: 35px; line-height: 35px; font-size: 0">
                                                  &nbsp;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  
                                </td>
                              </tr>
                              <!--FIM MIOLO-->
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#009688" style="min-width:300px;" class="tableFull">
                            <tbody>
                              <tr>
                                <td height="10" style="height: 10px; line-height: 10px; font-size: 0">
                                  &nbsp;
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#009688" style="min-width:300px;" class="tableFull">
                            <tbody>
                              <tr>
                                <td>
                                  <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull">
                                    <tbody>
                                      <tr>
                                        <td>
                                          <table width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="tableFull" style="max-width: 90%; text-align: center;">
                                            <tbody>
                                              <tr>
                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color: white">
                                                  Se n&atilde;o pediu a redefini&ccedil;&atilde;o de senha ignore esse e-mail
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#009688" style="min-width:300px;" class="tableFull">
                            <tbody>
                              <tr>
                                <td height="10" style="height: 10px; line-height: 10px; font-size: 0">
                                  &nbsp;
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      
                      
                      
                      
                    </tbody>
                    
                  </table>
                  
                </body>
                </html>
            ';
            return $html;
        }
      

        // //Section 2: IMAP
        // //IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
        // //Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
        // //You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
        // //be useful if you are trying to get this working on a non-Gmail IMAP server.
        // function save_mail($mail)
        // {
        //     //You can change 'Sent Mail' to any other folder or tag
        //     $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

        //     //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
        //     $imapStream = imap_open($path, $mail->Username, $mail->Password);

        //     $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        //     imap_close($imapStream);
        //     //return $result;
        // }
} 
