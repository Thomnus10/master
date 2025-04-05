<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - User Management</title>
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
            <h1 class="brand-title">User Management</h1>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle"></i> Add User
            </button>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search user..."
                onkeyup="searchTable()">

            <!-- User Table -->
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editUser(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(this)">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editUser(this)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" placeholder="Enter user name" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="Enter user email" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addUser()">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateUser()">Update User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let currentRow;

        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("userTable");
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

        function addUser() {
            const userName = document.getElementById("userName").value;
            const userEmail = document.getElementById("userEmail").value;

            const newRow = document.createElement("tr");
            newRow.innerHTML = `<td>${document.getElementById("userTable").rows.length + 1}</td>
                                <td>${userName}</td>
                                <td>${userEmail}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editUser(this)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(this)">Delete</button>
                                </td>`;

            document.getElementById("userTable").appendChild(newRow);
            document.querySelector("#addUserModal .btn-close").click();
            document.getElementById("addUserForm").reset();
        }

        function editUser(button) {
            currentRow = button.closest("tr");
            const cells = currentRow.getElementsByTagName("td");
            document.getElementById("editUserName").value = cells[1].innerText;
            document.getElementById("editUserEmail").value = cells[2].innerText;

            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }

        function updateUser() {
            const userName = document.getElementById("editUserName").value;
            const userEmail = document.getElementById("editUserEmail").value;

            currentRow.cells[1].innerText = userName;
            currentRow.cells[2].innerText = userEmail;

            document.querySelector("#editUserModal .btn-close").click();
            document.getElementById("editUserForm").reset();
        }

        function deleteUser(button) {
            const row = button.closest("tr");
            row.parentNode.removeChild(row);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>