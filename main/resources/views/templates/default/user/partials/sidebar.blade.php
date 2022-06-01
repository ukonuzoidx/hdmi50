 <!-- main-sidebar opened -->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar sidebar-scroll ">
     <div class="main-sidebar-header">
         <a class=" desktop-logo logo-light" href="index.html"><img src="../../assets/img/brand/logo.png"
                 class="main-logo" alt="logo"></a>
         <a class=" desktop-logo logo-dark" href="index.html"><img src="../../assets/img/brand/logo-white.png"
                 class="main-logo dark-theme" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-light" href="index.html"><img src="../../assets/img/brand/favicon.png"
                 class="logo-icon" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-dark" href="index.html"><img src="../../assets/img/brand/favicon-white.png"
                 class="logo-icon dark-theme" alt="logo"></a>
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
             <li>
                 <h3>KYC Registration</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.profile-setting') }}">
                     <i class="side-menu__icon fe fe-user-check"></i>
                     <span class="side-menu__label">Profile</span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('ticket') }}">
                     <i class="side-menu__icon ti-face-smile"></i>
                     <span class="side-menu__label">Ticket</span>
                 </a>
             </li>


             <li>
                 <h3>Genealogy</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.my.tree') }}">
                     <i class="side-menu__icon fa fa-tree"></i>
                     <span class="side-menu__label">
                         My Tree
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.binary.summary') }}">
                     <i class="side-menu__icon ti-bar-chart"></i>
                     {{-- <i class="side-menu__icon fe fe-bar-chart-2"></i> --}}
                     <span class="side-menu__label">
                         Binary Summary
                     </span>
                 </a>
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
                     <i class="side-menu__icon ti-light-bulb "></i>
                     <span class="side-menu__label">
                         Investment
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Finance
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
             </li>

             <li class="slide">
                 <a class="side-menu__item" href="{{ route('user.balance.transfer') }}">
                     <i class="side-menu__icon ti-wallet"></i>
                     <span class="side-menu__label">
                         P2P Transfer
                     </span>
                 </a>
             </li>

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
