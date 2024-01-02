 <!-- SIDEBAR - START -->
 <div class="page-sidebar ">

<!-- MAIN MENU - START -->
<div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

    <!-- USER INFO - START -->
    <div class="profile-info row">

        <div class="profile-image col-lg-4 col-md-4 col-4">
            <a href="ui-profile.html">
                <img src="{{asset('data/profile/profile-hospital.jpg')}}" class="img-fluid rounded-circle">
            </a>
        </div>

        <div class="profile-details col-lg-8 col-md-8 col-8">

            <h3>
                <a href="ui-profile.html">{{auth()->user()->lastname . ' '. auth()->user()->firstname}}</a>

                <!-- Available statuses: online, idle, busy, away and offline -->
                <span class="profile-status online"></span>
            </h3>

            <p class="profile-title">Surgeon</p>

        </div>

    </div>
    <!-- USER INFO - END -->



    <ul class='wraplist'>	


        <li class="open"> 
            <a href="index-hospital.html">
                <i class="fa fa-dashboard"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-user-md"></i>
                <span class="title">Doctors</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-doctors.html" >All Doctors</a>
                </li>
                <li>
                    <a class="" href="hos-doctor-add.html" >Add Doctor</a>
                </li>
                <li>
                    <a class="" href="hos-doctor-edit.html" >Edit Doctor</a>
                </li>
                <li>
                    <a class="" href="hos-doctor-profile.html" >Doctor Profile</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-users"></i>
                <span class="title">Patients</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-patients.html" >All Patients</a>
                </li>
                <li>
                    <a class="" href="hos-patient-add.html" >Add Patient</a>
                </li>
                <li>
                    <a class="" href="hos-patient-edit.html" >Edit Patient</a>
                </li>
                <li>
                    <a class="" href="hos-patient-profile.html" >Patient Profile</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-calendar-o"></i>
                <span class="title">Appointment</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-doc-schedule.html" >Doctor Schedule</a>
                </li>
                <li>
                    <a class="" href="hos-book-appointment.html" >Book Appointment</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-bar-chart"></i>
                <span class="title">Reports</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-report-patient.html" >Patient</a>
                </li>
                <li>
                    <a class="" href="hos-report-hospital.html" >Hospital</a>
                </li>
                <li>
                    <a class="" href="hos-report-sales.html" >Sales</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-dollar "></i>
                <span class="title">Billing</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-payments.html" >Payments</a>
                </li>
                <li>
                    <a class="" href="hos-payment-add.html" >Add Payment</a>
                </li>
                <li>
                    <a class="" href="hos-patient-invoice.html" >Patient Invoice</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-envelope"></i>
                <span class="title">Mailbox</span>
                <span class="arrow "></span><span class="badge badge-orange">4</span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-mail-inbox.html" >Inbox</a>
                </li>
                <li>
                    <a class="" href="hos-mail-compose.html" >Compose</a>
                </li>
                <li>
                    <a class="" href="hos-mail-view.html" >View</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-map-marker"></i>
                <span class="title">WorldWide Centres</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-centres.html" >Facility Locations</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="javascript:;">
                <i class="fa fa-users"></i>
                <span class="title">Hospital Staff</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu" >
                <li>
                    <a class="" href="hos-staffs.html" >All Staff Members</a>
                </li>
                <li>
                    <a class="" href="hos-staff-add.html" >Add Staff Member</a>
                </li>
                <li>
                    <a class="" href="hos-staff-edit.html" >Edit Staff Member</a>
                </li>
                <li>
                    <a class="" href="hos-staff-profile.html" >Staff Member Profile</a>
                </li>
            </ul>
        </li>
        <li class=""> 
            <a href="hos-events.html">
                <i class="fa fa-calendar"></i>
                <span class="title">Event Management</span>
            </a>
        </li>
       

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