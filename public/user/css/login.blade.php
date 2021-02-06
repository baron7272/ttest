<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Socialite Network HTML Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">
    <link rel="icon" href="assets/images/favicon.png">

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/night-mode.css')}}">
    <link rel="stylesheet" href="{{asset('css/framework.css')}}">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('css/icons.css')}}">

    <!-- Google font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">


</head>

<body>



    <!-- Content
    ================================================== -->
    <div uk-height-viewport class="uk-flex uk-flex-middle uk-grid-collapse uk-grid-match" uk-grid>
        <div class="form-media uk-width-2-3@m uk-width-1-2@s uk-visible@s uk-height-viewport uk-background-cover"
            data-src="assets/images/bg-form2.jpg" uk-img>        

            <div class="form-media-content uk-light"> 
                <div class="logo"><img src="assets/images/logo-light.png" alt=""></div>

                <h1> Start Your Own Social Network  <br> with Socialte Template</h1>


                <div class="form-media-footer">
                    <ul>
                        <li> <a href="#"> About </a></li><li> <a href="#"> Contact </a></li><li> <a href="#"> About </a></li><li> <a href="#"> Contact </a></li><li> <a href="#"> About </a></li><li> <a href="#"> Contact </a></li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="uk-width-1-3@m uk-width-1-2@s uk-animation-slide-right-medium">

            <div class="px-5">
                <div class="my-4 uk-text-center">
                    <h1 class="mb-2"> Sing in </h1>
                    <p class="my-2">Don't have an a account. <a href="form-modern-register.html"
                            class="uk-link text-primary"> Sing up</a> </p>
                </div>
                <form>
                    <div class="uk-form-group">
                        <div class="uk-position-relative">
                            <input class="uk-input bg-secondary" type="email" placeholder="Your email ">
                        </div>
                    </div>
                    <div class="uk-form-group">
                        <div class="uk-position-relative">
                            <input class="uk-input bg-secondary" type="password" placeholder="Your password">
                        </div>
                    </div>
                    <button type="submit" class="button primary large block mb-4">Get Started</button>
                    <a href="#" class="text-center uk-display-block"> Forget your password</a>
                </form>
            </div>

        </div>
    </div>

    <!-- Content -End
    ================================================== -->


    <!-- javaScripts
    ================================================== -->
    <script src="{{asset('js/framework.js')}}"></script>
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script src="{{asset('/js/main.js')}}"></script>



</body>

</html>