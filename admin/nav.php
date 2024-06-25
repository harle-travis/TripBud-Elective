<style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;

        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-dark {
            background-color: #343a40;
            border-color: #343a40;
            border-radius: 5px;
        }

        .btn-dark:hover {
            background-color: #23272b;
            border-color: #1d2124;
        }

        .error {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .requirements {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
    <style>
       
        .table {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .btn {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }


        .page {
            width: 50px
        }

        .selectPage {
            margin-left: 10px;
        }

  .sidebar {
    position: fixed; /* Fix the sidebar position */
    top: 0;
    left: 0;
    width: 270px; /* Set the width of the sidebar */
    height: 100vh !important; /* Make the sidebar full height of the viewport */
    overflow-y: auto; /* Add scrollbar for overflow */
    background-color: #f8f9fa; /* Set your desired background color */
    border-right: 1px solid #dee2e6; /* Add border for separation */
    z-index: 1000; /* Ensure sidebar appears above other content */
}

.content {
    margin-left: 270px; /* Set margin-left equal to the width of the sidebar */
    padding: 20px;
    overflow: hidden; /* Clear the float */
}
.bx{
    font-size: 30px;
}

#sidebar {
    background-color: #f8f9fa; /* Set your desired background color */
    border-right: 1px solid #dee2e6; /* Add border for separation */
}

.sidebar-header {
    padding: 10px;
    border-bottom: 1px solid #dee2e6; /* Add border bottom */
}

.sidebar-menu {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    padding: 10px;
    border-bottom: 1px solid #dee2e6; /* Add border bottom for each item */
}

.sidebar-menu li:last-child {
    border-bottom: none; /* Remove border bottom for last item */
}

.sidebar-menu a {
    color: #212529; /* Set text color */
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar-menu a:hover {
    background-color: #e2e6ea; /* Change background color on hover */
}

.menu-text {
    margin-left: 10px; /* Add space between icon and text */
}

        #sidebar.collapsed {
    width: 80px; /* Adjust as needed */
}

#sidebar.collapsed #sidebarHeaderText {
    display: none;
}

#sidebar.collapsed .menu-text {
    display: none;
}
.col-md-9-expanded {
    width: calc(100% - 90px); /* Adjust the width as needed */
    transition: width 0.5s ease; /* Add transition effect for smoothness */
}


    </style>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3" id="sidebar">
    <div class="sidebar-header">
        <button class="btn" type="button" id="sidebarCollapse">
            <i class="bx bx-menu"></i>
        </button>
        <span id="sidebarHeaderText">Southpick Resort & Hotel</span>
    </div>
    <ul class="sidebar-menu">
        <li><a href="rooms.php"><i class='bx bxs-hotel'></i> <span class="menu-text">Rooms</span></a></li>
        <li><a href="calendar.php"><i class='bx bx-calendar'></i> <span class="menu-text">Calendar</span></a></li>
        <li><a href="create-admin.php"><i class='bx bx-user'></i> <span class="menu-text">Create Admin</span></a></li>
        <li><a href="payment.php"><i class='bx bx-money'></i> <span class="menu-text">Booking Payment</span></a></li>
        <li><a href="logout.php"><i class='bx bx-power-off'></i> <span class="menu-text">Log out</span></a></li>
    </ul>
</div>
