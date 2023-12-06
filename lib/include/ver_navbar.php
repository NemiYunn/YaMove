 <!-- Vertical navbar -->
 <div class="vertical-nav bg-white no-print" id="sidebar">
   <div class="py-4 px-3 mb-4 bg-light">
     <div class="media d-flex align-items-center">
       <img loading="lazy" src="../images/admin.jpg" alt="..." width="80" height="80" class="mr-3 rounded-circle img-thumbnail shadow-sm">
       <div class="media-body">
         <h4 class="m-0">Nemi</h4>
         <p class="font-weight-normal text-muted mb-0">Admin</p>
       </div>
     </div>
   </div>

   <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Dashboard</p>

   <ul class="nav flex-column bg-white mb-0">
     <li class="nav-item ">
       <a href="../views/admin.php" class="nav-link text-dark bg-light">
         <i class="fa fa-home fa-lg" aria-hidden="true"></i>
         home
       </a>
     </li>
     <li class="nav-item">
       <a href="#" class="nav-link text-dark " id="notify" style="position: relative; display: inline-block;">
         <i class="fa fa-bell-o " aria-hidden="true"></i>

         <span style="position: absolute; top: -1px; right: -6px; font-size: 12px; border-radius: 50%; padding: 4px 6px;" class="badge bg-danger badge-number" id="countNotification">3</span>
         notifications
       </a>
     </li>
     <!-- <li class="nav-item">
       <a href="#" class="nav-link text-dark">
         <i class="fa fa-address-card mr-3 text-primary fa-fw"></i>
         about
       </a>
     </li> -->
     <!-- <li class="nav-item dropdown text-dark"> 
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa fa-cubes text-primary fa-fw"></i> Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" id="addEmp">Add EMP</a></li>
            <li><a class="dropdown-item" href="#" id="viewEmp">View EMP</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="loginMng">Login Management</a></li>
          </ul>
      </li> -->

     <!-- test -->


     <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">
         <i class="fa fa-tasks " aria-hidden="true"></i> Tasks</a>
       <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="#" id="manageBus">Manage Buses &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="manageSchedule">Manage Schedules &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="manageSecFare">Manage Section Fare &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="manageEmp">Manage EMP &raquo;</a></li>
       </ul>
     </li>


     <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">
         <i class="fa fa-newspaper-o" aria-hidden="true"></i> Reports
       </a>
       <ul class="dropdown-menu">
         <!-- <li><a class="dropdown-item" href="#" id="mthReservation">Monthly Reservation &raquo;</a></li> -->
         <!-- <li><a class="dropdown-item" href="#" id="try">Try &raquo;</a></li> -->
         <li><a class="dropdown-item" href="#" id="daily">Daily Reports &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="custom">Custom Reports &raquo;</a></li>
       </ul>
     </li>



     <!-- end of test -->

     <!-- <li class="nav-item">
       <a href="#" class="nav-link text-dark" id="adminReport">
         <i class="fa fa-newspaper-o" aria-hidden="true"></i>
         Reports
       </a>
       <ul class="dropdown-menu">
         <li><a class="dropdown-item" href="#" id="mthReservation">Monthly Reservation &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="try">Try &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="manageSecFare">Manage Section Fare &raquo;</a></li>
         <li><a class="dropdown-item" href="#" id="manageEmp">Manage EMP &raquo;</a></li>
       </ul>
     </li> -->


   </ul>

   <!-- <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Charts</p>

   <ul class="nav flex-column bg-white mb-0">
     <li class="nav-item">
       <a href="#" class="nav-link text-dark">
         <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
         area charts
       </a>
     </li>
     <li class="nav-item">
       <a href="#" class="nav-link text-dark">
         <i class="fa fa-bar-chart mr-3 text-primary fa-fw"></i>
         bar charts
       </a>
     </li>
     <li class="nav-item">
       <a href="#" class="nav-link text-dark">
         <i class="fa fa-pie-chart mr-3 text-primary fa-fw"></i>
         pie charts
       </a>
     </li>
     <li class="nav-item">
       <a href="#" class="nav-link text-dark">
         <i class="fa fa-line-chart mr-3 text-primary fa-fw"></i>
         line charts
       </a>
     </li>
   </ul> -->
 </div>
 <!-- End vertical navbar -->