<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PhPaymentSprung</title>
  <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
  @yield('scripts')
</head>
<body>
  <div class="container"> 
    @yield('content')
  </div>
  <h4 align="center">Made with the <a href="https://paymentspring.com/developers/" target="_blank">PaymentSpring API</a></h4>
</body>
</html>
