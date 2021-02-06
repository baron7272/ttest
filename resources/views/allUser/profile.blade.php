<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Socialite Network HTML Template</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="description"
      content="Socialite is - Professional A unique and beautiful collection of UI elements"
    />
    <link rel="icon" href="assets/user/images/favicon.png" />

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset('user/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('/user/css/night-mode.cs')}}" />
    <link rel="stylesheet" href="{{asset('/user/css/framework.css')}}" />

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('user/css/icons.css')}}" />

    <!-- Google font
    ================================================== -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet"
    />
  </head>

  <body>
    <!-- Wrapper -->
    <div id="wrapper">
      <!-- sidebar -->
      <div class="main_sidebar">
        <div
          class="side-overlay"
          uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"
        ></div>

        <!-- sidebar header -->
        <div class="sidebar-header">
          <h4>Navigation</h4>
          <span
            class="btn-close"
            uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible"
          ></span>
        </div>

        <!-- sidebar Menu -->
        <div class="sidebar">
          <div class="sidebar_innr" data-simplebar>
            <div class="sections">
                <div class="profile-card-side">
                    <div class="post-heading profile-card-headings">
                      <h6 class="profile-records ">567,888  <span>Fans</span></h6>
                      <h6 class="profile-records">1000 <span>Follows</span></h6>
                    </div>
                  </div>
                <div class="post-heading balance">
                    <p class="balances" >$567,888.00</p>
                    <p>Balance</p>
                </div>
              <div class="butt">
                <button class="button credit-btn success">Credit</button>
                <button class="button danger shifty">Debit</button>
              </div>
              <ul>
                <li>
                  <a href="home">
                    <img src="assets/user/images/icons/home.png" alt="" />
                    <span> Home </span>
                  </a>
                </li>
                <li>
                  <a href="notification.html">
                    <img src="assets/user/images/icons/chat.png" alt="" />
                    <span> Notification </span>
                  </a>
                </li>
                <li>
                  <a href="Live">
                    <img src="assets/user/images/icons/flag.png" alt="" />
                    <span> Live </span>
                  </a>
                </li>
               

                <li></li>
                <li>
                  <a href="class.html">
                    <img src="assets/user/images/icons/video.png" alt="" />
                    <span> Class </span>
                  </a>
                </li>
                <li>
                    <a href="about.html">
                      <img src="assets/user/images/icons/video.png" alt="" />
                      <span> About </span>
                    </a>
                  </li>
                <li>
                  <a href="contact.html">
                    <img src="assets/user/images/icons/group.png" alt="" />
                    <span> Contact Us</span>
                  </a>
                </li>
                <li class="active">
                  <a href="team.html">
                    <img src="assets/user/images/icons/pen.png" alt="" />
                    <span> Team </span>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="assets/user/images/icons/bag.png" alt="" />
                    <span>T&C </span>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="assets/user/images/icons/book.png" alt="" />
                    <span> Policy </span>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="assets/user/images/icons/friends.png" alt="" />
                    <span> Lagout</span>
                  </a>
                </li>
              </ul>

              <!-- <a href="#" class="button secondary px-5 btn-more"
                            uk-toggle="target: #more-veiw; animation: uk-animation-fade">
                            <span id="more-veiw">See More <i class="icon-feather-chevron-down ml-2"></i></span>
                            <span id="more-veiw" hidden>See Less<i class="icon-feather-chevron-up ml-2"></i> </span>
                        </a> -->
            </div>

            <!-- <div class="sections">
                        <h3> Shortcut </h3>
                        <ul>
                            <li> <a href="timeline.html"> <img src="assets/images/avatars/avatar-1.jpg" alt="">
                                    <span> Stella Johnson </span> <span class="dot-notiv"></span></a></li>
                            <li> <a href="timeline.html"> <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                    <span> Alex Dolgove </span> <span class="dot-notiv"></span></a></li>
                            <li> <a href="timeline.html"> <img src="assets/images/avatars/avatar-7.jpg" alt="">
                                    <span> Adrian Mohani </span> </a>
                            </li>
                            <li id="more-veiw-2" hidden> <a href="timeline.html">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="">
                                    <span> Erica Jones </span> <span class="dot-notiv"></span></a>
                            </li>
                            <li> <a href="group-feed.html"> <img src="assets/images/group/group-3.jpg" alt="">
                                    <span> Graphic Design </span> </a>
                            </li>
                            <li> <a href="group-feed.html"> <img src="assets/images/group/group-4.jpg" alt="">
                                    <span> Mountain Riders </span> </a>
                            </li>
                            <li id="more-veiw-2" hidden> <a href="timeline.html"> <img
                                        src="assets/images/avatars/avatar-5.jpg" alt="">
                                    <span> Alex Dolgove </span> <span class="dot-notiv"></span></a>
                            </li>
                            <li id="more-veiw-2" hidden> <a href="timeline.html"> <img
                                        src="assets/images/avatars/avatar-7.jpg" alt="">
                                    <span> Adrian Mohani </span> </a>
                            </li>
                        </ul>

                        <a href="#" class="button secondary px-5 btn-more"
                            uk-toggle="target: #more-veiw-2; animation: uk-animation-fade">
                            <span id="more-veiw-2">See More <i class="icon-feather-chevron-down ml-2"></i></span>
                            <span id="more-veiw-2" hidden>See Less<i class="icon-feather-chevron-up ml-2"></i> </span>
                        </a>

                    </div> -->

            <!--  Optional Footer -> 
            <div id="foot">

                <ul>
                    <li> <a href="page-term.html"> About Us </a></li>
                    <li> <a href="page-setting.html"> Setting </a></li>
                    <li> <a href="page-privacy.html"> Privacy Policy </a></li>
                    <li> <a href="page-term.html"> Terms - Conditions </a></li>
                </ul>


                <div class="foot-content">
                    <p>© 2019 <strong>Socialite</strong>. All Rights Reserved. </p>
                </div>

            </div> -->
          </div>
        </div>
      </div>

      <!-- header -->
      <div id="main_header">
      <header class="">
                <div class="header-innr">


                    <!-- Logo-->
                    <div class="header-btn-traiger" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
                        <span></span></div>

                    <!-- Logo-->
                    <div id="logo">
                        <a href="home"> <img src="assets/user/images/logo.png" alt=""></a>
                        <a href="home"> <img src="assets/user/images/logo-light.png" class="logo-inverse" alt=""></a>
                    </div>

                    <!-- form search-->
                    <div class="head_search">
                        <form>
                            <div class="head_search_cont" aria-expanded="false">
                                <input value="" type="text" class="form-control" placeholder="Search for Friends , Videos and more.." autocomplete="off">
                                <i class="s_icon uil-search-alt"></i>
                            </div>

                            <!-- Search box dropdown -->
                            <div uk-dropdown="pos: top;mode:click;animation: uk-animation-slide-bottom-small" class="dropdown-search uk-dropdown">
                                <!-- User menu -->

                                <ul class="dropdown-search-list">
                                    <li class="list-title"> Recent Searches </li>
                                    <li> <a href="#"> <img src="assets/user/images/avatars/avatar-2.jpg" alt=""> Erica Jones
                                        </a> </li>
                                    <li> <a href="#"> <img src="assets/user/images/group/group-2.jpg" alt=""> Coffee
                                            Addicts</a> </li>
                                    <li> <a href="#"> <img src="assets/user/images/group/group-4.jpg" alt=""> Mountain Riders
                                        </a> </li>
                                    <li> <a href="#"> <img src="assets/user/images/group/group-5.jpg" alt=""> Property Rent
                                            And Sale </a> </li>
                                    <li class="menu-divider"></li>
                                    <li class="list-footer"> <a href="your-history.html"> Searches History </a>
                                    </li>
                                </ul>

                            </div>


                        </form>
                    </div>

                    <!-- user icons -->
                    <div class="head_user">


                        <a href="homepage.html" class="opts_icon_link uk-visible@s"> Home </a>
                        <a href="timeline.html" class="opts_icon_link uk-visible@s"> Dennis Han </a>


                        <!-- browse apps  -->
                        <a href="#" class="opts_icon uk-visible@s" uk-tooltip="title: Apps ; pos: bottom ;offset:7" title="" aria-expanded="false">
                            <img src="assets/user/images/icons/apps.svg" alt="">
                        </a>

                        <!-- browse apps dropdown -->
                        <div uk-dropdown="mode:click ; pos: bottom-center ; animation: uk-animation-scale-up" class="icon-browse uk-dropdown">
                            <a href="#" class="icon-menu-item"> <i class="uil-shop"></i> Marketplace </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-envelope-alt"></i> Messages </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-bookmark"></i> Bookmark </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-users-alt"></i> Groups </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-calendar-alt"></i> Events </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-file-alt"></i> Forum </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-question-circle"></i> Questions </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-bolt-alt"></i> Upgrade </a>
                            <a href="#" class="icon-menu-item"> <i class="uil-user-circle"></i> Account </a>
                            <a href="#" class="more-app"> More Apps</a>
                        </div>


                        <!-- Message  notificiation dropdown -->
                        <a href="#" class="opts_icon" uk-tooltip="title: Messages ; pos: bottom ;offset:7" title="" aria-expanded="false">
                            <img src="assets/user/images/icons/chat.svg" alt=""> <span>4</span>
                        </a>

                        <!-- Message  notificiation dropdown -->
                        <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small" class="dropdown-notifications uk-dropdown">

                            <!-- notification contents -->
                            <div class="dropdown-notifications-content" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: -17px;"><div class="simplebar-content" style="padding: 0px; height: 100%; overflow: scroll hidden;">

                                <!-- notivication header -->
                                <div class="dropdown-notifications-headline">
                                    <h4>Messages</h4>
                                    <a href="#">
                                        <i class="icon-feather-settings" uk-tooltip="title: Message settings ; pos: left" title="" aria-expanded="false"></i>
                                    </a>

                                    <input type="text" class="uk-input" placeholder="Search in Messages">
                                </div>

                                <!-- notiviation list -->
                                <ul>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar status-online">
                                                <img src="assets/user/images/avatars/avatar-2.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Jonathan Madano</strong>
                                                <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>

                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-3.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Stella Johnson</strong>
                                                <p> Alex will explain you how ... <span class="time-ago"> 3 h </span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar status-online">
                                                <img src="assets/user/images/avatars/avatar-1.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Alex Dolgove</strong>
                                                <p> Alia just joined Messenger! <span class="time-ago"> 3 h </span> </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar status-online">
                                                <img src="assets/user/images/avatars/avatar-4.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Adrian Mohani</strong>
                                                <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-2.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Jonathan Madano</strong>
                                                <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>

                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-3.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Stella Johnson</strong>
                                                <p> Alex will explain you how ... <span class="time-ago"> 3 h </span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-1.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Alex Dolgove</strong>
                                                <p> Alia just joined Messenger! <span class="time-ago"> 3 h </span> </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-4.jpg" alt="">
                                            </span>
                                            <div class="notification-text notification-msg-text">
                                                <strong>Adrian Mohani</strong>
                                                <p>Thanks for The Answer ... <span class="time-ago"> 2 h </span> </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div></div></div><div class="simplebar-placeholder" style="width: 323px; height: 789px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: visible;"><div class="simplebar-scrollbar" style="width: 25px; transform: translate3d(0px, 0px, 0px); visibility: visible;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); visibility: hidden;"></div></div></div>
                            <div class="dropdown-notifications-footer">
                                <a href="#"> See all in Messages</a>
                            </div>


                        </div>


                        <!-- notificiation icon  -->
                        <a href="#" class="opts_icon" uk-tooltip="title: Notifications ; pos: bottom ;offset:7" title="" aria-expanded="false">
                            <img src="assets/user/images/icons/bell.svg" alt=""> <span>3</span>
                        </a>


                        <!-- notificiation dropdown -->
                        <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small" class="dropdown-notifications uk-dropdown">

                            <!-- notification contents -->
                            <div class="dropdown-notifications-content" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: -17px;"><div class="simplebar-content" style="padding: 0px; height: 100%; overflow: scroll hidden;">

                                <!-- notivication header -->
                                <div class="dropdown-notifications-headline">
                                    <h4>Notifications </h4>
                                    <a href="#">
                                        <i class="icon-feather-settings" uk-tooltip="title: Notifications settings ; pos: left" title="" aria-expanded="false"></i>
                                    </a>
                                </div>

                                <!-- notiviation list -->
                                <ul>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-2.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-primary">
                                                <i class="icon-feather-thumbs-up"></i></span>
                                            <span class="notification-text">
                                                <strong>Adrian Moh.</strong> Like Your Comment On Video
                                                <span class="text-primary">Learn Prototype Faster</span>
                                                <br> <span class="time-ago"> 9 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-3.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-danger">
                                                <i class="icon-feather-star"></i></span>
                                            <span class="notification-text">
                                                <strong>Alex Dolgove</strong> Added New Review In Video
                                                <span class="text-primary">Full Stack PHP Developer</span>
                                                <br> <span class="time-ago"> 19 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-4.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-success">
                                                <i class="icon-feather-message-circle"></i></span>
                                            <span class="notification-text">
                                                <strong>Stella John</strong> Replay Your Comment in
                                                <span class="text-primary">Adobe XD Tutorial</span>
                                                <br> <span class="time-ago"> 12 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-2.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-primary">
                                                <i class="icon-feather-thumbs-up"></i></span>
                                            <span class="notification-text">
                                                <strong>Adrian Moh.</strong> Like Your Comment On Video
                                                <span class="text-primary">Learn Prototype Faster</span>
                                                <br> <span class="time-ago"> 9 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-3.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-warning">
                                                <i class="icon-feather-star"></i></span>
                                            <span class="notification-text">
                                                <strong>Alex Dolgove</strong> Added New Review In Video
                                                <span class="text-primary">Full Stack PHP Developer</span>
                                                <br> <span class="time-ago"> 19 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="notification-avatar">
                                                <img src="assets/user/images/avatars/avatar-4.jpg" alt="">
                                            </span>
                                            <span class="notification-icon bg-gradient-success">
                                                <i class="icon-feather-message-circle"></i></span>
                                            <span class="notification-text">
                                                <strong>Stella John</strong> Replay Your Comment in
                                                <span class="text-primary">Adobe XD Tutorial</span>
                                                <br> <span class="time-ago"> 12 hours ago </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>

                            </div></div></div><div class="simplebar-placeholder" style="width: 323px; height: 789px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: visible;"><div class="simplebar-scrollbar" style="width: 25px; transform: translate3d(0px, 0px, 0px); visibility: visible;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); visibility: hidden;"></div></div></div>


                        </div>


                        <!-- profile -image -->
                        <a class="opts_account" href="#" aria-expanded="false"> <img src="assets/user/images/avatars/avatar-2.jpg" alt=""></a>

                        <!-- profile dropdown-->
                        <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small" class="dropdown-notifications rounded uk-dropdown">

                            <!-- User Name / Avatar -->
                            <a href="timeline.html">

                                <div class="dropdown-user-details">
                                    <div class="dropdown-user-avatar">
                                        <img src="assets/user/images/avatars/avatar-1.jpg" alt="">
                                    </div>
                                    <div class="dropdown-user-name"> Dennis Han   <span>See your profile</span> </div>
                                </div>

                            </a>

                            <hr class="m-0">
                            <ul class="dropdown-user-menu">
                                <li><a href="page-setting.html"> <i class="uil-user"></i> My Account </a> </li>
                                <li><a href="group-feed.html"> <i class="uil-thumbs-up"></i> Liked Pages </a></li>
                                <li><a href="page-setting.html"> <i class="uil-cog"></i> Account Settings</a></li>
                                <li>
                                    <a href="#" id="night-mode" class="btn-night-mode">
                                        <i class="uil-moon"></i> Night mode
                                        <span class="btn-night-mode-switch">
                                            <span class="uk-switch-button"></span>
                                        </span>
                                    </a>
                                </li>
                                
                                <li><a href="form-login.html"> <i class="uil-sign-out-alt"></i>Log Out</a>
                                </li>
                            </ul>

                            <hr class="m-0">
                            <ul class="dropdown-user-menu">
                                <li><a href="page-setting.html" class="bg-secondery"> <i class="uil-bolt"></i>
                                <div> Upgrade To Premium <span> Pro features give you complete control </span> </div> </a> 
                                </li>
                            </ul>

                        </div>


                    </div>

                </div> <!-- / heaader-innr -->
            </header>
      </div>

      <!-- contents -->
      <div class="main_content">
        <div class="main_content_inner">
          <div class="uk-grid-large" uk-grid>
            <div class="uk-width-2-3@m fead-area">
              <!-- <div class="section-small pt-0">
                            <div class="uk-position-relative" uk-slider="finite: true">

                                <div class="uk-slider-container pb-3">

                                    <ul
                                        class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-3 story-slider uk-grid">
                                        <li>
                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/avatars/avatar-lg-1.jpg"
                                                    uk-img>
                                                    <i class="uil-plus"></i>
                                                    <div class="story-card-content">
                                                        <h4> Dennis </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                        <li>
                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/events/listing-5.jpg"
                                                    uk-img>
                                                    <img src="assets/images/avatars/avatar-5.jpg" alt="">
                                                    <div class="story-card-content">
                                                        <h4> Jonathan </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                        <li>
                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/avatars/avatar-lg-3.jpg"
                                                    uk-img>
                                                    <img src="assets/images/avatars/avatar-6.jpg" alt="">
                                                    <div class="story-card-content">
                                                        <h4> Stella </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                        <li>

                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/avatars/avatar-lg-4.jpg"
                                                    uk-img>
                                                    <img src="assets/images/avatars/avatar-4.jpg" alt="">
                                                    <div class="story-card-content">
                                                        <h4> Alex </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                        <li>

                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/avatars/avatar-lg-2.jpg"
                                                    uk-img>
                                                    <img src="assets/images/avatars/avatar-2.jpg" alt="">
                                                    <div class="story-card-content">
                                                        <h4> Adrian </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>
                                        <li>

                                            <a href="#" uk-toggle="target: body ; cls: is-open">
                                                <div class="story-card" data-src="assets/images/avatars/avatar-lg-5.jpg"
                                                    uk-img>
                                                    <img src="assets/images/avatars/avatar-5.jpg" alt="">
                                                    <div class="story-card-content">
                                                        <h4> Dennis </h4>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>

                                    </ul>

                                    <div class="uk-visible@m">
                                        <a class="uk-position-center-left-out slidenav-prev" href="#"
                                            uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right-out slidenav-next" href="#"
                                            uk-slider-item="next"></a>
                                    </div>
                                    <div class="uk-hidden@m">
                                        <a class="uk-position-center-left slidenav-prev" href="#"
                                            uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right slidenav-next" href="#"
                                            uk-slider-item="next"></a>
                                    </div>

                                </div>
                            </div>
                        </div> -->

              <!-- container-profile starts =====================-->
              <div class="container-profile">
                <div class="row profile-row">
                  <!-- col-4 starts ==============-->
                  <div class="col-4 column-float">
                    <img
                      src="assets/user/images/avatars/avatar-3.jpg"
                      width="120px"
                      class="uk-border-circle"
                      alt=""
                    />
                  </div>
                  <!-- col-4ends =============================== -->
                  <div class="col-6 column-float">
                    <h3 class="profile-name">Eloka Nwobi</h3>
                    <h6 class="profile-occupation">Developer</h6>
                    <span class="@user">@eloks</span>
                    <div class="row profile-count">
                      <div class="col-2 div-count" width="33.3%">
                        <h6 class="uploads-count">0</h6>
                        <span>Uploads</span>
                      </div>
                      <div class="col-2 div-count" width="33.3%">
                        <h6 class="uploads-count">645</h6>
                        <span>Follow</span>
                      </div>
                      <div class="col-2 div-count" width="33.3%">
                        <h6 class="uploads-count">667855</h6>
                        <span>Fans</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-2 column-float">

                    <!-- This is an anchor toggling the modal -->
                    <a href="#modal-example" uk-toggle><i
                        class="icon-material-outline-settings icon-settings"
                      ></i></a>

                    <!-- This is the modal -->
                    <div id="modal-example" uk-modal>
                      <div class="uk-modal-dialog uk-modal-body">
                        <h2 class="uk-modal-title" style="color: #4188fa;">settings</h2>
                        <div class="uk-card-default rounded">
                            <div class="p-3">
                                <h5 class="mb-0"> Contact info </h5>
                            </div>
                            <hr class="m-0">
                            <form class="uk-child-width-1-2@s uk-grid-small p-4 uk-grid" uk-grid="">
                                <div class="uk-first-column">
                                    <h5 class="uk-text-bold mb-2"> First Name </h5>
                                    <input type="text" class="uk-input" placeholder="Your name">
                                </div>
                                <div>
                                    <h5 class="uk-text-bold mb-2"> Last Name </h5>
                                    <input type="text" class="uk-input" placeholder="Your seccond">
                                </div>
                                <div class="uk-grid-margin uk-first-column">
                                    <h5 class="uk-text-bold mb-2"> Your email address </h5>
                                    <input type="text" class="uk-input" placeholder="eliedaniels@gmail.com">
                                </div>
                                <div class="uk-grid-margin">
                                    <h5 class="uk-text-bold mb-2"> Phone </h5>
                                    <input type="text" class="uk-input" placeholder="+1 555 623 568 ">
                                </div>
                                <div class="uk-grid-margin">
                                    <h5 class="uk-text-bold mb-2">Gender</h5>
                                    <input type="text" class="uk-input" placeholder="Male or Female">
                                </div>
                                <div class="uk-grid-margin">
                                    <h5 class="uk-text-bold mb-2"> Age </h5>
                                    <input type="text" class="uk-input" placeholder="Age">
                                </div>
                                <div class="uk-grid-margin">
                                    <h5 class="uk-text-bold mb-2">Fanbase name</h5>
                                    <input type="text" class="uk-input" placeholder="Eloka">
                                </div>
                                <div class="uk-grid-margin">
                                    <h5 class="uk-text-bold mb-2">Country</h5>
                                    <input type="text" class="uk-input" placeholder="Nigeria">
                                </div>
                            </form>
                        </div>
                        <p class="uk-text-right Setting-buttons">
                          <button
                            class="button uk-button-default uk-modal-close"
                            type="button"
                          >
                            Cancel
                          </button>
                          <button
                            class="button uk-button-primary"
                            type="button"
                          >
                            Save
                          </button>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- container-profile ends =====================-->
<div>
<div class="uk-flex top-frame">
    <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
</div>

</div>
   
   <div>
   <div class="uk-flex top-frame">
   <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
    </div>
   
   </div>
   <div>
   <div class="uk-flex top-frame">
   <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
                      <div class="uk-card uk-card-default uk-card-body video-frame">   
    <iframe width="200" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
                      </iframe></div>
    </div>
    </div>
            </div>
            

            <!-- sidebar -->
            <div class="uk-width-expand">
              <!-- <h3 class="mb-2">TSPage</h3> -->

              <a href="#" class="uk-link-reset">
                <div
                  class="uk-flex uk-flex-top py-2 pb-0 pl-2 mb-4 bg-secondary-hover rounded winner-card"
                >
                  <img
                    src="assets/user/images/icons/gift-icon.png"
                    width="35px"
                    class="mr-3"
                    alt=""
                  />
                  <p>
                    <strong> Jessica Erica </strong> <br />
                    singer
                  </p>
                </div>
              </a>

              <div
                class="p-5 mb-3 rounded uk-background-cover uk-light"
                style="
                  background-blend-mode: color-burn;
                  background-color: rgba(0, 126, 255, 0.06);
                  height: 300px;
                "
                data-src="assets/user/images/events/img-5.jpg "
                uk-img
              >
                <div class="uk-width-4-5">
                  <!-- <h3 class="mb-2">
                                    <i class="uil-users-alt p-1 text-dark bg-white circle icon-small"></i>
                                    Groups </h3>
                                <p> New ways to find and join communications .</p>
                                <a href="#" class="button white small"> Find your groups</a> -->
                </div>
              </div>

              <div uk-sticky="offset:70 ; media : @m">
                <h3 class="mt-5 mb-5">Sponsors</h3>

                <!-- <ul class="uk-child-width-expand tab-small my-2 uk-tab">
                                <li class="uk-active"><a href="#">Friends</a></li>
                                <li><a href="#">Groups</a></li>
                            </ul> -->

                <div class="post-description">
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="assets/user/images/post/img-2.jpg"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div
                      class="uk-width-1-2@m uk-width-1-2 uk-position-relative"
                    >
                      <img
                        src="{{asset('user/images/post/img-3.jpg')}}"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="assets/user/images/post/img-2.jpg"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="assets/user/images/post/img-2.jpg"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="assets/user/images/post/img-2.jpg"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="assets/user/images/post/img-2.jpg"
                        class="rounded"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- story Pop box -->
      <div class="story-pop uk-animation-slide-bottom-small">
        <div class="story-side uk-width-1-4@s">
          <!--  
                <div class="story-side-search">
                    <input type="text" class="uk-input" placeholder="Search user....">
                    <i class="submit uil-search-alt"></i>
                </div> -->

          <div class="uk-flex uk-flex-between uk-flex-middle mb-2">
            <h2 class="mb-0" style="font-weight: 700">All Story</h2>
            <a href="#" class="text-primary"> Setting</a>
          </div>

          <div class="story-side-innr" data-simplebar>
            <h4 class="mb-1">Your Story</h4>
            <ul class="story-side-list">
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-1.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Stella Johnson</h5>
                    <p>Share a photo or video</p>
                  </div>
                  <div class="add-story-btn">
                    <i class="uil-plus"></i>
                  </div>
                </a>
              </li>
            </ul>

            <div class="uk-flex uk-flex-between uk-flex-middle my-3">
              <h4 class="m-0">Friends Story</h4>
              <a href="#" class="text-primary"> See all</a>
            </div>
            <ul
              class="story-side-list"
              uk-switcher="connect: #story-slider-switcher ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium"
            >
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-1.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Dennis Han</h5>
                    <p>
                      <span class="story-count"> 2 new </span>
                      <span class="story-time-ago"> 4hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-2.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Stella Johnson</h5>
                    <p>
                      <span class="story-count"> 3 new </span>
                      <span class="story-time-ago"> 1hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-4.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Erica Jones</h5>
                    <p>
                      <span class="story-count"> 2 new </span>
                      <span class="story-time-ago"> 3hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-7.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Adrian Mohani</h5>
                    <p>
                      <span class="story-count"> 1 new </span>
                      <span class="story-time-ago"> 4hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-5.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Alex Dolgove</h5>
                    <p>
                      <span class="story-count"> 3 new </span>
                      <span class="story-time-ago"> 7hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-1.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Stella Johnson</h5>
                    <p>
                      <span class="story-count"> 2 new </span>
                      <span class="story-time-ago"> 8hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-2.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Erica Jones</h5>
                    <p>
                      <span class="story-count"> 3 new </span>
                      <span class="story-time-ago"> 10hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <div class="story-user-media">
                    <img src="assets/user/images/avatars/avatar-5.jpg" alt="" />
                  </div>
                  <div class="story-user-innr">
                    <h5>Alex Dolgove</h5>
                    <p>
                      <span class="story-count"> 3 new </span>
                      <span class="story-time-ago"> 14hr ago </span>
                    </p>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="story-content">
          <!-- close button-->
          <span
            class="story-btn-close"
            uk-toggle="target: body ; cls: is-open"
            uk-tooltip="title:Close story ; pos: left "
          ></span>

          <div class="story-content-innr">
            <ul id="story-slider-switcher" class="uk-switcher">
              <li>
                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img src="assets/user/images/post/img-1.jpg" alt="" />
                      </div>
                    </li>
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-1.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div class="story-slider-image">
                        <img src="assets/user/images/post/img-3.jpg" alt="" />
                      </div>
                    </li>
                    <li>
                      <div class="story-slider-image">
                        <img
                          src="assets/user/images/avatars/avatar-lg-3.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                    <li>
                      <div class="story-slider-image">
                        <img
                          src="assets/user/images/avatars/avatar-lg-2.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>

              <li>
                <!-- slider navigation -->

                <a
                  href="#"
                  uk-switcher-item="previous"
                  class="uk-position-center-left-out uk-position-medium slidenav-prev"
                ></a>
                <a
                  href="#"
                  uk-switcher-item="next"
                  class="uk-position-center-right-out uk-position-medium slidenav-next"
                ></a>

                <div class="uk-position-relative uk-visible-toggle" uk-slider>
                  <!-- navigation -->
                  <ul class="uk-slider-nav uk-dotnav story-slider-nav"></ul>

                  <!-- Story posted image -->
                  <ul class="uk-slider-items uk-child-width-1-1 story-slider">
                    <li>
                      <div
                        class="story-slider-image uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                      >
                        <img
                          src="assets/user/images/avatars/avatar-lg-4.jpg"
                          alt=""
                        />
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Chat sidebar -->
     
      <div
        id="sidebar-chat"
        class="sidebar-chat px-3"
        uk-offcanvas="flip: true; overlay: true"
      >
        <div class="uk-offcanvas-bar">
          <div class="sidebar-chat-head mb-2">
            <div class="btn-actions">
              <a
                href="#"
                uk-tooltip="title: Search ;offset:7"
                uk-toggle="target: .sidebar-chat-search; animation: uk-animation-slide-top-small"
              >
                <i class="icon-feather-search"></i>
              </a>
              <a href="#" uk-tooltip="title: settings ;offset:7">
                <i class="icon-feather-settings"></i>
              </a>
              <a href="#"> <i class="uil-ellipsis-v"></i> </a>
              <a href="#" class="uk-hidden@s">
                <button
                  class="uk-offcanvas-close uk-close"
                  type="button"
                  uk-close
                ></button>
              </a>
            </div>

            <h2>Chats</h2>
          </div>

          <div class="sidebar-chat-search" hidden>
            <input
              type="text"
              class="uk-input"
              placeholder="Search in Messages"
            />
            <span
              class="btn-close"
              uk-toggle="target: .sidebar-chat-search; animation: uk-animation-slide-top-small"
            >
              <i class="icon-feather-x"></i>
            </span>
          </div>

          <ul class="uk-child-width-expand sidebar-chat-tabs" uk-tab>
            <li class="uk-active"><a href="#">Users</a></li>
            <li><a href="#">Groups</a></li>
          </ul>

          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-2.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Dennis Han</h5>
            </div>
          </a>

          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-1.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Erica Jones</h5>
            </div>
          </a>

          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-7.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Stella Johnson</h5>
            </div>
          </a>

          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-5.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Alex Dolgove</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-2.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Dennis Han</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-4.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Erica Jones</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-3.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Stella Johnson</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-5.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Alex Dolgove</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-2.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Dennis Han</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-4.jpg" alt="" />
                <span class="online-dot"></span>
              </div>
              <h5>Erica Jones</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-3.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Stella Johnson</h5>
            </div>
          </a>
          <a href="#">
            <div class="contact-list">
              <div class="contact-list-media">
                <img src="assets/user/images/avatars/avatar-5.jpg" alt="" />
                <span class="offline-dot"></span>
              </div>
              <h5>Alex Dolgove</h5>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- For Night mode -->
    <script>
      (function (window, document, undefined) {
        "use strict";
        if (!("localStorage" in window)) return;
        var nightMode = localStorage.getItem("gmtNightMode");
        if (nightMode) {
          document.documentElement.className += " night-mode";
        }
      })(window, document);

      (function (window, document, undefined) {
        "use strict";

        // Feature test
        if (!("localStorage" in window)) return;

        // Get our newly insert toggle
        var nightMode = document.querySelector("#night-mode");
        if (!nightMode) return;

        // When clicked, toggle night mode on or off
        nightMode.addEventListener(
          "click",
          function (event) {
            event.preventDefault();
            document.documentElement.classList.toggle("night-mode");
            if (document.documentElement.classList.contains("night-mode")) {
              localStorage.setItem("gmtNightMode", true);
              return;
            }
            localStorage.removeItem("gmtNightMode");
          },
          false
        );
      })(window, document);
    </script>

    <!-- javaScripts
                ================================================== -->
                <script src="{{asset('user/js/framework.js')}}"></script>
    <script src="{{ asset('user/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('user/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('user/js/simplebar.js')}}"></script>
    <script src="{{asset('user/js/main.js')}}"></script>
  </body>
</html>
