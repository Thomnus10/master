<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - Supplier Management</title>
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
        
        <!-- New Expenses Sidebar Link -->
        <li class="nav-item"><a href="{{ route('admin.expenses') }}" class="nav-link"><i class="bi bi-wallet"></i> Expenses</a></li>

   
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="brand-title">Supplier Management</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <i class="bi bi-plus-circle"></i> Add Supplier
            </button>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search supplier..."
                onkeyup="searchTable()">

            <!-- Supplier Table -->
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Telephone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="supplierTable">
                    <tr>
                        <td>1</td>
                        <td>Supplier A</td>
                        <td>123456789</td>
                        <td>Address A</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editSupplier(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSupplier(this)">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Supplier B</td>
                        <td>987654321</td>
                        <td>Address B</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editSupplier(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSupplier(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Supplier -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="mb-3">
                            <label for="supplierName" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="supplierName" placeholder="Enter supplier name" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierPhone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="supplierPhone" placeholder="Enter telephone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="supplierAddress" placeholder="Enter address" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addSupplier()">Save Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Supplier -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm">
                        <div class="mb-3">
                            <label for="editSupplierName" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="editSupplierName" placeholder="Enter supplier name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierPhone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="editSupplierPhone" placeholder="Enter telephone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="editSupplierAddress" placeholder="Enter address" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateSupplier()">Update Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let currentRow;

        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("supplierTable");
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

        function addSupplier() {
            const supplierName = document.getElementById("supplierName").value;
            const supplierPhone = document.getElementById("supplierPhone").value;
            const supplierAddress = document.getElementById("supplierAddress").value;

            const newRow = document.createElement("tr");
            newRow.innerHTML = `<td>${document.getElementById("supplierTable").rows.length + 1}</td>
                                <td>${supplierName}</td>
                                <td>${supplierPhone}</td>
                                <td>${supplierAddress}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editSupplier(this)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSupplier(this)">Delete</button>
                                </td>`;

            document.getElementById("supplierTable").appendChild(newRow);
            document.querySelector("#addSupplierModal .btn-close").click();
            document.getElementById("addSupplierForm").reset();
        }

        function editSupplier(button) {
            currentRow = button.closest("tr");
            const cells = currentRow.getElementsByTagName("td");
            document.getElementById("editSupplierName").value = cells[1].innerText;
            document.getElementById("editSupplierPhone").value = cells[2].innerText;
            document.getElementById("editSupplierAddress").value = cells[3].innerText;

            const editModal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
            editModal.show();
        }

        function updateSupplier() {
            const supplierName = document.getElementById("editSupplierName").value;
            const supplierPhone = document.getElementById("editSupplierPhone").value;
            const supplierAddress = document.getElementById("editSupplierAddress").value;

            currentRow.cells[1].innerText = supplierName;
            currentRow.cells[2].innerText = supplierPhone;
            currentRow.cells[3].innerText = supplierAddress;

            document.querySelector("#editSupplierModal .btn-close").click();
            document.getElementById("editSupplierForm").reset();
        }

        function deleteSupplier(button) {
            const row = button.closest("tr");
            row.parentNode.removeChild(row);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>