<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - Expense Management</title>
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
        <li class="nav-item"><a href="{{ route('admin.purchase') }}" class="nav-link"><i class="bi bi-cart"></i> Purchase</a></li>
        <li class="nav-item"><a href="{{ route('admin.expenses') }}" class="nav-link"><i class="bi bi-wallet2"></i> Expenses</a></li>
        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h1 class="brand-title">Expense Management</h1>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="bi bi-plus-circle"></i> Add Expense
        </button>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search expense..."
            onkeyup="searchTable()">

        <!-- Expense Table -->
        <table class="table table-striped table-bordered">
            <thead class="table-success">
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="expenseTable">
                <!-- Example row; replace with dynamic data -->
                <tr>
                    <td>05 October 2023</td>
                    <td>Office Supplies</td>
                    <td>88</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editExpense(this)">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteExpense(this)">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>06 October 2023</td>
                    <td>Travel Expenses</td>
                    <td>110</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editExpense(this)">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteExpense(this)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Adding Expense -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addExpenseForm">
                    <div class="mb-3">
                        <label for="expenseDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="expenseDescription" placeholder="Enter expense description" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="expenseAmount" placeholder="Enter amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenseDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="expenseDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addExpense()">Save Expense</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Expense -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editExpenseForm">
                    <div class="mb-3">
                        <label for="editExpenseDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="editExpenseDescription" placeholder="Enter expense description" required>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="editExpenseAmount" placeholder="Enter amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="editExpenseDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editExpenseDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateExpense()">Update Expense</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    let currentRow;

    function searchTable() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.getElementById("expenseTable");
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

    function addExpense() {
        const description = document.getElementById("expenseDescription").value;
        const amount = document.getElementById("expenseAmount").value;
        const date = document.getElementById("expenseDate").value;

        const newRow = document.createElement("tr");
        newRow.innerHTML = `<td>${new Date(date).toLocaleDateString()}</td>
                            <td>${description}</td>
                            <td>${amount}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editExpense(this)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteExpense(this)">Delete</button>
                            </td>`;

        document.getElementById("expenseTable").appendChild(newRow);
        document.querySelector("#addExpenseModal .btn-close").click();
        document.getElementById("addExpenseForm").reset();
    }

    function editExpense(button) {
        currentRow = button.closest("tr");
        const cells = currentRow.getElementsByTagName("td");
        document.getElementById("editExpenseDescription").value = cells[1].innerText;
        document.getElementById("editExpenseAmount").value = cells[2].innerText;
        document.getElementById("editExpenseDate").value = new Date(cells[0].innerText).toISOString().split('T')[0];

        const editModal = new bootstrap.Modal(document.getElementById('editExpenseModal'));
        editModal.show();
    }

    function updateExpense() {
        const description = document.getElementById("editExpenseDescription").value;
        const amount = document.getElementById("editExpenseAmount").value;
        const date = document.getElementById("editExpenseDate").value;

        currentRow.cells[0].innerText = new Date(date).toLocaleDateString();
        currentRow.cells[1].innerText = description;
        currentRow.cells[2].innerText = amount;

        document.querySelector("#editExpenseModal .btn-close").click();
        document.getElementById("editExpenseForm").reset();
    }

    function deleteExpense(button) {
        const row = button.closest("tr");
        row.parentNode.removeChild(row);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>