<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'brain.reader@gmail.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfuly!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm.. seems there is a problem, sorry!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if (
    !isset($_POST['contact-name']) || 
    empty($_POST['contact-name'])  
	
) {
	
	if( empty($_POST['contact-name']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );
	} else {

		$fields = "";
		if( !isset( $_POST['contact-name'] ) || empty( $_POST['contact-name'] ) ) {
			$fields .= "Name";
		}
		
		$json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
		echo json_encode( $json_arr );

	}

} else {

	// Validate e-mail
	if (!preg_match("/^[a-zA-Z ]*$/",$_POST['contact-name']) == false ) {
		
		$msg = "Name: ".$_POST['contact-name']."\r\n";
		if( isset( $_POST['contact-phone'] ) && $_POST['contact-phone'] != '' ) {	$msg .= "Phone: ".$_POST['contact-phone']."\r\n";	}
		if( isset( $_POST['textarea-message'] ) && $_POST['textarea-message'] != '' ) {	$msg .= "Message: ".$_POST['textarea-message']."\r\n";	}
		
		$success = @mail($mailTo, $_POST['contact-name'], $msg, 'From: ' . $_POST['contact-name'] . '<' . $_POST['contact-name'] . '>');
		
		if ($success) {
			$json_arr = array( "type" => "success", "msg" => $successMsg );
			echo json_encode( $json_arr );
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Please enter name only letters and white space!" );
		echo json_encode( $json_arr );	
	}

}