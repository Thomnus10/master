<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dowence Market</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #FAFAFA;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .left-side img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        .right-side {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
        }

        input::placeholder {
            color: #999999;
        }
    </style>
</head>

<body>

    <div class="row g-0">
        <!-- Left Side (Image) -->
        <div class="col-md-6 left-side">
            <img src="{{ asset('images/logo1.jpg') }}" alt="My Image">
        </div>

        <!-- Right Side (Login Form) -->
        <div class="col-md-6 right-side">
            <form method="POST" action="/login" class="login-form">
                @csrf
                <h2 class="text-center mb-4" style="color: #333333;">LOGIN</h2>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password">
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>
