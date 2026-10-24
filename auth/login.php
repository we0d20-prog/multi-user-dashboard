<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* خلفية بتدرج لوني حديث وهادئ */
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .form-control:focus {
            border-color: #212529;
            box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
        }
        .btn-dark {
            transition: all 0.3s ease;
        }
        .btn-dark:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <!-- أيقونة أعلى الصفحة -->
                        <div class="text-center mb-4">
                            <div class="bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="bi bi-person-lock fs-2"></i>
                            </div>
                        </div>

                        <h3 class="text-center mb-4 fw-bold text-dark">
                            Welcome Back
                        </h3>

                        <form action="login_process.php" method="POST">

                            <!-- Email with Floating Label -->
                            <div class="form-floating mb-3">
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control rounded-3"
                                    id="floatingEmail"
                                    placeholder="name@example.com"
                                    required
                                >
                                <label for="floatingEmail">Email address</label>
                            </div>

                            <!-- Password with Floating Label -->
                            <div class="form-floating mb-4">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control rounded-3"
                                    id="floatingPassword"
                                    placeholder="Password"
                                    required
                                >
                                <label for="floatingPassword">Password</label>
                            </div>

                            <button class="btn btn-dark w-100 py-2 rounded-3 fw-bold">
                                Login <i class="bi bi-box-arrow-in-right ms-2"></i>
                            </button>

                            <div class="text-center mt-4">
                                <a href="forgot_password.php" class="text-decoration-none text-muted small fw-medium">
                                    Forgot Password?
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS (اختياري، لكن يفضل وضعه) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>