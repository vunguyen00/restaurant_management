<?php 
include("config/config.php");

$results = array();

// Execute the first query, excluding ingredients
$query1 = "
    SELECT m.dish_id, m.dish_name, m.price, m.dish_describe
    FROM menu m
";

$results['menu'] = $mysqli->query($query1);

$menuResult = $results['menu'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="foods.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<script src="reloadfood.js"></script>
<body>
    <div class="sidebar">
        <h2>LOGO</h2>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="foods.php">Foods</a></li>
            <li><a href="books.php">Bookings</a></li>
            <li><a href="statistics.php" class="button">Revenue & Dish Statistics</a></li>
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
            <div id="addFoodModal" class="modal">
                <div class="modal-content">
                    <span class="close-add-food">&times;</span>
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
                    <?php if ($menuResult->num_rows > 0): ?>
                        <?php while ($row = $menuResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['dish_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['dish_name']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars($row['dish_describe']); ?></td>
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
    $(document).ready(function() {

        // Modal open and close for food items
        var addFoodModal = document.getElementById("addFoodModal");
        var updateFoodModal = document.getElementById("updateFoodModal");
        var closeAddFoodSpan = document.getElementsByClassName("close-add-food")[0];
        var closeUpdateFoodSpan = document.getElementsByClassName("close-update")[0];

        document.getElementById("openAddFoodModal").onclick = function() {
            addFoodModal.style.display = "block";
        }

        closeAddFoodSpan.onclick = function() {
            addFoodModal.style.display = "none";
        }

        closeUpdateFoodSpan.onclick = function() {
            updateFoodModal.style.display = "none";
        }

        // Open modal to update food item
        document.querySelectorAll('.update-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var price = this.getAttribute('data-price');
                var description = this.getAttribute('data-description');
                openUpdateFoodModal(id, name, price, description);
            }
        });

        function openUpdateFoodModal(id, name, price, description) {
            $('#update_id').val(id);
            $('#update_name').val(name);
            $('#update_price').val(price);
            $('#update_description').val(description);
            updateFoodModal.style.display = "block";
        }

        // Handle update food form
        $('#updateFoodForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "update_food.php",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        // Handle delete food button
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this food item?")) {
                $.ajax({
                    type: "POST",
                    url: "delete_food.php",
                    data: { id: id },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            }
        });

        // Handle add food form
        $('#addFoodForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "add_foods_button.php",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $('#addFoodModal').hide();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });
    });
    </script>
</body>
</html>
