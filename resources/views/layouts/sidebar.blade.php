<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">لوحة التحكم</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>الرئيسية</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>إدارة المهام</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
