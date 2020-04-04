  @php
    $homeHref ="";
    if(session()->has('student'))
    {
        $homeHref = "/Registration";
    }
    else if(session()->has('teacher'))
    {        
        $homeHref = "/Folders";
    }
    else
    {
        $homeHref = "/";
    }
@endphp
    <!-- start Preloader  -->
    <div class="preloder_part">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
    <!-- End Preloader  -->
    <header class="header_part">
        <div class="sub_header section_bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-8">
                        <div class="header_contact_info">
                            <a href="tel:0140977200"><i class="icon_phone text-danger"></i>01 40 97 72 00</a>
                            <a href="mailto:inscriptions@liste.parinaterre.fr" target="_blank"><i class="icon_mail_alt text-danger"></i>inscriptions@liste.parinaterre.fr</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="header_iner d-flex justify-content-between align-items-center">
                            <div class="sidebar_icon troggle_icon d-lg-none">
                                <i class="icon_menu"></i>
                            </div>
                            <div class="logo">
                               <a href="{{ $homeHref }}">
                                    <img class="img-responsive" src="{{ asset('img/nanterreLogo.png') }}" alt="#">
                                </a>
                            </div>
                            <nav class="navbar_bar">
                                <ul>
                                    <li>
                                        <a href="{{ $homeHref }}"><h4>Gestion des candidatures</h4></a>
                                    </li>

                                    @php
                                        if(session()->has('student') || session()->has('teacher'))
                                        {
                                            if(session()->has('student'))
                                            {
                                    @endphp
                                    <li>
                                        <a href="/Profile">Profil</a>
                                    </li>
                                    @php
                                            }
                                    @endphp
                                    <li>
                                       <a id="logout" href="">Déconnexion</a>
                                     </li>
                                    @php
                                        }
                                    @endphp
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </header>
    <!-- header part end -->