@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Analytics</li>
            <li class="{{ Request::is('analytics/collected-points') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsCollectedPoint') }}"><i class="fas fa-chart-area"></i><span>Data Collected Point</span></a>
            </li>
            <li class="{{ Request::is('analytics/history-quiz') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsHistoryQuiz') }}"><i class="fas fa-chart-area"></i><span>Data Riwayat Kuis</span></a>
            </li>
            <li class="{{ Request::is('analytics/withdrawals') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsWithdrawals') }}"><i class="fas fa-chart-line"></i><span>Data Withdraw</span></a>
            </li>
            <li class="{{ Request::is('analytics/withdrawals/accepted') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsWithdrawalsAccepted') }}"><i class="fas fa-chart-line"></i><span>Withdraw Accepted</span></a>
            </li>
            <li class="{{ Request::is('analytics/withdrawals/rejected') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsWithdrawalsRejected') }}"><i class="fas fa-chart-line"></i><span>Withdraw Rejected</span></a>
            </li>
            <li class="{{ Request::is('analytics/player-activity') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAnalyticsPlayerActivity') }}"><i class="far fa-chart-bar"></i><span>Data Aktivitas Player</span></a>
            </li>
            <li class="menu-header">Komponen</li>
            <li class="{{ Request::is('base-application') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goBaseApplication') }}"><i class="fab fa-android"></i><span>Base Application</span></a>
            </li>
            <li class="">
                <a class="nav-link" href="#"><i class="fa fa-plug"></i><span>Menu Dinamic</span></a>
            </li>
            <li class="{{ Request::is('banner') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goBanner') }}"><i class="far fa-images"></i><span>Banner</span></a>
            </li>
            <li class="{{ Request::is('avatar') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goAvatar') }}"><i class="far fa-grimace"></i><span>Avatar</span></a>
            </li>
            <li class="{{ Request::is('badge') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goBadge') }}"><i class="fas fa-ribbon"></i><span>Badge</span></a>
            </li>
            <li class="{{ Request::is('category-quiz') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goCategoryQuiz') }}"><i class="fas fa-feather-alt"></i><span>Kategori Kuis</span></a>
            </li>
            <li class="{{ Request::is('dana-kaget') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goDanaKaget') }}"><i class="fas fa-wallet"></i><span>Dana Kaget</span></a>
            </li>
            <li class="{{ Request::is('rewards-ad-points') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goRewardsAdPoints') }}"><i class="fas fa-coins"></i></i><span>Rewards Ad Point</span></a>
            </li>
            <li class="{{ Request::is('payment-method') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('goPaymentMethod') }}"><i class="fas fa-university"></i><span>Payment Method</span></a>
            </li>
            <li class="{{ Request::is('blacklist-number-wallet') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/blacklist-number-wallet') }}"><i class="fas fa-phone"></i><span>Blacklist Number</span></a>
            </li>
            <li class="menu-header">Tools</li>
            <li class="{{ Request::is('jobservices/panel-setting') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/jobservices/panel-setting') }}"><i class="fas fa-wrench"></i> <span>Panel Settings</span></a>
            </li>
            <li class="{{ Request::is('tools/api/v2') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/tools/api/v2') }}"><i class="fas fa-wrench"></i> <span>Rest API Test</span></a>
            </li>
            <li class="menu-header">Profile</li>
            <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/edit') }}"><i class="far fa-user"></i> <span>Profile</span></a>
            </li>
            <li class="{{ Request::is('profile/change-password') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/change-password') }}"><i class="fas fa-key"></i> <span>Ganti Password</span></a>
            </li>
        </ul>
    </aside>
</div>
@endauth
