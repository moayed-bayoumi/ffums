<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.16.0/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@latest/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.7.2/animate.min.css" />
  <style>
    body {
      background-color: #f3f3f3;
    }

    table {
      width: 100%;
      margin-top: 20px;
    }

    th,
    td {
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f3f3f3;
      font-weight: bold;
    }

    .progress {
      height: 20px;
    }

    .progress-bar {
      font-size: 14px;
      line-height: 20px;
    }

    .bg-danger {
      background-color: #dc3545;
    }

    .bg-warning {
      background-color: #ffc107;
    }
  </style>
</head>

<body>


  <header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">My Website</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="new-order.php">طلب جديد</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="d8.php">2طلب جديد</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="order-list.php">قائمة الطلبات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product-list.php">قائمة المنتجات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add-product.php">اضافة منتج</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dashboard.php">قائمة المنتجات2 </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="das1.php">0</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="d9.php">1</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.2.php">2</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="order-list2.php">3</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="100.php">100</a>
          </li>
        </ul>
      </div>
    </nav>

  </header>
  <script>
    const navbarToggle = document.querySelector(".navbar-toggle");
    const navbar = document.querySelector(".navbar");

    navbarToggle.addEventListener("click", function() {
      navbar.classList.toggle("navbar-open");
    });
  </script>