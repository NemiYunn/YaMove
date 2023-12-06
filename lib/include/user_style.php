<!DOCTYPE html>
<html lang="en">

<head>

    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap and css -->
    <link rel="stylesheet" href="../../css/admin_style.css">
    <!-- <link rel="stylesheet" href="../../css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css" integrity="sha512-G/T7HQJXSeNV7mKMXeJKlYNJ0jrs8RsWzYG7rVACye+qrcUhEAYKYzaa+VFy6eFzM2+/JT1Q+eqBbZFSHmJQew==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous"> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">



    <!-- js and Jq -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->


    <!-- <script src="../../js/jquery.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <!-- <script src="../../js/bootstrap.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <!-- <script src="../../js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->


    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> -->
    <style>
        #carouselExampleControls .carousel-inner .carousel-item h1 {
            height: auto;
            color: whitesmoke;
            width: 100%;
            z-index: 1;
            text-align: center;
            margin-bottom: 6%;
            font-size: 4.5em;
            font-weight: 750;
        }

        .nav-link {
            color: whitesmoke;
            font-size: 1.2em;
            font-weight: 550;

        }

        /* tr:hover {background-color: #D6EEEE;} */
        .table th {
            /* padding-top: 50px; */
            /* vertical-align: center;   */
            text-align: center;

        }

        .table td {
            padding: 30px;
            vertical-align: middle;
            text-align: center;
        }

        .selected {
            background-color: blueviolet;
        }

        .trow.disabled {
            background-color: #c3b9b9;
            pointer-events: none;
            opacity: 0.5;
        }

        .seat {
            border: 1px solid #1E90FF;
            background-image: url('../images/seatt.png');
            background-size: cover;
            background-color: whitesmoke;
            width: 60px;
            height: 50px;
            margin-right: 8px;
            border-radius: 8px;
        }

        .seat h6 {
            margin-top: 15px;
            margin-left: 2px;
            color: white;
        }

        .seatD {
            border: 1px solid #383838;
            background-image: url('../images/seatt.png');
            background-size: cover;
            background-color: white;
            width: 60px;
            height: 50px;
            margin-right: 8px;
            border-radius: 8px;
        }

        .seatN {
            width: 60px;
            height: 50px;
            margin-right: 8px;
            border-radius: 8px;
        }

        .availableSt {
            border: 1px solid #1E90FF;
            background-size: cover;
            background-color: whitesmoke;
            width: 30px;
            height: 30px;
        }

        .counterSt {
            border: 1px solid #1E90FF;
            background-size: cover;
            background-color:#ffc266;
            width: 30px;
            height: 30px;
        }

        .processingSt {
            border: 1px solid #1E90FF;
            background-size: cover;
            background-color: #8080FF;
            width: 30px;
            height: 30px;
        }

        .bookedSt {
            border: 1px solid #1E90FF;
            background-size: cover;
            background-color: #b30000;
            width: 30px;
            height: 30px;
        }

        #spinner{
            width: 160px;
            height: 100px;
            background-image: url('../images/giphy.gif');
            background-size: cover;
        }

    </style>

</head>

<body>

    <script>

    </script>