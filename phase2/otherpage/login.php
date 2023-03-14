<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@latest/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.7.2/animate.min.css">
    <style>
        body {
            background-image: url("https://i.imgur.com/03a2P5y.jpg");
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            border-radius: 10px;
            padding: 40px;
            text-align: center;
        }

        .card h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .card .form-control {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            border: none;
            height: 50px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .card .btn {
            background-color: #1abc9c;
            border-radius: 10px;
            border: none;
            color: white;
            height: 50px;
            width: 100%;
            margin-top: 20px;
        }

        .card .btn:hover {
            background-color: #16a085;
        }
    </style>
</head>

<body>
    <div class="card animated fadeInDown">
        <h2>Welcome to My Website</h2>
        <form>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn">Sign in</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.0.1/anime.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".card").on("click", function() {
                $(this).toggleClass("flipped");
            });
        });
        var animation = anime({
            targets: ".card .form-group",
            translateY: [-100, 0],
            delay: function(el, index) {
                return index * 100;
            },
            opacity: [0, 1],
            easing: "easeOutQuad"
        });
    </script>