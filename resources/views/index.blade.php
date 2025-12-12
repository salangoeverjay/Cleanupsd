@extends('layouts.main')

@section('title', 'Home')

@push('styles')
<style>
  .hero-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,31,63,0.8) 0%, rgba(0,119,182,0.6) 100%);
    z-index: 1;
  }
  .hero-content {
    z-index: 2;
    animation: fadeInUp 1s ease-out;
  }
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  .modern-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .modern-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0,119,182,0.3);
  }
  .gradient-card-1 {
    background: linear-gradient(135deg, #005f73 0%, #0a9396 100%);
  }
  .gradient-card-2 {
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
  }
  .gradient-card-3 {
    background: linear-gradient(135deg, #219ebc 0%, #8ecae6 100%);
  }
  .btn-modern {
    background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
    border: none;
    padding: 16px 48px;
    font-size: 1.2rem;
    font-weight: 700;
    border-radius: 50px;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,119,182,0.4);
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,119,182,0.6);
    background: linear-gradient(135deg, #0077b6 0%, #005f73 100%);
  }
  .feature-icon {
    font-size: 3rem;
    color: #00b4d8;
    margin-bottom: 1rem;
  }
  .stats-number {
    font-size: 3.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .modal-content-modern {
    background: linear-gradient(135deg, rgba(0,119,182,0.98) 0%, rgba(0,180,216,0.98) 100%);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-control-modern {
    background: rgba(255,255,255,0.9);
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    padding: 14px 18px;
    transition: all 0.3s ease;
  }
  .form-control-modern:focus {
    background: rgba(255,255,255,1);
    border-color: #00b4d8;
    box-shadow: 0 0 0 4px rgba(0,180,216,0.2);
  }
  .btn-auth {
    background: rgba(255,255,255,0.2);
    border: 2px solid white;
    color: white;
    padding: 14px;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
  }
  .btn-auth:hover {
    background: white;
    color: #0077b6;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,255,255,0.3);
  }
  .wave-divider {
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path fill="%23ffffff" d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"/><path fill="%23ffffff" d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"/><path fill="%23ffffff" d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"/></svg>') no-repeat center;
    background-size: cover;
    height: 80px;
    margin-top: -1px;
  }
</style>
@endpush

@section('content')
<!-- Hero Section with Video Background -->
<section id="hub" class="position-relative overflow-hidden" style="min-height: 100vh;">
  <!-- Video Background -->
  <video style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;" autoplay preload muted loop playsinline>
    <source src="{{ asset('videos/hero.mp4')}}" type="video/mp4">
  </video>
  
  <!-- Gradient Overlay -->
  <div class="hero-gradient-overlay"></div>
  
  <!-- Hero Content -->
  <div class="hero-content position-relative d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container text-center text-white px-4">
      <h1 class="display-1 fw-bolder mb-4" style="font-size: clamp(2.5rem, 8vw, 6rem); text-shadow: 2px 4px 12px rgba(0,0,0,0.3);">
        Protect Our Beaches,<br>Save Our Oceans
      </h1>
      <p class="lead mb-5" style="font-size: clamp(1.2rem, 3vw, 1.8rem); max-width: 800px; margin: 0 auto; text-shadow: 1px 2px 8px rgba(0,0,0,0.4);">
        Join a movement dedicated to cleaning up coastlines and preserving marine life.<br>
        <strong>Every action counts.</strong>
      </p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <button type="button" class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#registerModal">
          <i class="bi bi-person-plus-fill me-2"></i>Get Started
        </button>
        <button type="button" class="btn btn-modern" style="background: linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.1) 100%); backdrop-filter: blur(10px);" data-bs-toggle="modal" data-bs-target="#loginModal">
          <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
      </div>
    </div>
  </div>
  
  <!-- Wave Divider -->
  <div class="wave-divider position-absolute bottom-0 w-100"></div>
</section>

<!-- About Us Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
  <div class="container py-5">
    <div class="modern-card shadow-lg p-5 text-center" style="background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); color: white;">
      <i class="bi bi-info-circle-fill" style="font-size: 3.5rem; margin-bottom: 1.5rem;"></i>
      <h2 class="display-4 fw-bold mb-4">About Us</h2>
      <p class="lead mb-4" style="max-width: 900px; margin: 0 auto;">
        The <strong>Beach and Ocean Clean-up Hub</strong> is a community-driven initiative 
        dedicated to protecting coastal and marine ecosystems by encouraging volunteerism, 
        environmental awareness, and sustainable practices.
      </p>
      <p class="mb-0" style="max-width: 900px; margin: 0 auto; font-size: 1.1rem;">
        We believe that through collective effort, small actions can make a big difference 
        in reducing marine debris and safeguarding our ocean for future generations.
      </p>
    </div>
  </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5" style="background: white;">
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="display-4 fw-bold mb-3" style="color: #0077b6;">Our Mission & Vision</h2>
      <p class="lead text-muted">Guided by purpose, driven by passion</p>
    </div>

    <div class="row g-4 mb-5">
      <!-- Mission -->
      <div class="col-md-6">
        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="position-relative" style="height: 250px; overflow: hidden;">
            <img src="{{ asset('images/mission.jpg') }}" class="w-100 h-100" style="object-fit: cover;" alt="Mission Image">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(15,32,39,0.85) 0%, rgba(32,58,67,0.85) 50%, rgba(44,83,100,0.85) 100%);"></div>
          </div>
          <div class="card-body p-4" style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%); color: #ffffff;">
            <div class="text-center mb-3">
              <i class="bi bi-bullseye" style="font-size: 2.5rem;"></i>
            </div>
            <h3 class="fw-bold text-center mb-4">Our Mission</h3>
            <p class="text-center mb-0">
              To raise awareness and take action in protecting our oceans and beaches. 
              We aim to engage students, families, and communities in clean-up drives 
              and sustainable practices that reduce pollution and preserve marine ecosystems.
            </p>
          </div>
        </div>
      </div>

      <!-- Vision -->
      <div class="col-md-6">
        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="position-relative" style="height: 250px; overflow: hidden;">
            <img src="{{ asset('images/vision.jpeg') }}" class="w-100 h-100" style="object-fit: cover;" alt="Vision Image">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(30,60,114,0.85) 0%, rgba(42,82,152,0.85) 100%);"></div>
          </div>
          <div class="card-body p-4" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #ffffff;">
            <div class="text-center mb-3">
              <i class="bi bi-eye-fill" style="font-size: 2.5rem;"></i>
            </div>
            <h3 class="fw-bold text-center mb-4">Our Vision</h3>
            <p class="text-center mb-0">
              A cleaner, safer, and healthier environment where oceans thrive, 
              marine life is protected, and future generations can enjoy the beauty of nature 
              without the threat of pollution and destruction.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3">
        <div class="modern-card p-4 h-100 shadow">
          <div class="stats-number">500+</div>
          <p class="text-muted fw-semibold mb-0">Volunteers</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="modern-card p-4 h-100 shadow">
          <div class="stats-number">100+</div>
          <p class="text-muted fw-semibold mb-0">Events</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="modern-card p-4 h-100 shadow">
          <div class="stats-number">2.5K</div>
          <p class="text-muted fw-semibold mb-0">Kg Collected</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="modern-card p-4 h-100 shadow">
          <div class="stats-number">50+</div>
          <p class="text-muted fw-semibold mb-0">Locations</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
  <div class="container py-5">
    <div class="text-center mb-5">
      <h2 class="display-4 fw-bold mb-3" style="color: #0077b6;">What We Do & Why It Matters</h2>
      <p class="lead text-muted">Making a tangible impact on our environment</p>
    </div>
    
    <div class="row g-4">
      <!-- What We Do -->
      <div class="col-lg-6">
        <div class="gradient-card-1 h-100 shadow-lg border-0 rounded-4 p-5 text-white">
          <div class="text-center mb-4">
            <i class="bi bi-calendar-event" style="font-size: 3.5rem;"></i>
            <h3 class="fw-bold mt-3">What We Do</h3>
          </div>
          <ul class="list-unstyled lead">
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Organize beach and coastal clean-up events</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Educate the community on ocean conservation</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Collaborate with local organizations</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Advocate for eco-friendly policies</li>
          </ul>
        </div>
      </div>

      <!-- Why It Matters -->
      <div class="col-lg-6">
        <div class="gradient-card-2 h-100 shadow-lg border-0 rounded-4 p-5 text-white">
          <div class="text-center mb-4">
            <i class="bi bi-heart-fill" style="font-size: 3.5rem;"></i>
            <h3 class="fw-bold mt-3">Why It Matters</h3>
          </div>
          <ul class="list-unstyled lead">
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Protects marine life from pollution</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Preserves natural beauty of beaches</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Supports biodiversity & ecosystems</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill me-3"></i>Raises environmental awareness</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- How You Can Help Section -->
<section class="py-5" style="background: white;">
  <div class="container py-5">
    <div class="gradient-card-3 shadow-lg border-0 rounded-4 p-5 text-white text-center">
      <h2 class="display-4 fw-bold mb-4" id="HowCanHelp">How You Can Help</h2>
      <p class="lead mb-5" style="max-width: 800px; margin: 0 auto;">Everyone can make a difference! Whether big or small, your actions help keep our oceans and beaches clean for future generations.</p>

      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
            <h4 class="fw-bold mt-3 mb-3">Join Clean-Up Events</h4>
            <p class="mb-0">Volunteer your time to help remove litter and restore our coasts.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <i class="bi bi-megaphone-fill" style="font-size: 3rem;"></i>
            <h4 class="fw-bold mt-3 mb-3">Spread Awareness</h4>
            <p class="mb-0">Educate friends, family, and community about protecting marine life.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
            <i class="bi bi-recycle" style="font-size: 3rem;"></i>
            <h4 class="fw-bold mt-3 mb-3">Live Sustainably</h4>
            <p class="mb-0">Reduce plastic use, recycle, and adopt eco-friendly habits daily.</p>
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-modern" style="background: rgba(255,255,255,0.95); color: #0077b6; font-size: 1.3rem;" data-bs-toggle="modal" data-bs-target="#registerModal">
        <i class="bi bi-hand-thumbs-up-fill me-2"></i>Join Us Today!
      </button>
    </div>
  </div>
</section>

<!-- Footer CTA -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);">
  <div class="container">
    <h3 class="text-white fw-bold mb-3">Ready to Make a Difference?</h3>
    <p class="text-white lead mb-4">Join thousands of volunteers protecting our oceans</p>
    <button type="button" class="btn btn-modern" style="background: white; color: #0077b6;" data-bs-toggle="modal" data-bs-target="#registerModal">
      <i class="bi bi-arrow-right-circle-fill me-2"></i>Get Started Now
    </button>
  </div>
</section> 
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-modern border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-3">
        <div class="text-center mb-4">
          <i class="bi bi-wave" style="font-size: 3.5rem; color: white;"></i>
          <h2 class="fw-bold text-white mt-3 mb-2">Welcome Back!</h2>
          <p class="text-white-50">Sign in to continue your journey</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
          @csrf

          <div class="mb-4">
            <label class="form-label text-white fw-semibold mb-2">
              <i class="bi bi-envelope-fill me-2"></i>Email Address
            </label>
            <input type="email" name="email" class="form-control form-control-modern" placeholder="you@example.com" required>
          </div>

          <div class="mb-4">
            <label class="form-label text-white fw-semibold mb-2">
              <i class="bi bi-lock-fill me-2"></i>Password
            </label>
            <div class="position-relative">
              <input type="password" name="password" id="loginPassword" class="form-control form-control-modern pe-5" placeholder="Enter your password" required>
              <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword('loginPassword', 'loginEyeIcon')" style="background: none; border: none;">
                <i id="loginEyeIcon" class="bi bi-eye-slash" style="color: #64748b;"></i>
              </button>
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label text-white" for="remember_me">
              Remember me
            </label>
          </div>

          <button type="submit" class="btn btn-auth w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
          </button>

          <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">

          <div class="text-center">
            <p class="text-white mb-2">Don't have an account?</p>
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
              Create Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content modal-content-modern border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-3">
        <div class="text-center mb-4">
          <i class="bi bi-person-plus-fill" style="font-size: 3.5rem; color: white;"></i>
          <h2 class="fw-bold text-white mt-3 mb-2">Join the Movement</h2>
          <p class="text-white-50">Create your account and start making a difference</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
          @csrf

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-person-fill me-2"></i>Full Name
              </label>
              <input type="text" name="name" class="form-control form-control-modern" placeholder="Enter your name" required value="{{ old('name') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-envelope-fill me-2"></i>Email Address
              </label>
              <input type="email" name="email" class="form-control form-control-modern" placeholder="you@example.com" required value="{{ old('email') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-person-badge-fill me-2"></i>Register As
              </label>
              <select name="registered_as" id="userTypeReg" class="form-select form-control-modern" required>
                <option value="" disabled selected>Select type</option>
                <option value="Volunteer" {{ old('registered_as') == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                <option value="Organizer" {{ old('registered_as') == 'Organizer' ? 'selected' : '' }}>Organization</option>
              </select>
            </div>

            <div class="col-12" id="orgNameGroupReg" style="display:none;">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-building me-2"></i>Organization Name
              </label>
              <input type="text" name="organization_name" id="organizationNameReg" class="form-control form-control-modern" placeholder="Enter organization name" value="{{ old('organization_name') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-lock-fill me-2"></i>Password
              </label>
              <div class="position-relative">
                <input type="password" name="password" id="regPassword" class="form-control form-control-modern pe-5" placeholder="Create password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword('regPassword', 'regEyeIcon')" style="background: none; border: none;">
                  <i id="regEyeIcon" class="bi bi-eye-slash" style="color: #64748b;"></i>
                </button>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label text-white fw-semibold mb-2">
                <i class="bi bi-shield-lock-fill me-2"></i>Confirm Password
              </label>
              <div class="position-relative">
                <input type="password" name="password_confirmation" id="regConfirmPassword" class="form-control form-control-modern pe-5" placeholder="Confirm password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y me-2" onclick="togglePassword('regConfirmPassword', 'regConfirmEyeIcon')" style="background: none; border: none;">
                  <i id="regConfirmEyeIcon" class="bi bi-eye-slash" style="color: #64748b;"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="form-check mt-4 mb-4">
            <input class="form-check-input" type="checkbox" id="terms_consent" required>
            <label class="form-check-label text-white small" for="terms_consent">
              I agree to the <a href="#" class="text-white text-decoration-underline" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Use & Privacy Policy</a>
            </label>
          </div>

          <button type="submit" class="btn btn-auth w-100 mb-3">
            <i class="bi bi-check-circle-fill me-2"></i>Create Account
          </button>

          <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">

          <div class="text-center">
            <p class="text-white mb-2">Already have an account?</p>
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
              Sign In
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Terms & Privacy Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content shadow-lg" style="border-radius: 20px;">
      <div class="modal-header" style="background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); border-radius: 20px 20px 0 0;">
        <h5 class="modal-title fw-bold text-white" id="termsModalLabel">
          <i class="bi bi-file-earmark-text-fill me-2"></i>Terms of Use & Privacy Policy
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4" style="background-color: #f8f9fa;">
        <div class="p-4 bg-white rounded-3">
          <h6 class="fw-bold text-primary mb-3"><i class="bi bi-1-circle-fill me-2"></i>Introduction</h6>
          <p class="text-muted">
            Welcome to <strong>Beach and Ocean Clean-up Hub</strong>. By creating an account or participating in our programs, 
            you agree to abide by the terms stated below. Please read this document carefully.
          </p>

          <h6 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-2-circle-fill me-2"></i>Terms of Use</h6>
          <p class="text-muted">
            You agree to use our platform responsibly and only for its intended purposes. 
            Organizers and volunteers must provide accurate information and follow community guidelines.
          </p>
          <ul class="text-muted">
            <li>Respect event rules and organizers' instructions</li>
            <li>Do not share your account credentials with others</li>
            <li>Use respectful language and behavior at all times</li>
          </ul>

          <h6 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-3-circle-fill me-2"></i>Privacy Policy</h6>
          <p class="text-muted">
            Your privacy is important to us. We collect minimal information needed to provide our services, such as 
            your name, contact details, and participation history.
          </p>
          <p class="text-muted">
            We do not sell or share your data with third parties except as required by law or to facilitate events you join.
          </p>

          <h6 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-4-circle-fill me-2"></i>Data Usage</h6>
          <p class="text-muted">
            We use your data to improve our programs, generate analytics, and communicate with you regarding 
            clean-up activities and related events.
          </p>

          <h6 class="fw-bold text-primary mt-4 mb-3"><i class="bi bi-5-circle-fill me-2"></i>Agreement</h6>
          <p class="text-muted mb-0">
            By continuing to use our services, you agree to these Terms and our Privacy Policy.
            If you do not agree, you should discontinue using our platform.
          </p>
        </div>
      </div>
      <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px;">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bi bi-check-lg me-2"></i>I Understand
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
// Toggle password visibility
function togglePassword(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('bi-eye-slash', 'bi-eye');
  } else {
    input.type = 'password';
    icon.classList.replace('bi-eye', 'bi-eye-slash');
  }
}

// Show/hide organization name field based on user type
document.getElementById('userTypeReg').addEventListener('change', function() {
  const orgNameGroup = document.getElementById('orgNameGroupReg');
  const orgNameInput = document.getElementById('organizationNameReg');
  
  if (this.value === 'Organizer') {
    orgNameGroup.style.display = 'block';
    orgNameInput.required = true;
  } else {
    orgNameGroup.style.display = 'none';
    orgNameInput.required = false;
  }
});

// Smooth scroll animations
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Animate elements on scroll
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, observerOptions);

document.querySelectorAll('.modern-card, .gradient-card-1, .gradient-card-2, .gradient-card-3').forEach(card => {
  card.style.opacity = '0';
  card.style.transform = 'translateY(30px)';
  card.style.transition = 'all 0.6s ease-out';
  observer.observe(card);
});
</script>
@endpush
