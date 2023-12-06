<!-- Vertical navbar -->
<div class="vertical-nav bg-white no-print" id="sidebar">
    <div class="py-4 px-3 mb-4 bg-light">
        <div class="media d-flex align-items-center">
            <img loading="lazy" src="../images/admin.jpg" alt="..." width="80" height="80" class="mr-3 rounded-circle img-thumbnail shadow-sm">
            <div class="media-body">
                <h4 class="m-0">Nemi</h4>
                <p class="font-weight-normal text-muted mb-0">Foreman</p>
            </div>
        </div>
    </div>

    <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Dashboard</p>

    <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item ">
            <a href="../views/foreman.php" class="nav-link text-dark bg-light">
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


        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">
                <i class="fa fa-tasks " aria-hidden="true"></i> Tasks</a>
            <ul class="dropdown-menu">
                <!-- <li><a class="dropdown-item" href="#" id="Breakdown">Add Breakdown &raquo;</a></li>
                <li><a class="dropdown-item" href="#" id="Repair">Add Repair &raquo;</a></li>
                <li><a class="dropdown-item" href="#" id="Roster">View Roster &raquo;</a></li>
                <li><a class="dropdown-item" href="#" id="Trip">View Trips &raquo;</a></li> -->
            </ul>
        </li>


        <!-- end of test -->

        <!-- <li class="nav-item">
            <a href="#" class="nav-link text-dark" id="reservation">
                <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                Reservation
            </a>
        </li> -->
    </ul>
</div>
<!-- End vertical navbar -->