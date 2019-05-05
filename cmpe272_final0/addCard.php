<?php 
require_once('dbConnection.php');
session_start();

try {
$cardTable = "CREATE TABLE myCard (card_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY, card_number int(9) NOT NULL, card_code int(3) NOT NULL, user_name VARCHAR(100) NOT NULL)";
mysqli_query($conn, $cardTable);
} catch(Exception $e) {
	$e->getMessage();
}

$card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
$card_code = mysqli_real_escape_string($conn, $_POST['card_code']);
$user_name = $_SESSION['name'];

if(isset($user_name)) echo "Hello, ".$user_name;

	if(isset($_POST['add'])) {
		$authCard = mysqli_query($conn, "SELECT * FROM myCard WHERE card_number ='$card_number' AND card_code = $card_code");
			if(!mysqli_fetch_assoc($authCard)) { 
				$insertCard = "INSERT INTO myCard (card_number, card_code, user_name) VALUES ('$card_number', '$card_code', '$user_name')";
				mysqli_query($conn, $insertCard);
			}
	}
	mysqli_close($conn);
?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Card</title>
 </head>
 <body>
 	<h1>Add Card</h1>
 	<form method = "post" action = "addCard.php">
 	Card Number: <input type="text" name="card_number" pattern="[0-9]{9}" placeholder="9 digits" maxlength="9" required>
 	Card Code: <input type="text" name="card_code" pattern="[0-9]{3}" placeholder="3 digits" maxlength="3" required>
	<input type="submit" name="add" value="Add">
	</form>
	<a href="viewCard.php">
		<button>View Card</button>
	</a>
	<a href="logout.php">
		<button>Logout</button>
	</a>
 </body>
 </html>