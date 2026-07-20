<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.doctors.index') }}">
                        <i class="fa fa-user-md"></i> <span>Doctors</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.patients.index') }}">
                        <i class="fa fa-wheelchair"></i> <span>Patients</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.appointments.index') }}">
                        <i class="fa fa-calendar"></i> <span>Appointments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.schedules.index') }}">
                        <i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.departments.index') }}">
                        <i class="fa fa-hospital-o"></i> <span>Departments</span>
                    </a>
                </li>
                <li class="menu-title">Financial Management</li>
                <li>
                    <a href="{{ route('admin.recipient-accounts.index') }}">
                        <i class="fa fa-university"></i> <span>Recipient Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payment-gateways.index') }}">
                        <i class="fa fa-credit-card"></i> <span>Payment Gateways</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bills.index') }}">
                        <i class="fa fa-file-text-o"></i> <span>Patient Bills</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.salary-structures.index') }}">
                        <i class="fa fa-money"></i> <span>Salary Structures</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.payrolls.index') }}">
                        <i class="fa fa-book"></i> <span>Payroll</span>
                    </a>
                </li>
                <li class="menu-title">Employee Management</li>

                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Employees</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ route('admin.employees.index') }}">Employees List</a></li>
                        <li><a href="{{ route('admin.leaves.index') }}">Leaves</a></li>
                        <li><a href="{{ route('admin.holidays.index') }}">Holidays</a></li>
                        <li><a href="{{ route('admin.attendances.index') }}">Attendance</a></li>
                    </ul>
                </li>
                <li class="menu-title">Communication</li>
                <li>
                    <a href="{{ route('admin.notification.index') }}">
                        <i class="fa fa-bell"></i> <span>Notifications</span>
                        <span id="sidebar-notification-count" class="badge badge-pill bg-danger float-right" style="display:none"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.chats.index') }}">
                        <i class="fa fa-comments"></i> <span>Chat</span>
                        <span id="sidebar-chat-count" class="badge badge-pill bg-danger float-right" style="display:none"></span>
                    </a>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-envelope"></i> <span>Email</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ route('admin.emails.index') }}">Email Logs</a></li>
                        <li><a href="{{ route('admin.emails.create') }}">Compose Mail</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.contacts.index') }}">
                        <i class="fa fa-envelope-o"></i> <span>Contact</span>
                    </a>
                </li>
                <li class="menu-title">Medical & Inventory</li>

                <li>
                    <a href="{{ route('admin.medicines.index') }}">
                        <i class="fa fa-medkit"></i> <span>Medicines</span>
                    </a>
                </li>
                <li class="menu-title">Content & Media</li>

                <li>
                    <a href="{{ route('admin.galleries.index') }}">
                        <i class="fa fa-image"></i> <span>Gallery</span>
                    </a>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-commenting-o"></i> <span>Blog</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ route('admin.blogs.index') }}">Blog List</a></li>
                        <li><a href="{{ route('admin.blogs.create') }}">Add Blog</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.subscribers.index') }}">
                        <i class="fa fa-users"></i> <span>Subscribers</span>
                    </a>
                </li>
                <li class="menu-title">System Administration</li>
                <li>
                    <a href="{{ route('admin.roles.index') }}">
                        <i class="fa fa-user-tag"></i> <span>Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fa fa-users-cog"></i> <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.activities.index') }}">
                        <i class="fa fa-bell-o"></i> <span>Activities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="fa fa-cog"></i> <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>