

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="/Assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        #layoutAuthentication_content {
            background-image: url('/Assets/perpus.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(15px); 
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .card-header {
            background: rgba(255,255,255,0.1); 
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .form-control {
            background: rgba(255,255,255,0.3); 
            border: 1px solid rgba(255,255,255,0.2);
            color: #333;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.5);
            border-color: rgba(0,0,0,0.2);
            box-shadow: none;
        }
        .btn-secondary {
            background-color: rgba(108,117,125,0.7);
            border-color: transparent;
        }
        .btn-secondary:hover {
            background-color: rgba(108,117,125,0.9);
        }
    </style>
</head>
<body class="bg-secondary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4 text-black-50">Login</h3>
                            </div>
                            <div class="card-body">
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php endif; ?>
                                <form method="post" action="/login">
                                    <div class="form-floating mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-alt"></i></span>
                                            <input class="form-control" name="username" type="text" placeholder="Username" required />
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required />
                                        </div>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-outline-light">
                                        Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Nanashi</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/Assets/js/scripts.js"></script>
</body>

</html>