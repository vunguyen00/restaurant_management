<?php 
include("config/config.php");

$results = array();

// Thực thi câu lệnh đầu tiên
$query1 = "
    SELECT m.dish_id, m.dish_name, m.price, m.dish_describe, 
           GROUP_CONCAT(i.ingredient_name SEPARATOR ', ') AS ingredients,
           MIN(i.quantity) AS min_quantity
    FROM menu m
    LEFT JOIN dish_ingredients di ON m.dish_id = di.dish_id
    LEFT JOIN ingredients i ON di.ingredient_id = i.ingredient_id
    GROUP BY m.dish_id
    HAVING min_quantity > 0
";

$results['menu'] = $mysqli->query($query1);

// Thực thi câu lệnh thứ hai
$query2 = "SELECT ingredient_id, ingredient_name,quantity FROM ingredients";
$results['ingredients'] = $mysqli->query($query2);

$menuResult = $results['menu'];
$ingredientsResult = $results['ingredients'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="foods.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
                        <label for="ingredients">Select Ingredients:</label>
                        <select name="ingredients[]" multiple style="width: 100px;" required class="select2">
                            <?php while ($row = $ingredientsResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['ingredient_id']); ?>"><?php echo htmlspecialchars($row['ingredient_name']); ?></option>
                            <?php endwhile; ?>
                        </select>
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
                        <label for="update_ingredients">Select Ingredients:</label>
                        <select id="update_ingredients" name="ingredients[]" multiple required class="select2">
                            <?php 
                            $ingredientsResult->data_seek(0); // Reset pointer
                            while ($row = $ingredientsResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($row['ingredient_id']); ?>">
                                    <?php echo htmlspecialchars($row['ingredient_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
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
                        <th>Ingredients</th>
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
                                <td><?php echo htmlspecialchars($row['ingredients']); ?></td>
                                <td><button class="update-btn" data-id="<?php echo htmlspecialchars($row['dish_id']); ?>" data-name="<?php echo htmlspecialchars($row['dish_name']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>" data-description="<?php echo htmlspecialchars($row['dish_describe']); ?>" data-ingredients='[<?php echo implode(',', array_map('intval', explode(', ', $row['ingredients']))); ?>]'>Update</button></td>
                                <td><button class="delete-btn" data-id="<?php echo htmlspecialchars($row['dish_id']); ?>">Delete</button></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No food items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="ingredients-section">
                <h2>Ingredients</h2>
                <button class="create-btn" id="openAddIngredientModal">Add Ingredient</button>

                <div id="addIngredientModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Add New Ingredient</h2>
                        <form id="addIngredientForm">
                            <label for="ingredient_name">Ingredient Name:</label>
                            <input type="text" id="ingredient_name" name="ingredient_name" required>
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" required>
                            <button type="submit">Add Ingredient</button>
                        </form>
                    </div>
                </div>

                <div id="updateIngredientModal" class="modal">
                    <div class="modal-content">
                        <span class="close-update">&times;</span>
                        <h2>Update Ingredient</h2>
                        <form id="updateIngredientForm">
                            <input type="hidden" id="update_ingredient_id" name="ingredient_id">
                            <label for="update_ingredient_name">Ingredient Name:</label>
                            <input type="text" id="update_ingredient_name" name="ingredient_name" required>
                            <label for="update_quantity">Quantity:</label>
                            <input type="number" id="update_quantity" name="quantity" required>
                            <button type="submit">Update Ingredient</button>
                        </form>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ingredient Name</th>
                            <th>Quantity</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $ingredientsResult->data_seek(0); // Reset pointer
                        if ($ingredientsResult->num_rows > 0) {
                            while ($row = $ingredientsResult->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['ingredient_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ingredient_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td><button class="update-ingredient-btn" data-id="<?php echo htmlspecialchars($row['ingredient_id']); ?>" data-name="<?php echo htmlspecialchars($row['ingredient_name']); ?>" data-quantity="<?php echo htmlspecialchars($row['quantity']); ?>">Update</button></td>
                                    <td><button class="delete-ingredient-btn" data-id="<?php echo htmlspecialchars($row['ingredient_id']); ?>">Delete</button></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No ingredients found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.select2').select2();

        // Modal mở và đóng cho món ăn
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

        // Mở modal cập nhật món ăn
        document.querySelectorAll('.update-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var price = this.getAttribute('data-price');
                var description = this.getAttribute('data-description');
                var ingredients = JSON.parse(this.getAttribute('data-ingredients'));
                openUpdateFoodModal(id, name, price, description, ingredients);
            }
        });

        function openUpdateFoodModal(id, name, price, description, ingredients) {
            $('#update_id').val(id);
            $('#update_name').val(name);
            $('#update_price').val(price);
            $('#update_description').val(description);
            $('#update_ingredients').val(ingredients).trigger('change');
            updateFoodModal.style.display = "block";
        }

        // Xử lý form cập nhật món ăn
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

        // Xử lý nút xóa món ăn
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

        // Modal mở và đóng cho nguyên liệu
        var addIngredientModal = document.getElementById("addIngredientModal");
        var updateIngredientModal = document.getElementById("updateIngredientModal");
        var closeAddIngredientSpan = document.getElementsByClassName("close")[0];
        var closeUpdateIngredientSpan = document.getElementsByClassName("close-update")[1];

        document.getElementById("openAddIngredientModal").onclick = function() {
            addIngredientModal.style.display = "block";
        }

        closeAddIngredientSpan.onclick = function() {
            addIngredientModal.style.display = "none";
        }

        closeUpdateIngredientSpan.onclick = function() {
            updateIngredientModal.style.display = "none";
        }
        // Xử lý form thêm món ăn
    $('#addFoodForm').on('submit', function(event) {
        event.preventDefault(); // Ngăn gửi form mặc định

        $.ajax({
            type: "POST",
            url: "add_foods_button.php",
            data: $(this).serialize(), // Gửi dữ liệu
            success: function(response) {
                alert(response); // Hiển thị thông báo
                $('#addFoodModal').hide(); // Đóng modal
                location.reload(); // Tải lại trang
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error); // Hiển thị lỗi
            }
        });
    });

    // Xử lý form thêm nguyên liệu
    $('#addIngredientForm').on('submit', function(event) {
        event.preventDefault(); // Ngăn gửi form mặc định

        $.ajax({
            type: "POST",
            url: "add_ingredient.php",
            data: $(this).serialize(), // Gửi dữ liệu
            success: function(response) {
                alert(response); // Hiển thị thông báo
                $('#addIngredientModal').hide(); // Đóng modal
                location.reload(); // Tải lại trang
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error); // Hiển thị lỗi
            }
        });
    });


        // Mở modal cập nhật nguyên liệu
        document.querySelectorAll('.update-ingredient-btn').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var quantity = this.getAttribute('data-quantity');
                openUpdateIngredientModal(id, name, quantity);
            }
        });

        function openUpdateIngredientModal(id, name, quantity) {
            $('#update_ingredient_id').val(id);
            $('#update_ingredient_name').val(name);
            $('#update_quantity').val(quantity);
            updateIngredientModal.style.display = "block";
        }

        // Xử lý form cập nhật nguyên liệu
        $('#updateIngredientForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "update_ingredient.php",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        // Xử lý nút xóa nguyên liệu
        $('.delete-ingredient-btn').click(function() {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this ingredient?")) {
                $.ajax({
                    type: "POST",
                    url: "delete_ingredient.php",
                    data: { id: id },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
