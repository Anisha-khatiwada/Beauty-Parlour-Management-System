<?php
$aptno = $_GET['aptno'] ?? 0;
?>

<!DOCTYPE html>
<html>
<body>

<h2>Proceed to Payment</h2>

<form action="pay.php" method="GET">
    <input type="hidden" name="aptno" value="<?= $aptno ?>">
    <button type="submit">Pay with eSewa</button>
</form>

</body>
</html>