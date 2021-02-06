<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Magic</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="description"
      content="Socialite is - Professional A unique and beautiful collection of UI elements"
    />
    <link rel="icon" href="{{asset('user/images/favicon.png')}}" />

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset('user/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('user/css/night-mode.css')}}" />
    <link rel="stylesheet" href="{{asset('user/css/framework.css')}}" />

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
                  <h6 class="profile-records">567,888 <span>Fans</span></h6>
                  <h6 class="profile-records">1000 <span>Follows</span></h6>
                </div>
              </div>
              <div class="post-heading balance">
                <p class="Balance-naira">$567,888.00</p>
                <p>Balance</p>
              </div>
              <div class="butt">
              <button class="shifty Buy-btn">
                  <a href="buy">
                  <span class="buy-span">Buy </span>
                 </a>
                  </button>
                  <button class="shifty">
                  <a href="share">
                  <span class="buy-span">Share</span>
                 </a>
                  </button>
              </div>
              <ul>
                <li >
                <a href="{{ route('public.home') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                  <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                    </svg>
                    <span> Home </span>
                  </a>
                </li>
                <li class="active">
                  <a href="notification">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
               <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                 </svg>
                    <span> Notification </span>
                  </a>
                </li>


                <li>
                    <div uk-lightbox>

                        <a  class="" href="images/photo.jpg"><span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5z"/>
              </svg>
                   Live</span></a>
</div>
</li>


                <li>
                  <a href="class">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
  <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"/>
</svg>
                    <span> Class </span>
                  </a>
                </li>

                <li>
                  <a href="">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
  <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
  <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
</svg>
                    <span> About </span>
                  </a>
                </li>
                <li>
                  <a href="">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
  <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
</svg>
                    <span> Contact Us</span>
                  </a>
                </li>
                <li>
                  <a href="">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
</svg>
                    <span>Team </span>
                  </a>
                </li>
                <li>
                  <a href="">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-app-fill" viewBox="0 0 16 16">
  <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5v-2zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2H1zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2h14zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
     </svg>
                    <span>T&C </span>
                  </a>
                </li>
                <li>
                  <a href="">
                    <img src="{{asset('user/images/icons/policy.png')}}" alt="" />
                    <span> Policy </span>
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
                            <li> <a href="timeline.html"> <img src="assets/user/images/avatars/avatar-1.jpg" alt="">
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
                  <div class="header-btn-traiger" uk-toggle="target: #wrapper ; cls: collapse-sidebar mobile-visible">
                    <span></span></div>
                <!-- user icons -->
                    <div class="head_user">
                      <!-- profile -image -->
                        <a class="opts_account" href="#" aria-expanded="false"> <img src="http://localhost:8000/images/avatars/avatar-2.jpg" alt=""></a>

                        <!-- profile dropdown-->
                        <div uk-dropdown="mode:click ; animation: uk-animation-slide-bottom-small" class="dropdown-notifications rounded uk-dropdown">

                            <!-- User Name / Avatar -->
                            <a href="profile">

                                <div class="dropdown-user-details">
                                    <div class="dropdown-user-avatar">
                                        <img src="http://localhost:8000/images/avatars/avatar-1.jpg" alt="">
                                    </div>
                                    <div class="dropdown-user-name"> Dennis Han  <span>See your profile</span> </div>
                                </div>

                            </a>

                            <hr class="m-0">
                            <ul class="dropdown-user-menu">
                               
                                <li><a href="settings"> <i class="uil-cog"></i> Account Settings</a></li>

                                
                                <li><a href="form-login.html"> <i class="uil-sign-out-alt"></i>Log Out</a>
                                </li>
                            </ul>

                            <hr class="m-0">
                           

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
             

              <h3 class="uk-text-primary notice-name">Dear, Mr.Eloka</h3>




              <h3 class="uk-text-primary notice-name">Hello, {{auth()->user()->username}}</h3>










        




@foreach ($notifications as $notification)
                 @if($notification->type=='Text')
              <div
                class="uk-card uk-card-default uk-card-self uk-card-body uk-width-1-2@m"
                id="notify-box"
              >
              <h3 class="uk-card-title notice-week">{{ $notification->title }}</h3>

                <p>{{{ $notification->content }}}
                </p>
                <p class="paragraph-left">{{ $notification->created_at }}</p>
              </div>


@elseif($notification->type=='Picture')



<div class="uk-child-width-1-2@m uk-grid-match notify" uk-grid>
  <div style="width: 100%" ;>
    <div
      class="uk-card uk-card-default   uk-card-self uk-card-body"
      uk-scrollspy="cls: uk-animation-slide-left; repeat: true"
    >
      <h3 class="uk-card-title notice-week">{{ $notification->title }}</h3>
      <img
        src="{{asset('user/images/post/img-1.jpg')}}"
        alt=""
        class="image-class"
      />
      <p class="paragraph-left">{{ $notification->created_at }}</p>
    </div>
  </div>
</div>
@else


<div class="uk-child-width-1-2@m uk-grid-match notify" uk-grid>

<div style="width: 100%" ;>
  <div
    class="uk-card uk-card-default uk-card-self uk-card-body"
    uk-scrollspy="cls: uk-animation-slide-left; repeat: true"
  >
    <h3 class="uk-card-title notice-week">{{ $notification->title }}</h3>
    <iframe width="600" height="200" src="https://www.youtube.com/embed/tgbNymZ7vqY">
      </iframe>
    <p class="paragraph-left">{{ $notification->title }}</p>
  </div>
</div>
</div>

@endif

@endforeach











            </div>

            <!-- sidebar -->
            <div class="uk-width-expand">
              <!-- <h3 class="mb-2">TSPage</h3> -->

              <div
                  class="uk-flex uk-flex-top py-2 pb-0 pl-2 mb-4  rounded winner-card"
                  id="Day-star"
                >
                <a href="#">
                <img
                    src="{{asset('user/images/icons/gift-icon.png')}}"
                    width="40px"
                    class="mr-3"
                    alt=""
                  />
                </a>
                
                  <p>
                    <strong> Jessica Erica </strong> <br />
                    singer
                  </p>
                </div>
              <div
                class="p-5 mb-3 rounded uk-background-cover uk-light"
                style="
                  background-blend-mode: color-burn;
                  background-color: rgba(0, 0, 255, 0.03);
                  height: 300px;
                "
                data-src="{{asset('user/images/events/img-5.jpg')}} "
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

               

                <div class="post-description">
                  <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="{{asset('user/images/post/img-2.jpg')}}"
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
                        src="{{asset('user/images/post/img-2.jpg')}}"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="{{asset('user/images/post/img-2.jpg')}}"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="{{asset('user/images/post/img-2.jpg')}}"
                        class="rounded"
                        alt=""
                      />
                    </div>
                    <div class="uk-width-1-2@m uk-width-1-2">
                      <img
                        src="{{asset('user/images/post/img-2.jpg')}}"
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
