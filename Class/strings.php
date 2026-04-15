<?php

// Initialize variables
$text = '';
$lowerText = '';
$result = '';
$masked = '';

// Vowel Checker Logic
if (isset($_POST['check_vowel'])) {
	$text = $_POST['text'] ?? '';
	$lowerText = strtolower($text);

	if (preg_match('/[aeiou]/', $lowerText)) {
		$result = "Lowercase: $lowerText. Vowels found (a, e, i, o, u).";
	} else {
		$result = "Lowercase: $lowerText. No vowels found.";
	}
}

// Phone Masker Logic
if (isset($_POST['mask_phone'])) {
	$phone = $_POST['phone'] ?? '';
	$cleanPhone = preg_replace('/[^0-9]/', '', $phone);

	if (strlen($cleanPhone) === 10) {
		$masked = "Masked: **** **** " . substr($cleanPhone, 6);
	} else {
		$masked = "Error: Enter exactly 10 digits!";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>String & Phone Tools</title>
	<style>
		body { font-family: Arial; margin: 20px; }
		.form-section { margin: 30px 0; padding: 20px; border: 1px solid #ccc; }
		.result { margin-top: 15px; padding: 10px; background: #f0f0f0; }
	</style>
</head>
<body>

	<!-- Vowel Checker Form -->
	<div class="form-section">
		<h2>Check Vowels</h2>
		<form method="post">
			<label for="text">Enter text:</label>
			<input type="text" id="text" name="text" value="<?php echo htmlspecialchars($text); ?>" required>
			<button type="submit" name="check_vowel">Check</button>
		</form>
		<?php if ($result !== ''): ?>
			<div class="result"><?php echo htmlspecialchars($result); ?></div>
		<?php endif; ?>
	</div>

	<!-- Phone Number Masker Form -->
	<div class="form-section">
		<h2>Phone Number Masker</h2>
		<form method="post">
			<label for="phone">Enter 10-digit phone number:</label>
			<input type="text" id="phone" name="phone" placeholder="1234567890" required>
			<button type="submit" name="mask_phone">Mask</button>
		</form>
		<?php if ($masked !== ''): ?>
			<div class="result"><?php echo htmlspecialchars($masked); ?></div>
		<?php endif; ?>
	</div>

</body>
</html>













