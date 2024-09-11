<?php 
include("config/config.php");

// Lấy dữ liệu từ cơ sở dữ liệu
$query = "SELECT dish_id, dish_name, price, dish_describe FROM menu";
$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="foods.css">
</head>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="foods.php">Foods</a></li>
            <li><a href="books.php">Bookings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <a href="#">Home</a>
            <span>admin</span>
        </div>

        <div class="foods-section">
            <h2>Foods</h2>
            <button class="create-btn" id="openAddFoodModal">Add Food</button>
            <!-- The Modal -->
            <div id="addFoodModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add New Food</h2>
                    <form id="addFoodForm">
                        <label for="name">Food Name:</label>
                        <input type="text" id="name" name="name" required>
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" required>
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"></textarea>
                        <button type="submit">Add Food</button>
                    </form>
                </div>
            </div>
            <!-- The Update Modal -->
            <div id="updateFoodModal" class="modal">
                <div class="modal-content">
                    <span class="close-update">&times;</span>
                    <h2>Update Food</h2>
                    <form id="updateFoodForm">
                        <input type="hidden" id="update_id" name="id">
                        <label for="update_name">Food Name:</label>
                        <input type="text" id="update_name" name="name" required>
                        <label for="update_price">Price:</label>
                        <input type="number" id="update_price" name="price" required>
                        <label for="update_description">Description:</label>
                        <textarea id="update_description" name="description"></textarea>
                        <button type="submit">Update Food</button>
                    </form>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Describe</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['dish_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['dish_name']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars(string:$row['dish_describe'])?></td>
                                <td><button class="update-btn" data-id="<?php echo htmlspecialchars($row['dish_id']); ?>" data-name="<?php echo htmlspecialchars($row['dish_name']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" data-description="<?php echo htmlspecialchars($row['dish_describe']); ?>">Update</button></td>
                                <td><button class="delete-btn" data-id="<?php echo htmlspecialchars($row['dish_id']); ?>">Delete</button></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No food items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("addFoodModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openAddFoodModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Handle form submission
        document.getElementById("addFoodForm").onsubmit = function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);
            
            fetch('add_foods_button.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                modal.style.display = "none";
                location.reload(); // Reload the page to update the table
            })
            .catch(error => console.error('Error:', error));
        }

        // Handle delete button click
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this item?')) {
                    fetch('delete_food.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload(); // Reload the page to update the table
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
        var updateModal = document.getElementById("updateFoodModal");

    // Get the <span> element that closes the update modal
        var closeUpdateSpan = document.getElementsByClassName("close-update")[0];

        // Function to open the update modal and populate with existing food data
        function openUpdateModal(id, name, price, description) {
            document.getElementById("update_id").value = id;
            document.getElementById("update_name").value = name;
            document.getElementById("update_price").value = price;
            document.getElementById("update_description").value = description;
            updateModal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the update modal
        closeUpdateSpan.onclick = function() {
            updateModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == updateModal) {
                updateModal.style.display = "none";
            }
        }

        // Handle form submission for update
        document.getElementById("updateFoodForm").onsubmit = function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);
            
            fetch('update_food.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                updateModal.style.display = "none";
                location.reload(); // Reload the page to update the table
            })
            .catch(error => console.error('Error:', error));
        }

        // Handle update button click
        document.querySelectorAll('.update-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var price = this.getAttribute('data-price');
                var description = this.getAttribute('data-description');
                openUpdateModal(id, name, price, description);
            }
        });

        // Handle delete button click
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this item?')) {
                    fetch('delete_food.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + encodeURIComponent(id)
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload(); // Reload the page to update the table
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
    </script>
</body>
</html>
