<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .card-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .card-body .row .col-md-3 {
            text-align: center;
        }

        .card-body .row .col-md-3 i {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .card-body .row .col-md-3 p {
            font-size: 20px;
            font-weight: bold;
        }

        #orders-table {
            margin-top: 20px;
        }

        #orders-table th {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        #orders-table td {
            text-align: center;
            font-size: 14px;
        }

        .customer-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body