 <!-- SIDEBAR - START -->
 <div class="page-sidebar ">

     <!-- MAIN MENU - START -->
     <div class="page-sidebar-wrapper" id="main-menu-wrapper">

         <!-- USER INFO - START -->
         <div class="profile-info row">

             <div class="profile-image col-lg-4 col-md-4 col-4">
                 <a href="{{route('users.show', auth()->user()->id)}}">
                     <img src="{{asset('storage/' . auth()->user()->photo)}}" class="img-fluid rounded-circle">
                 </a>
             </div>

             <div class="profile-details col-lg-8 col-md-8 col-8">

                 <h3>
                     <a href="{{route('users.edit', auth()->user()->id)}}">{{auth()->user()->lastname . ' '. auth()->user()->firstname}}</a>

                     <!-- Available statuses: online, idle, busy, away and offline -->
                     <span class="profile-status online"></span>
                 </h3>

                 <p class="profile-title">{{auth()->user()->title}}</p>

             </div>

         </div>
         <!-- USER INFO - END -->



         <ul class='wraplist'>


             @if (Request::is('dashboard/*'))
             <li class="open">
                 <a href="/dashboard">
                     <i class="fa fa-dashboard"></i>
                     <span class="title">Dashboard</span>
                 </a>
             </li>
             @endif

             @if (Request::is('facturation_gestion_financiere/*'))
             <li class="open">
                 <a href="javascript:;">
                     <i class="fa fa-dollar "></i>
                     <span class="title">Dépenses</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="{{route('expenses.index')}}">Liste des dépenses</a>
                     </li>
                    
                     <li class="">
                         <a href="javascript:;">
                             <i class="fa fa-list "></i>
                             <span class="title">Demande de dépense</span>
                             <span class="arrow "></span>
                         </a>
                         <ul class="sub-menu">
                             <li>
                                 <a class="" href="{{route('expenses_requests.index')}}">Liste des demande de dépenses</a>
                             </li>
                             <li>
                                 <a class="" href="{{route('expenses_requests.create')}}">Enregistrer une demande</a>
                             </li>
                         </ul>
                     </li>
                     <li class="">
                         <a href="javascript:;">
                             <i class="fa fa-list "></i>
                             <span class="title">Catégories</span>
                             <span class="arrow "></span>
                         </a>
                         <ul class="sub-menu">
                             <li>
                                 <a class="" href="{{route('categ_expenses.index')}}">Liste des catégories</a>
                             </li>
                             <li>
                                 <a class="" href="{{route('categ_expenses.create')}}">Enregistrer une catégorie</a>
                             </li>
                         </ul>
                     </li>
                 </ul>

             </li>
             @endif

             @if (Request::is('gestion_utilisateur/*'))

             <li class="open">
                 <a href="javascript:;">
                     <i class="fa fa-user-md"></i>
                     <span class="title">Gestion des utilisateurs</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="{{route('users.index')}}">Liste des utilisateurs</a>
                     </li>
                     <li>
                         <a class="" href="{{route('users.create')}}">Ajouter un utilisateur</a>
                     </li>
                     <li class="">
                         <a href="javascript:;">
                             <i class="fa fa-user-md"></i>
                             <span class="title">Gestion des rôles</span>
                             <span class="arrow "></span>
                         </a>
                         <ul class="sub-menu">
                             <li>
                                 <a class="" href="{{route('roles.index')}}">Liste des rôles</a>
                             </li>
                             <li>
                                 <a class="" href="{{route('roles.create')}}">Ajouter un rôle</a>
                             </li>

                         </ul>
                     </li>
                     <li class="">
                         <a href="javascript:;">
                             <i class="fa fa-user-md"></i>
                             <span class="title">Gestion des permissions</span>
                             <span class="arrow "></span>
                         </a>
                         <ul class="sub-menu">
                             <li>
                                 <a class="" href="{{route('permissions.index')}}">Liste des permissions</a>
                             </li>
                             <li>
                                 <a class="" href="{{route('permissions.create')}}">Ajouter un permission</a>
                             </li>

                         </ul>
                     </li>
                 </ul>

             </li>
             @endif
             <!--
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-users"></i>
                     <span class="title">Patients</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-patients.html">All Patients</a>
                     </li>
                     <li>
                         <a class="" href="hos-patient-add.html">Add Patient</a>
                     </li>
                     <li>
                         <a class="" href="hos-patient-edit.html">Edit Patient</a>
                     </li>
                     <li>
                         <a class="" href="hos-patient-profile.html">Patient Profile</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-calendar-o"></i>
                     <span class="title">Appointment</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-doc-schedule.html">Doctor Schedule</a>
                     </li>
                     <li>
                         <a class="" href="hos-book-appointment.html">Book Appointment</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-bar-chart"></i>
                     <span class="title">Reports</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-report-patient.html">Patient</a>
                     </li>
                     <li>
                         <a class="" href="hos-report-hospital.html">Hospital</a>
                     </li>
                     <li>
                         <a class="" href="hos-report-sales.html">Sales</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-dollar "></i>
                     <span class="title">Billing</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-payments.html">Payments</a>
                     </li>
                     <li>
                         <a class="" href="hos-payment-add.html">Add Payment</a>
                     </li>
                     <li>
                         <a class="" href="hos-patient-invoice.html">Patient Invoice</a>
                     </li>
                 </ul>
             </li>

             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-envelope"></i>
                     <span class="title">Mailbox</span>
                     <span class="arrow "></span><span class="badge badge-orange">4</span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-mail-inbox.html">Inbox</a>
                     </li>
                     <li>
                         <a class="" href="hos-mail-compose.html">Compose</a>
                     </li>
                     <li>
                         <a class="" href="hos-mail-view.html">View</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-map-marker"></i>
                     <span class="title">WorldWide Centres</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-centres.html">Facility Locations</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="javascript:;">
                     <i class="fa fa-users"></i>
                     <span class="title">Hospital Staff</span>
                     <span class="arrow "></span>
                 </a>
                 <ul class="sub-menu">
                     <li>
                         <a class="" href="hos-staffs.html">All Staff Members</a>
                     </li>
                     <li>
                         <a class="" href="hos-staff-add.html">Add Staff Member</a>
                     </li>
                     <li>
                         <a class="" href="hos-staff-edit.html">Edit Staff Member</a>
                     </li>
                     <li>
                         <a class="" href="hos-staff-profile.html">Staff Member Profile</a>
                     </li>
                 </ul>
             </li>
             <li class="">
                 <a href="hos-events.html">
                     <i class="fa fa-calendar"></i>
                     <span class="title">Event Management</span>
                 </a>
             </li> -->


         </ul>

     </div>
     <!-- MAIN MENU - END -->



     <div class="project-info">

         <div class="block1">
             <div class="data">
                 <span class='title'>Patients</span>
                 <span class='total'>1,245</span>
             </div>
             <div class="graph">
                 <span class="sidebar_orders">...</span>
             </div>
         </div>

         <div class="block2">
             <div class="data">
                 <span class='title'>Beds&nbsp;Used</span>
                 <span class='total'>242</span>
             </div>
             <div class="graph">
                 <span class="sidebar_visitors">...</span>
             </div>
         </div>

     </div>



 </div>
 <!--  SIDEBAR - END -->