<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">HAST</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('school/home') }}" class="active">Home<br></a></li>
          <li><a href="{{ url('about.html') }}">About</a></li>
          <li><a href="{{ url('school/crouses') }}">Courses</a></li>
          <li><a href="{{ url('school/trainers') }}">Trainers</a></li>
          <li><a href="{{ url('contact.html') }}">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ url('login') }}">Login</a>

    </div>
  </header>