<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Groceries - Transactions</title>
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

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="brand-title">Transaction Management</h1>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search transaction..."
                onkeyup="searchTable()">

            <!-- Transactions Table -->
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Date & Time</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="transactionsTable">
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>2025-04-03 10:00 AM</td>
                        <td>₱100</td>
                        <td>Cash</td>
                        <td>Completed</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTransactionModal"
                                onclick="editTransaction(1, 'John Doe', '2025-04-03 10:00 AM', '₱100', 'Cash', 'Completed')">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            <button class="btn btn-info btn-sm"><i class="bi bi-file-earmark-text"></i> View
                                Receipt</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Paolo Golpe</td>
                        <td>2025-05-03 8:00 AM</td>
                        <td>₱1000</td>
                        <td>Cash</td>
                        <td>Incompleted</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTransactionModal"
                                onclick="editTransaction(2, 'Paolo Golpe', '2025-05-03 8:00 AM', '₱1000', 'Cash', 'Incompleted')">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            <button class="btn btn-info btn-sm"><i class="bi bi-file-earmark-text"></i> View
                                Receipt</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Kc Mison</td>
                        <td>2025-06-03 9:00 AM</td>
                        <td>₱200</td>
                        <td>Cash</td>
                        <td>Completed</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTransactionModal"
                                onclick="editTransaction(3, 'Kc Mison', '2025-06-03 9:00 AM', '₱200', 'Cash', 'Completed')">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            <button class="btn btn-info btn-sm"><i class="bi bi-file-earmark-text"></i> View
                                Receipt</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Transaction Modal -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTransactionForm">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateTime" class="form-label">Date & Time</label>
                            <input type="text" class="form-control" id="dateTime" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <input type="text" class="form-control" id="totalAmount" required>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="paymentMethod" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveTransaction()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("transactionsTable");
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

        function editTransaction(id, customerName, dateTime, totalAmount, paymentMethod, status) {
            document.getElementById('customerName').value = customerName;
            document.getElementById('dateTime').value = dateTime;
            document.getElementById('totalAmount').value = totalAmount;
            document.getElementById('paymentMethod').value = paymentMethod;
            document.getElementById('status').value = status;
        }

        function saveTransaction() {
            let customerName = document.getElementById('customerName').value;
            let dateTime = document.getElementById('dateTime').value;
            let totalAmount = document.getElementById('totalAmount').value;
            let paymentMethod = document.getElementById('paymentMethod').value;
            let status = document.getElementById('status').value;

            alert('Transaction updated!');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
