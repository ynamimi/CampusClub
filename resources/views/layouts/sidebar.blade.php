<!-- resources/views/layouts/sidebar.blade.php -->

<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h4>Admin Dashboard</h4>
    </div>

    <!-- Sidebar Menu -->
    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('president.dashboard') }}">Dashboard</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('president.updateDetails') }}">Update Details</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('president.memberships') }}">Memberships</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('president.clubReport') }}">Club Reports</a>
        </li>
    </ul>
</div>
