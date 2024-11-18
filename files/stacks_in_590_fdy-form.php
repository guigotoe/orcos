<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require 'phpmailer/Exception.php';
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';

	// Initialize body of email
	$body = " "; 

	$postdata = array();
	foreach($_POST as $name => $value) {
		// Copy $_POST to data array and convert array values to strings
		$postdata[$name] = is_array($value) ? implode(", " , $value) : $value;

		if ( ($name != "stacks_in_590-subject")   && ($name != "stacks_in_590-form-submit") && ($name != "MAX_FILE_SIZE") && ($name != "stacks_in_590-human") && ($name != "hc__value") && ($name != "csrfToken")) {
			
			$bodyContent = nl2br($value);
						
			// Incrementally add field data to email body
			$body .= "$bodyContent";
			$body .= "<br>";			
		}
			
	}

    
	$fullname = 'Form Submission';
	
	
	$email = '';
	
    	
	$replytoName = 'Form Submission';
	
	$replytoEmail = $postdata['stacks_in_590-visitor-email'];

	$subject = $postdata['stacks_in_590-subject'];

	if(isset($_POST['csrfToken'])) {
		if (($_POST['csrfToken'] == $_SESSION['fdyFormToken']) && ($_POST['hc__value'] == '')) {
			$mail = new PHPMailer();
			$mail->CharSet = 'UTF-8';
			
			
			$mail->isSMTP();
			$mail->Host = '';
			$mail->SMTPAuth = true;
			$mail->Username = ''; 
			$mail->Password = '';
			$mail->SMTPSecure = 'ssl';
			$mail->Port = ;
			
		
			// Email FROM
			
			$mail->setFrom($email, $fullname);
			
			
			// ReplyTo Address
			$mail->addReplyTo($replytoEmail, $replytoName);
		
			// Recipient
			$mail->addAddress('', '');
		
			
			
			
	
			
	
			
		
			
		
		
			if (isset($_FILES['stacks_in_590-uploaded_file']) &&
				$_FILES['stacks_in_590-uploaded_file']['error'] == UPLOAD_ERR_OK) {
				$mail->AddAttachment($_FILES['stacks_in_590-uploaded_file']['tmp_name'], $_FILES['stacks_in_590-uploaded_file']['name']);
			}
		
			$mail->Subject = $subject;
			
			$mail->isHTML(true);
			
			$mailContent = $body;
							
			$mail->Body = $mailContent;
		
			// Templated body example
			// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
		
			// Send our email
			if($mail->send()){
				// Success
    			echo '<div class="mt-3 alert stacks_in_590-success fdy-shadow stacks_in_590-animated-success"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg> Your wallet has been registered successfully, and you’re now eligible for exclusive ORCS rewards based on your holdings </div>';
			}else{
				// Failure
    			echo '<div class="mt-3 alert alert-danger fdy-shadow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 18 18"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/></svg> Message could not be sent.<br>';
    			echo 'An error occurred sending your message.<br><strong>Error:</strong> ' . $mail->ErrorInfo . '</div>';
			}
	
		} else {
			// Failure - Tokens don't match or honeypot was filled.
			echo '<div class="mt-3 alert alert-danger fdy-shadow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 18 18"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/></svg> Tokens do not match.</div>';
		}
	}
	
?>

