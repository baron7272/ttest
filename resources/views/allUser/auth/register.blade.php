<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Socialite Network HTML Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">

    <!-- Favicon -->
    <link href="{{asset('user/images/favicon.png')}}" rel="icon" type="image/png">

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset('user/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/framework.css')}}">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('user/css/icons.css')}}">
    <!--
    
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,500,600" rel="stylesheet"> -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">


</head>

<body>
     

    <!-- Content
    ================================================== -->
    <div uk-height-viewport="expand: true" class="uk-flex uk-flex-middle">
        <div class="uk-width-1-3@m uk-width-1-2@s m-auto">
            <div class="px-2 uk-animation-scale-up">
                <div class="my-4 uk-text-center">
                    <h1 class="mb-2"> Sing up  </h1>
                    <p class="my-2">Do you have an a account. 
                    <a href="form-login.html" class="uk-link text-primary"> Sing in</a> </p>
                </div>
                <form>
                    <div class="uk-form-group">
                        <div class="uk-position-relative">
                            <input class="uk-input bg-secondary" type="email" placeholder="Your email">
                        </div>
                    </div>
                    <div class="uk-form-group">
                        <div class="uk-position-relative">
                            <input class="uk-input bg-secondary" type="password" placeholder="Your password">
                        </div>
                    </div>
                    <div class="uk-form-group">
                        <div class="uk-position-relative">
                            <input class="uk-input bg-secondary" type="password" placeholder="Confirm password">
                        </div>
                    </div>
                    <button type="submit" class="button primary large block mb-4">Get Started</button>
                    <a href="#" class="text-center uk-display-block">  
                        <label><input class="uk-checkbox mr-2" type="checkbox"> I Agree terms </label>
                    </a>
                </form>
            </div>       
        </div>
    </div>

    


    <!-- javaScripts
    ================================================== -->
    <script src="{{asset('user/js/framework.js')}}"></script>
    <script src="{{asset('user/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('/user/js/simplebar.js')}}"></script>
    <script src="{{asset('user/js/main.js')}}"></script>
    <script src="{{asset('user/js/bootstrap-select.min.js')}}"></script>


</body>

</html>