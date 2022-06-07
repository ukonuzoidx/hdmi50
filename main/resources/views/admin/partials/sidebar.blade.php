 <!-- main-sidebar opened -->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar sidebar-scroll ">
     <div class="main-sidebar-header">
         <a class=" desktop-logo logo-light" href="index.html"><img src="{{ asset('assets/img/brand/logo.png') }}"
                 class="main-logo" alt="logo"></a>
         <a class=" desktop-logo logo-dark" href="index.html"><img src="{{ asset('assets/img/brand/logo-white.png') }}"
                 class="main-logo dark-theme" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-light" href="index.html"><img src="{{ asset('assets/img/brand/favicon.png') }}"
                 class="logo-icon" alt="logo"></a>
         <a class="logo-icon mobile-logo icon-dark" href="index.html"><img src="{{ asset('assets/img/brand/favicon-white.png') }}"
                 class="logo-icon dark-theme" alt="logo"></a>
     </div>
     <div class="main-sidebar-body circle-animation ">

         <ul class="side-menu circle">
             <li>
                 <h3 class="">Dashboard</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                     <i class="side-menu__icon ti-desktop"></i>
                     <span class="side-menu__label">
                         Dashboard
                     </span>
                 </a>
             </li>
             <li>
                 <h3>Plans & PV</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.plan') }}">
                     <i class="side-menu__icon ti-light-bulb"></i>
                     <span class="side-menu__label">
                         Plan
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.digital.assets.index') }}">
                     <i class="side-menu__icon ti-light-bulb"></i>
                     <span class="side-menu__label">
                         Digital Assets
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Users
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('admin.users.all') }}">All Users</a></li>
                     <li><a class="slide-item" href="{{ route('admin.users.active') }}">Active Users</a></li>
                     <li>
                         <a class="slide-item" href="{{ route('admin.users.banned') }}">
                             Banned Users
                             @if ($banned_users_count)
                                 <span class="badge badge-danger side-badge">{{ $banned_users_count }}</span>
                             @endif
                         </a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.users.emailUnverified') }}">
                             Email Unverified
                             @if ($email_unverified_users_count)
                                 <span
                                     class="badge badge-danger side-badge">{{ $email_unverified_users_count }}</span>
                             @endif
                         </a></li>
                     <li><a class="slide-item" href="{{ route('admin.users.smsUnverified') }}">
                             SMS Unverified
                             @if ($sms_unverified_users_count)
                                 <span class="badge badge-danger side-badge">{{ $sms_unverified_users_count }}</span>
                             @endif
                         </a>
                     </li>
                 </ul>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-pie-chart"></i>
                     <span class="side-menu__label">Withdrawals</span>
                     @if ($pending_withdraw_count)
                         <span class="badge badge-danger side-badge">{{ $pending_withdraw_count }}</span>
                     @endif
                     <i class="angle fe fe-chevron-down"></i>
                 </a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('admin.withdraw.method.index') }}">Withrawal
                             Methods</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.pending') }}">
                             Pending Withdrawal

                         </a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.approved') }}">Approved
                             Withdrawal</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.rejected') }}">Rejected
                             Withdrawal</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.log') }}">All Withdrawls</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.shiba.pending') }}">
                             Pending Shiba

                         </a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.shiba.approved') }}">Approved
                             Shiba</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.shiba.rejected') }}">Rejected
                             Shiba</a></li>
                     <li><a class="slide-item" href="{{ route('admin.withdraw.shiba.log') }}">All Shiba Withdrawal</a></li>
                 </ul>
             </li>

             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Support Ticket
                         @if (0 < $pending_ticket_count)
                             <span class="badge badge-info side-badge">
                                 <i class="fa fa-exclamation"></i>
                             </span>
                         @endif
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('admin.ticket') }}">All Ticket</a></li>
                     <li><a class="slide-item" href="{{ route('admin.ticket.pending') }}">
                             Pending Ticket
                             @if ($pending_ticket_count)
                                 <span class="badge badge-danger side-badge">{{ $pending_ticket_count }}</span>
                             @endif
                         </a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.ticket.answered') }}">Answered Ticket</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.ticket.closed') }}">Closed Ticket</a></li>
                 </ul>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Reports & Analytics
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('admin.report.transaction') }}">Transaction Log</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.report.invest') }}">Invest Log</a></li>
                     <li><a class="slide-item" href="{{ route('admin.report.pvLog') }}">PV Log</a></li>
                     <li><a class="slide-item" href="{{ route('admin.report.refCom') }}">Referral Commissions</a>
                     </li>
                     <li><a class="slide-item" href="{{ route('admin.report.binaryCom') }}">Binary Commission</a>
                     </li>

                 </ul>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-book  menu-icons"></i>
                     <span class="side-menu__label">
                         Epins
                     </span>
                     <i class="angle fe fe-chevron-down"></i></a>
                 <ul class="slide-menu">
                     <li><a class="slide-item" href="{{ route('admin.epins.all') }}">All Epins</a></li>
                     <li><a class="slide-item" href="{{ route('admin.epins.used') }}">Used Epins</a></li>
                     <li><a class="slide-item" href="{{ route('admin.epins.unused') }}">Unused Epin</a></li>

                 </ul>
             </li>
             <li>
                 <h3>Referrals & My Tree</h3>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.setting.index') }}">
                     <i class="side-menu__icon fe fe-users"></i>
                     <span class="side-menu__label">
                         General Settings
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.setting.logo_icon') }}">
                     <i class="side-menu__icon fa fa-tree"></i>
                     <span class="side-menu__label">
                         Logo Icon
                     </span>
                 </a>
             </li>

               <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.seo') }}">
                     <i class="side-menu__icon fa fa-tree"></i>
                     <span class="side-menu__label">
                         SEO Manager
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-pie-chart"></i>
                     <span class="side-menu__label">Email Templates</span>

                     <i class="angle fe fe-chevron-down"></i>
                 </a>
                 <ul class="slide-menu">
                     <li>
                         <a class="slide-item" href="{{ route('admin.email.template.index') }}">
                             Email Templates
                         </a>
                     </li>
                     <li>
                         <a class="slide-item" href="{{ route('admin.email.template.setting') }}">
                             Email Configure
                         </a>
                     </li>
                     <li>
                         <a class="slide-item" href="{{ route('admin.email.template.global') }}">
                             Global Email Templates
                         </a>
                     </li>

                 </ul>
             </li>

           
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.frontend.templates') }}">
                     <i class="side-menu__icon fa fa-tree"></i>
                     <span class="side-menu__label">
                         Manage Templates
                     </span>
                 </a>
             </li>
             <li class="slide">
                 <a class="side-menu__item" href="{{ route('admin.frontend.manage.pages') }}">
                     <i class="side-menu__icon fa fa-tree"></i>
                     <span class="side-menu__label">
                         Manage Pages
                     </span>
                 </a>
             </li>

             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="side-menu__icon ti-pie-chart"></i>
                     <span class="side-menu__label">Manage Sections</span>

                     <i class="angle fe fe-chevron-down"></i>
                 </a>
                 <ul class="slide-menu">
                     @php
                         $lastSegment = collect(request()->segments())->last();
                     @endphp
                     @foreach (getPageSections(true) as $key => $section)
                         <li>
                             <a class="slide-item" href="{{ route('admin.frontend.sections', $key) }}">
                                 {{ $section['name'] }}
                             </a>
                         </li>
                     @endforeach

                 </ul>
             </li>
         </ul>
     </div>
 </aside>
 <!-- main-sidebar -->
