<?php
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "pharmacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "INSERT INTO medicines (id, name, price) VALUES ('$id', '$name', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "Medicine added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle selling medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'sell') {
    $id = $_POST['id'];
    $sql = "DELETE FROM medicines WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Medicine sold successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch medicines
$sql = "SELECT * FROM medicines";
$result = $conn->query($sql);
$medicines = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <base href="http://pharmacymanager.local/">
    <title>Pharmacy Management System</title>
    <link rel="icon" type="image/svg+xml" href="#pharmacyIcon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Add the CSS styles from your original code here */
    </style>
</head>
<body>
    <!-- Include the SVG icon and navbar from your original code here -->

    <div class="main-container">
        <aside class="sidebar">
            <div class="button-group">
                <form method="POST" onsubmit="return validateAdd();">
                    <input type="hidden" name="action" value="add">
                    <input type="text" name="id" placeholder="Medicine ID" required>
                    <input type="text" name="name" placeholder="Medicine Name" required>
                    <input type="number" name="price" placeholder="Medicine Price" required>
                    <button type="submit" class="primary-btn">Add Medicine</button>
                </form>
            </div>

            <div class="money-tracker">
                <h3>Total Revenue</h3>
                <div class="amount">$<span id="totalMoney">0</span></div>
            </div>
        </aside>

        <main class="medicine-list">
            <h2>Medicine Inventory</h2>
            <div id="medicineItems">
                <?php if (empty($medicines)): ?>
                    <div class="empty-state">No medicines in inventory. Add some medicines to get started!</div>
                <?php else: ?>
                    <div class="medicine-item medicine-header">
                        <div>ID</div>
                        <div>Name</div>
                        <div>Price</div>
                    </div>
                    <?php foreach ($medicines as $medicine): ?>
                        <div class="medicine-item" data-id="<?= $medicine['id'] ?>">
                            <div><?= $medicine['id'] ?></div>
                            <div><?= $medicine['name'] ?></div>
                            <div>$<?= number_format($medicine['price'], 2) ?></div>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="sell">
                                <input type="hidden" name="id" value="<?= $medicine['id'] ?>">
                                <button type="submit" class="sell-button">Sell Medicine</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        // Include the JavaScript code from your original code here
    </script>
</body>
</html>
