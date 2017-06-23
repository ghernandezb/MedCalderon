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
 $mailTo     = 'mjcalderon@medcalderon.com';

 /**
  * Set the message that will be shown on success
  */
 $successMsg = 'Gracias, su mensaje ha sido enviado.';

 /**
  * Set the message that will be shown if not all fields are filled
  */
 $fillMsg    = 'Por favor llene todos los espacios';

 /**
  * Set the message that will be shown on error
  */
 $errorMsg   = 'Ha ocurrido un problema, no se ha enviado la informacion';

 /**
  * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
  */

?>
<?php
if(
    !isset($_POST['patient-name']) ||
	!isset($_POST['patient-email']) ||
	!isset($_POST['patient-date']) ||
	!isset($_POST['patient-time']) ||
	!isset($_POST['patient-department']) ||
	!isset($_POST['patient-message']) ||
	empty($_POST['patient-name']) ||
	empty($_POST['patient-email']) ||
	empty($_POST['patient-date']) ||
	empty($_POST['patient-time']) ||
	empty($_POST['patient-department']) ||
	empty($_POST['patient-message'])
) {

	if( empty($_POST['patient-name']) && empty($_POST['patient-email']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );
	} else {

		$fields = "";
		if( !isset( $_POST['patient-name'] ) || empty( $_POST['patient-name'] ) ) {
			$fields .= "Name";
		}

		if( !isset( $_POST['patient-email'] ) || empty( $_POST['patient-email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Email";
			} else {
				$fields .= ", Email";
			}
		}

		if( !isset( $_POST['patient-date'] ) || empty( $_POST['patient-date'] ) ) {
			if( $fields == "" ) {
				$fields .= "Day";
			} else {
				$fields .= ", Day";
			}
		}

		if( !isset( $_POST['patient-time'] ) || empty( $_POST['patient-time'] ) ) {
			if( $fields == "" ) {
				$fields .= "Time";
			} else {
				$fields .= ", Time";
			}
		}

		if( !isset( $_POST['patient-department'] ) || empty( $_POST['patient-department'] ) ) {
			if( $fields == "" ) {
				$fields .= "Department";
			} else {
				$fields .= ", Department";
			}
		}

		if( !isset( $_POST['patient-message'] ) || empty( $_POST['patient-message'] ) ) {
			if( $fields == "" ) {
				$fields .= "Message";
			} else {
				$fields .= ", Message";
			}
		}

		$json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
		echo json_encode( $json_arr );

	}

} else {

	// Validate e-mail
	if (!filter_var($_POST['patient-email'], FILTER_VALIDATE_EMAIL) === false) {

		$msg = "Name: ".$_POST['patient-name']."\r\n";
		$msg .= "Email: ".$_POST['patient-email']."\r\n";
		$msg .= "Day: ".$_POST['patient-date']."\r\n";
		$msg .= "Time: ".$_POST['patient-time']."\r\n";
		$msg .= "Department: ".$_POST['patient-department']."\r\n";
		$msg .= "Message: ".$_POST['patient-message']."\r\n";


		$success = @mail($mailTo, $_POST['patient-email'], $msg, 'From: ' . $_POST['patient-name'] . '<' . $_POST['patient-email'] . '>');

		if ($success) {
			$json_arr = array( "type" => "success", "msg" => $successMsg );
			echo json_encode( $json_arr );
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}

	} else {
 		$json_arr = array( "type" => "error", "msg" => "Por favor ingrese un correo electronico valido" );
		echo json_encode( $json_arr );
	}

}
