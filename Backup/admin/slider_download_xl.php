<?php include_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'config.php') ?>

<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	//Server settings
	$phpmailer = new PHPMailer();
	$phpmailer->isSMTP();
	$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
	$phpmailer->SMTPAuth = true;
	$phpmailer->Port = 2525;
	$phpmailer->Username = '3d21ac294262a2';
	$phpmailer->Password = 'b10c2a219e8409';                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>
<?php

$dataSlides = file_get_contents($datasource . DIRECTORY_SEPARATOR . 'slideritems.json');
$slides = json_decode($dataSlides);



$slidesHTMLStart = <<<SLIDE


<h1> All Sliders </h1>

<table  border="1"  style="border-collapse:collapse; width:700px; text-align: center;">
							<thead>
								<tr>
									<th>#</th>
									<th>Title</th>
									
									<th>Alt</th>
									<th>Caption</th>
									<th>Src</th>
									
								</tr>
							</thead>
							<tbody>



SLIDE;

?>
<?php
$slideHTMLContent = null;
$src = null;
foreach ($slides as $key => $slide) :
    $ser = ++$key;
    $src = $webroot . "uploads/" . $slide->src;
    $slideHTMLContent .= <<<TR

			<tr>
				<td title="$slide->uuid">$ser</td>
				<td>$slide->title</td>
				
				<td>$slide->alt</td>
				<td>$slide->caption</td>
				<td><img src="$src" style="width:100px;height:100px"></td>
				
			</tr>

	TR;

endforeach;

$slideHTMLEnd = <<<EOF
			</tbody>
			</table>
	

	EOF;


$slideHTMLList = $slidesHTMLStart . $slideHTMLContent . $slideHTMLEnd;

//echo $slideHTMLList;



$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($slideHTMLList);
$mpdf->Output();
?> 