<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - Product</title>
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
        <li class="nav-item"><a href="{{ route('admin.inventory') }}" class="nav-link"><i class="bi bi-box-seam"></i> Inventory</a></li>
        <li class="nav-item"><a href="{{ route('admin.suppliers') }}" class="nav-link"><i class="bi bi-person"></i> Suppliers</a></li>
        <li class="nav-item"><a href="{{ route('admin.products') }}" class="nav-link"><i class="bi bi-box"></i> Products</a></li>
        <li class="nav-item"><a href="{{ route('admin.transaction') }}" class="nav-link"><i class="bi bi-receipt"></i> Transactions</a></li>
        <li class="nav-item"><a href="{{ route('admin.user') }}" class="nav-link"><i class="bi bi-people"></i> Users</a></li>
        <!-- Added Purchase Sidebar Item -->
        <li class="nav-item"><a href="{{ route('admin.purchase') }}" class="nav-link"><i class="bi bi-cart"></i> Purchase</a></li>
        <!-- Added Expenses Sidebar Item -->
        <li class="nav-item"><a href="{{ route('admin.expenses') }}" class="nav-link"><i class="bi bi-wallet2"></i> Expenses</a></li>
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h1 class="brand-title">Product</h1>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search product..."
            onkeyup="searchTable()">

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
                        <button class="btn btn-warning btn-sm">Edit</button>
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
                        <button class="btn btn-warning btn-sm">Edit</button>
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
                        <button class="btn btn-warning btn-sm">Edit</button>
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
                <form>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" placeholder="Enter product name">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" placeholder="Enter category">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" placeholder="Enter stock quantity">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" placeholder="Enter price">
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

<!-- JavaScript -->
<script>
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

        // Get the table body and create a new row
        const tableBody = document.getElementById("inventoryTable");
        const newRow = document.createElement("tr");

        // Create table cells with the input data
        const idCell = document.createElement("td");
        idCell.innerText = tableBody.rows.length + 1; // Automatically increment ID
        const nameCell = document.createElement("td");
        nameCell.innerText = productName;
        const categoryCell = document.createElement("td");
        categoryCell.innerText = category;
        const stockCell = document.createElement("td");
        stockCell.innerText = stock;
        const priceCell = document.createElement("td");
        priceCell.innerText = `₱${price}`;

        // Add action buttons for editing and deleting
        const actionCell = document.createElement("td");
        actionCell.innerHTML = `
            <button class="btn btn-warning btn-sm">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button>
        `;

        // Append all cells to the new row
        newRow.appendChild(idCell);
        newRow.appendChild(nameCell);
        newRow.appendChild(categoryCell);
        newRow.appendChild(stockCell);
        newRow.appendChild(priceCell);
        newRow.appendChild(actionCell);

        // Append the new row to the table
        tableBody.appendChild(newRow);

        // Close the modal after adding the product
        document.querySelector("#addProductModal .btn-close").click();
    }

    function deleteProduct(button) {
        // Remove the row from the table
        const row = button.closest("tr");
        row.parentNode.removeChild(row);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>