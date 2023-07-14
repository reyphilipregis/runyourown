<!DOCTYPE html>
<html lang="en">
<head>
    <title>Electricity Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.2/highcharts.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2 sidenav">
                <h4>Dashboard</h4>
                <ul class="nav nav-pills nav-stacked">
                    <!-- As long as the url has sites then the sites nav should be active and also if url is / then sites should be active by default -->
                    <li><a class="nav-link {{ (strpos(url()->current(), '/sites') !== false || Request::is('/')) ? 'active' : '' }}" href="{{ url('/sites') }}">Sites</a></li>
                    <li><a class="nav-link {{ Request::is('bills') ? 'active' : '' }}" href="{{ url('/bills') }}">Bills</a></li>
                </ul>
            </div>
            <div class="col-sm-10 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @yield('content')
                @yield('additional-scripts')
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Electricity Management. All rights reserved.</p>
    </div>
</body>
</html>
