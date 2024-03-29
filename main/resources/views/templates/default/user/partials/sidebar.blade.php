 <!-- main-sidebar opened -->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar sidebar-scroll ">
     <div class="main-sidebar-header">
         <a class=" desktop-logo logo-light" href="/"><img src="{{ asset('assets/images/logoIcon/darkLogo.png') }}" class="main-logo"
                 alt="logo"></a>
         <a class=" desktop-logo logo-dark" href="/"><img src="{{ asset('assets/images/logoIcon/darkLogo.png') }}" width="100px" height="70px"
                 class="main-logo dark-theme" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-light" href="/"><img src="{{ asset('assets/images/logoIcon/favicon.png') }}"
                 class="logo-icon" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-dark" href="/"><img
                 src="{{ asset('assets/images/logoIcon/favicon.png') }}" class="logo-icon dark-theme" alt="logo"></a>
     </div>
     <div class="main-sidebar-body circle-animation ">

         <ul class="side-menu circle">
             <li>
                 <h3 class="">Dashboard</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.home') }}">
                     <i class="side-menu__icon ti-desktop"></i>
                     <span class="side-menu__label">
                         Dashboard
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.details') }}">
                     <i class="side-menu__icon ti-desktop"></i>
                     <span class="side-menu__label">
                         Details
                     </span>
                 </a>
             </li>
             <li>
                 <h3>KYC Registration</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon fe fe-user-check  menu-icons"></i>
                     <span class="side-menu__label">
                         Profile
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('user.profile-setting') }}">KYC</a>
                     </li>

                 </ul>
             </li>

             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon fa fa-tree  menu-icons"></i>
                     <span class="side-menu__label">
                         EPINS
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     {{-- <li><a class="slide-item" href="{{ route('user.epins.used') }}">Used Epins</a> --}}
             </li>
             <li><a class="slide-item" href="{{ route('user.epins.unused') }}">Unused Epins</a></li>
             {{-- <li><a class="slide-item" href="{{ route('user.epins.sent') }}">Sent Epins</a></li> --}}
         </ul>
         </li>



         <li>
             <h3>Genealogy</h3>
         </li>
         <li class="slide">
             <a class="side-menu__item" data-toggle="slide" href="#">
                 <i class="side-menu__icon fa fa-tree  menu-icons"></i>
                 <span class="side-menu__label">
                     Genealogy
                 </span>
                 <i class="angle fe fe-chevron-down"></i></a>
             <ul class="slide-menu">
                 <li><a class="slide-item" href="{{ route('user.my.tree') }}">Binary Tree</a>
                 </li>
                 <li><a class="slide-item" href="{{ route('user.my.ref') }}">Sponsor List</a></li>
                 <li><a class="slide-item" href="{{ route('user.binary.summary') }}">Placement List</a></li>
             </ul>
         </li>


         {{-- <li class="slide">
                        <a class="side-menu__item" href="{{ route('user.plan') }}">
                            <i class="side-menu__icon ti-light-bulb"></i>
                            <span class="side-menu__label">
                                Plan
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('user.pv.log') }}">
                            <i class="side-menu__icon fe fe-user"></i>
                            <span class="side-menu__label">
                                PV LOG
                            </span>
                        </a>
                    </li> --}}

         <li>
             <h3>Invest and Finances</h3>
         </li>

         <li class="slide">
             <a class="side-menu__item" href="{{ route('user.plan') }}">
                 <i class="side-menu__icon fas fa-money-bill "></i>
                 <span class="side-menu__label">
                     Investment
                 </span>
             </a>
         </li>
         {{-- <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-wallet  menu-icons"></i>
                     <span class="side-menu__label">
                         Investment
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('user.plan') }}">Investments</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('user.plan.fixed.investment') }}">Fixed Investments</a>
                     </li>
                 </ul>
             </li> --}}
         <li class="slide">
             <a class="side-menu__item" data-toggle="slide" href="#">
                 <i class="side-menu__icon ti-wallet  menu-icons"></i>
                 <span class="side-menu__label">
                     Finance
                 </span>
                 <i class="angle fe fe-chevron-down"></i></a>
             <ul class="slide-menu">
                 <li><a class="slide-item" href="{{ route('user.report.transactions') }}">Transaction
                         History</a>
                 </li>
                 <li><a class="slide-item" href="{{ route('user.report.withdraw') }}">Withdraw History</a>
                 </li>
                 <li><a class="slide-item" href="{{ route('user.report.invest') }}">Invest History</a></li>
                 <li><a class="slide-item" href="{{ route('user.withdraw') }}">Withdraw Now</a></li>
                 <li><a class="slide-item" href="{{ route('user.balance.transfer') }}">P2P transfer</a></li>
                 <li><a class="slide-item" href="{{ route('user.h_dshares') }}">HDShares</a></li>
                 {{-- <li><a class="slide-item" href="{{ route('user.report.refCom') }}">Referral Commission</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('user.report.binaryCom') }}">Binary Commission</a> --}}
         </li>
         </ul>
         </li>


         <li>
             <h3>Settings</h3>
         </li>

         <li class="slide">
             <a class="side-menu__item" data-toggle="slide" href="#">
                 <i class="side-menu__icon fa fa-cog  menu-icons"></i>
                 <span class="side-menu__label">
                     Settings
                 </span>
                 <i class="angle fe fe-chevron-down"></i></a>
             {{-- <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('ticket') }}">Ticket</a></li>
                 </ul> --}}
         </li>

         {{-- <li class="slide">
             <a class="side-menu__item" href="{{ route('user.balance.transfer') }}">
                 <i class="side-menu__icon ti-wallet"></i>
                 <span class="side-menu__label">
                     P2P Transfer
                 </span>
             </a>
         </li> --}}

         {{-- <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.my.ref') }}">
                     <i class="side-menu__icon fe fe-users"></i>
                     <span class="side-menu__label">
                         Referrals
                     </span>
                 </a>
             </li> --}}

         {{-- <li>
                 <h3>Withdraws & Reports</h3>
             </li> --}}
         {{-- <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.withdraw') }}">
                     <i class="side-menu__icon ti-wallet"></i>
                     <span class="side-menu__label">
                         Withdraw Now
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Reports / Log
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('user.report.transactions') }}">Transaction Log</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('user.report.withdraw') }}">Withdraw Log</a></li>
                     <li><a class="slide-item" href="{{ route('user.report.invest') }}">Invest Log</a></li>
                     <li><a class="slide-item" href="{{ route('user.report.refCom') }}">Referral Commission</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('user.report.binaryCom') }}">Binary Commission</a>
                     </li>
                 </ul>
             </li> --}}


         {{-- <li>
                 <h3>Profile</h3>
             </li> --}}

         </ul>
     </div>
 </aside>
 <!-- main-sidebar -->
