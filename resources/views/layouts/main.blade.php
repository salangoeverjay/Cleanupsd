<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>
    @hasSection('title')
        @yield('title') | Beach & Ocean Clean-up Hub
    @else
        Beach & Ocean Clean-up Hub
    @endif
  </title>

  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo_full.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo_full.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logo_full.png') }}">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <style>
    body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); font-family: 'Figtree', sans-serif; scroll-behavior: smooth; min-height: 100vh; }
    .body-container { background: linear-gradient(to bottom, rgba(13, 110, 253, 1) 0%, rgba(0, 161, 230, 0.69) 50%, rgba(117, 211, 255, 0.45) 100%); border-radius: 10px; margin-top: 5px; margin-bottom: 5px;}
    .card { box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
    .search-box { max-width: 300px; }
    .hub-section, .about-section { text-align: center; padding: 20px 40px; }
    .hub-section h1, .about-section h1 { font-size: 2.5rem; font-weight: 700; color: #0d6efd; }
    .hub-section p, .about-section p { font-size: 1.2rem; max-width: 700px; margin: 20px auto 0; }
    .dashboard-title { font-size: 2rem; font-weight: 700; color: #0d6efd; }
    .override-color-white{ color: white !important;}
    .div-radius-items{ border-radius: 24px; background-color: #303034; margin-top: 20px;}
    
    /* Modern Navbar */
    .navbar-wrapper { 
      max-width: 1400px; 
      margin: 20px auto 0 auto; 
      padding: 0 20px; 
    }
    
    .navbar-blur {
      background: linear-gradient(135deg, rgba(0, 119, 182, 0.95) 0%, rgba(0, 180, 216, 0.95) 100%) !important;
      backdrop-filter: blur(20px) saturate(180%);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      box-shadow: 0 8px 32px rgba(0, 119, 182, 0.3);
      padding: 12px 24px;
    }
    
    .navbar-brand {
      transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover {
      transform: scale(1.05);
    }
    
    .navbar-brand img.logo {
      width: 50px;
      height: 50px;
      transition: all 0.3s ease;
      border: 2px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .navbar-brand:hover img.logo {
      border-color: rgba(255, 255, 255, 0.6);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.85) !important;
      font-weight: 600;
      font-size: 1rem;
      padding: 10px 20px !important;
      margin: 0 4px;
      border-radius: 12px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      letter-spacing: 0.3px;
    }
    
    .navbar-nav .nav-link::before {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 50%;
      transform: translateX(-50%) scaleX(0);
      width: 60%;
      height: 2px;
      background: white;
      border-radius: 2px;
      transition: transform 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover {
      color: white !important;
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }
    
    .navbar-nav .nav-link:hover::before {
      transform: translateX(-50%) scaleX(1);
    }
    
    .navbar-nav .nav-link.active {
      color: white !important;
      background: rgba(255, 255, 255, 0.2);
      font-weight: 700;
    }
    
    .navbar-nav .nav-link.active::before {
      transform: translateX(-50%) scaleX(1);
    }
    
    .navbar-toggler {
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 12px;
      padding: 8px 12px;
    }
    
    .navbar-toggler:focus {
      box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    }
    
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.95%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    @media (max-width: 991px) {
      .navbar-collapse {
        background: rgba(0, 119, 182, 0.98);
        padding: 20px;
        border-radius: 16px;
        margin-top: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
      }
      
      .navbar-nav .nav-link {
        margin: 4px 0;
      }
    }
    .modal-login { border-radius: 20px; background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); color: #ffffff; opacity: 0.95; }
    .form-label, .form-check-label { color: #fff; }
    body.modal-open { padding-right: 0 !important; }
    .navbar { transition: margin-right 0s; }
    
    /* Modern Auth Buttons */
    .btn-modern-login {
      background: rgba(255, 255, 255, 0.95);
      color: #0077b6;
      border: 2px solid rgba(255, 255, 255, 0.3);
      padding: 10px 28px;
      font-weight: 700;
      font-size: 0.95rem;
      border-radius: 50px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
      letter-spacing: 0.5px;
    }
    .btn-modern-login:hover {
      background: white;
      color: #005f73;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
      border-color: white;
    }
    
    .btn-modern-register {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
      color: white;
      border: 2px solid rgba(255, 255, 255, 0.6);
      padding: 10px 28px;
      font-weight: 700;
      font-size: 0.95rem;
      border-radius: 50px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      letter-spacing: 0.5px;
    }
    .btn-modern-register:hover {
      background: rgba(255, 255, 255, 0.95);
      color: #0077b6;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
      border-color: white;
    }
    
    .btn-modern-login i, .btn-modern-register i {
      font-size: 1.1rem;
      vertical-align: middle;
    }

  </style>

  @stack('styles') {{-- optional for page-specific styles --}}
</head>
<body>

  <!-- Navbar -->
  <div class="navbar-wrapper sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-blur">
      <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}">
          <img src="{{ asset('images/logo_sm.png')}}" alt="Logo" class="rounded-pill logo" style="margin-left: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link @if(request()->is('/')) active @endif" href="{{ route('index') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->is('about')) active @endif" href="{{ route('about') }}">About Us</a>
            </li>
          </ul>
          <div class="d-flex gap-2 align-items-center">
            <button class="btn btn-modern-login" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
            <button class="btn btn-modern-register" data-bs-toggle="modal" data-bs-target="#registerModal">
              <i class="bi bi-person-plus-fill me-2"></i>Get Started
            </button>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <main>
    @yield('content') {{-- page-specific content --}}
  </main>

  <!-- Register/Login Modal (can be triggered by buttons in pages) -->
  <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="authModalLabel">Welcome!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p>Please choose an option to continue:</p>
          <a href="{{ route('login') }}" class="btn btn-light btn-sm me-2">Login</a>
          <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center text-lg-start text-light" style="background-color: #1c1c1c; margin-top: 40px; border-radius: 10px 10px 0 0;">
    <div class="container p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="fw-bold text-info">Beach & Ocean Clean-Up Hub</h5>
          <p>Together, we can protect our oceans and preserve our beaches. Join our movement to create cleaner, safer, and healthier coastlines.</p>
        </div>
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="fw-bold text-info">Quick Links</h5>
          <ul class="list-unstyled mb-0">
            <li><a href="{{ route('index') }}" class="text-light text-decoration-none">Home</a></li>
            <li><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
            <li><a href="{{ route('index') }}#HowCanHelp" class="text-light text-decoration-none">How You Can Help</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.3);">
      © 2025 Beach & Ocean Clean-Up Hub | School Project – All Rights Reserved
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts') {{-- page-specific scripts --}}
</body>
</html>