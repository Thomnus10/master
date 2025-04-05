<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #1B5E20, #388E3C);
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            color: white;
            transition: width 0.3s ease-in-out;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h4 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .nav-link {
            color: white;
            padding: 12px;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 18px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-link.active {
            background: #2E7D32;
            font-weight: bold;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .brand-title {
            font-weight: bold;
            color: #2E7D32;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4>POS Groceries</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i> Home</a></li>
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.inventory') }}" class="nav-link active"><i class="bi bi-box-seam"></i> Inventory</a></li>
        <li class="nav-item"><a href="{{ route('admin.suppliers') }}" class="nav-link"><i class="bi bi-person"></i> Suppliers</a></li>
        <li class="nav-item"><a href="{{ route('admin.products') }}" class="nav-link"><i class="bi bi-box"></i> Products</a></li>
        <li class="nav-item"><a href="{{ route('admin.transaction') }}" class="nav-link"><i class="bi bi-receipt"></i> Transactions</a></li>
        <li class="nav-item"><a href="{{ route('admin.user') }}" class="nav-link"><i class="bi bi-people"></i> Users</a></li>
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="brand-title">Inventory Management</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle"></i> Add Product
            </button>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search product..."
                onkeyup="searchTable()">

            <!-- Inventory Table -->
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="inventoryTable">
                    <tr>
                        <td>1</td>
                        <td>Rice</td>
                        <td>Grains</td>
                        <td>100</td>
                        <td>₱50</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Milk</td>
                        <td>Dairy</td>
                        <td>50</td>
                        <td>₱70</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Eggs</td>
                        <td>Poultry</td>
                        <td>200</td>
                        <td>₱10</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" placeholder="Enter product name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" placeholder="Enter category" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" placeholder="Enter stock quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" placeholder="Enter price" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addProduct()">Save Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Product -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" placeholder="Enter product name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="editCategory" placeholder="Enter category" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editStock" placeholder="Enter stock quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" placeholder="Enter price" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateProduct()">Update Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let currentRow;

        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("inventoryTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let columns = rows[i].getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < columns.length; j++) {
                    if (columns[j].innerText.toLowerCase().includes(input)) {
                        found = true;
                        break;
                    }
                }

                rows[i].style.display = found ? "" : "none";
            }
        }

        function addProduct() {
            const productName = document.getElementById("productName").value;
            const category = document.getElementById("category").value;
            const stock = document.getElementById("stock").value;
            const price = document.getElementById("price").value;

            const newRow = document.createElement("tr");
            newRow.innerHTML = `<td>${document.getElementById("inventoryTable").rows.length + 1}</td>
                                <td>${productName}</td>
                                <td>${category}</td>
                                <td>${stock}</td>
                                <td>₱${price}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editProduct(this)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button>
                                </td>`;

            document.getElementById("inventoryTable").appendChild(newRow);
            document.querySelector("#addProductModal .btn-close").click();
            document.getElementById("addProductForm").reset();
        }

        function editProduct(button) {
            currentRow = button.closest("tr");
            const cells = currentRow.getElementsByTagName("td");
            document.getElementById("editProductName").value = cells[1].innerText;
            document.getElementById("editCategory").value = cells[2].innerText;
            document.getElementById("editStock").value = cells[3].innerText;
            document.getElementById("editPrice").value = cells[4].innerText.replace('₱', '');

            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        }

        function updateProduct() {
            const productName = document.getElementById("editProductName").value;
            const category = document.getElementById("editCategory").value;
            const stock = document.getElementById("editStock").value;
            const price = document.getElementById("editPrice").value;

            currentRow.cells[1].innerText = productName;
            currentRow.cells[2].innerText = category;
            currentRow.cells[3].innerText = stock;
            currentRow.cells[4].innerText = `₱${price}`;

            document.querySelector("#editProductModal .btn-close").click();
            document.getElementById("editProductForm").reset();
        }

        function deleteProduct(button) {
            const row = button.closest("tr");
            row.parentNode.removeChild(row);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>