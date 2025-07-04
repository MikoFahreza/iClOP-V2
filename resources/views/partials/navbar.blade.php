<style>
  .btn-google {
  text-decoration: none;
  border: 1px solid #1466C2;
  color: #1466C2;
  display: inline-block;
  padding: 10px 100px;
  border-radius: 5px;
}

.btn-google:hover {
  background-color: #0056b3; /* Warna latar saat di-hover */
  color: white; /* Warna teks saat di-hover */
}

/* Mobile responsive styles */
@media (max-width: 991px) {
  .mobile-auth-buttons {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
  }
  
  .mobile-auth-buttons .btn {
    width: 100%;
    margin-bottom: 10px;
  }
}
</style>

<nav class="navbar navbar-expand-lg" style="background-color: #fff;">
<div class="container-fluid">
  <!-- Logo -->
  <img src="./images/logo.png" alt="logo" width="104" height="65">
  
  <!-- Mobile toggle button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Navigation Menu -->
    <div class="mx-auto">
      <ul class="navbar-nav mb-2 mb-lg-0 justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Tutorials</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
        </li>
      </ul>
    </div>

    <!-- Auth buttons - Desktop -->
    <div class="d-none d-lg-flex">
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#loginModal" style="border-radius: 20px; margin-right: 10px; width: 100px; height: 35px;">Sign In</button>
      <button class="btn btn-primary custom-button-sign-up" onclick="window.location.href='{{ route('signup') }}'">Sign Up</button>
    </div>
    
    <!-- Auth buttons - Mobile -->
    <div class="d-lg-none mobile-auth-buttons">
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#loginModal" style="border-radius: 20px;">Sign In</button>
      <button class="btn btn-primary custom-button-sign-up" onclick="window.location.href='{{ route('signup') }}'">Sign Up</button>
    </div>
  </div>
</div>
</nav>

<!-- MODAL -->
<div class="modal" id="loginModal">
<div class="modal-dialog modal-xl">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header border-0">
      <button type="button" class="btn-close" aria-label="Close" data-dismiss="modal"></button>
    </div>

    <!-- Modal Body -->
    <div class="modal-body" style="margin-bottom:100px;">
      <div class="row">
        <div class="col-lg-6 content-left d-none d-lg-block">
          <img src="./images/sign-in.png" alt="Illustration" style="width: 450px; height: 450px; margin-right: 50px; margin-left: 50px;">
        </div>
        <!-- IMAGE -->
        <div class="col-lg-6 col-12 content-right" style="padding-right: 15px;">
          <!-- TITLE -->
          <p class="sign-in-modal">Sign In</p>
          <p class="welcome-modal">Welcome back! Please enter<br>your details.</p>
          <!-- FORM -->
          <form action="{{route('login')}}" method="post">
            @csrf
            <div class="form-modal">
              <label for="email" class="form-label" style="text-align: left; font-weight: 500">Email</label>
              <input class="form-control" list="datalistOptions" id="email" placeholder="Email" name="email" style=" margin-bottom: 20px;">
            </div>
            
            <div class="form-modal">
              <label for="password" class="form-label" style="text-align: left; font-weight: 500">Password</label>
              <input type="password" class="form-control" list="datalistOptions" id="password" name="password" placeholder="Password" style=" margin-bottom: 20px;">
            </div>
            <!-- BUTTON SIGN IN -->
            <button type="submit" class="btn btn-primary custom-button-sign-in-modal">Sign In</button>
          </form>
          <a href="{{ route('google.redirect') }}" class="btn-google mt-3">
            <img src="./images/google.png" style="width: 15px; height: 15px;" alt="Google Icon"> Sign In with Google
          </a>
          <p class="dont-have-account-modal">Don't have an account? <span style="color: #1466C2;" onclick="window.location.href='signup'"><a href="javascript:void(0)" style="text-decoration: none;">Sign Up</a></span></p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>