<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <title>PSPI WASTE APP</title>
</head>
<body>
    @include('admin.navigation')

    @yield('content')
    
    <!-- Jquery Core Js -->
    <script src="{{ asset('/bootstrap/js/jquery-2.0.2.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
</body>
</html>