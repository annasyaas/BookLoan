<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-2">
            <a href="/">BOOK LOAN UNMUL</a>
        </div>
        <ul class="sidebar-menu mt-3">
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li class="{{ Request::is('book*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('book.index') }}"><i class="fa fa-book"></i> <span>Buku</span></a></li>
            <li class="{{ Request::is('member*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('member.index') }}"><i class="fa fa-users"></i> <span>Member</span></a></li>
            <li class="{{ Request::is('loan*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('loan.index') }}"><i class="fa fa-book-open"></i> <span>Peminjaman Buku</span></a></li>
            {{-- <li class="{{ Request::is('user*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.index') }}"><i class="fa fa-user-alt"></i> <span>User</span></a></li> --}}
            <li class="{{ Request::is('recommendation*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('recommendation') }}"><i class="fa fa-thumbs-up"></i> <span>Rekomendasi</span></a></li>
        </ul>
    </aside>
</div>