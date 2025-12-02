<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="Allprojects.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'Header.php'; ?>



<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-lg ">
    <div class="modal-content ">
      <div class="modal-header" style="background-color: #D9D9D9;">
        <h5 class="modal-title" style="font-family: 'aboreto';font-weight:500;">LET YOUR DREAMS BE OUR NEXT PROJECT!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="enquiryForm">
          <div class="row g-3">
            <!-- Left Column -->
            <div class="col-md-6 d-flex flex-column">
              <div class="order-1">
                <input type="text" placeholder="Enter Your Name" maxlength="40" class="form-control" name="name" required>
              </div>
              <div class="order-2 mt-3">
                <input type="email" placeholder="Enter your Email" class="form-control" name="email" required>
              </div>
              <div class="order-3 mt-3">
                <div class="input-group">
                  <span class="input-group-text">+91</span>
                  <input type="tel" placeholder="Enter your Phone Number" class="form-control" name="phone" maxlength="10" pattern="\d{7,10}" required>
                </div>
              </div>
              <div class="order-4 mt-3">
                <input type="text" placeholder="Enter Your Captcha" class="form-control" id="captchaInput" name="captchaInput" required>
              </div>
              <!-- Captcha code (mobile view only) -->
              <div class="order-5 mt-3 d-md-none">
                <span class="input-group-text fw-semibold" id="captchaCodeMobile"></span>
              </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 d-flex flex-column">
              <div class="order-6 mt-2 mt-md-0">
                <textarea class="form-control" placeholder="Enter your Message" name="message" maxlength="500" rows="6" required></textarea>
              </div>
              <!-- Captcha code (DESKTOP only) -->
              <div class="d-none d-md-block mt-2">
                <span class="input-group-text fw-semibold" id="captchaCodeDesktop"></span>
              </div>
            </div>
          </div>

          <!-- Checkbox -->
          <div class="row align-items-center mb-3 mt-3">
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" required>
                <label class="form-check-label" style="font-size: 12px;">
                  I authorise Ramaniyam Real Estates Limited & its representatives to contact me with updates and notifications via Email/SMS/WhatsApp/Call.
                </label>
              </div>
            </div>
          </div>

          <!-- Button -->
          <div class="text-center">
            <button type="submit" class="btn text-light px-4" style="background-color: rgb(110, 24, 24); border-radius: 20px;">ENQUIRE NOW</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<main>
 <!-- Desktop (md and up) -->
<div class="container main-items d-md-flex d-none">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb pt-4">
      <li class="breadcrumb-item fw-medium">
        <a class="text-decoration-none text-dark ps-3 pe-4" href="index">HOME</a>
      </li>
      <li class="breadcrumb-item fw-medium">
        <a class="text-decoration-none text-dark pe-4" href="#">PROJECTS</a>
      </li>
      <li class="breadcrumb-item active fw-medium" aria-current="page">
        <a style="color: #722525;" href="#">ONGOING</a>
      </li>
    </ol>
  </nav>
  <!-- <div class="status-buttons pt-4 me-3">
    <button id="availableBtnDesktop" class="btn btn-success fw-semibold me-2 mb-2" type="button">AVAILABLE</button>
    <button id="soldOutBtnDesktop" class="btn mb-2" type="button" style="border: 1px solid #4C555E; color: #4C555E;">SOLD OUT</button>
  </div> -->
</div>

<!-- Mobile (sm only) -->
<div class="container main-items d-md-none">
  <div class="row align-items-center pt-4">
    <div class="col-12 col-md-8" style="font-size: 14px;">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-2 mb-md-0">
          <li class="breadcrumb-item fw-medium">
            <a class="text-decoration-none text-dark ps-2 pe-1" href="index">HOME</a>
          </li>
          <li class="breadcrumb-item fw-medium">
            <a class="text-decoration-none text-dark pe-1" href="#">PROJECTS</a>
          </li>
          <li class="breadcrumb-item active fw-medium" aria-current="page">
            <a style="color: #722525;" href="#">ONGOING</a>
          </li>
        </ol>
      </nav>
    </div>

    <!-- <div class="col-12 col-md-4 text-md-end">
      <div class="status-buttons">
        <button id="availableBtnMobile" class="btn btn-success fw-semibold me-2 mb-2" type="button">AVAILABLE</button>
        <button id="soldOutBtnMobile" class="btn mb-2" type="button" style="border: 1px solid #4C555E; color: #4C555E;">SOLD OUT</button>
      </div>
    </div> -->
  </div>
</div>


<div class="container mb-5 ">
  

  <!-- AVAILABLE Carousel -->
<div id="availableCarousel" class="carousel-wrapper">
  <!-- Prev Button -->
  <button class="carousel-btn prev" id="availPrev">
    <i class="bi bi-chevron-left"></i>
  </button>

  <!-- Carousel Track -->
  <div class="carousel-track" id="availTrack">

    <!-- Available card-1 -->
    <div class="carousel-card">
      <div class="card position-relative">
        <img src="Ramaniyamimages/flat-2.png" class="card-img-top" alt="Project Image">
        <div class="card-header">
          <p class="Apartment-name">SRI DEVI</p>
        </div>
        <div class="card-body px-3 py-2" style="line-height: 23px">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/ordered-list.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">TOTAL UNITS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">10</div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-2">
                <img src="Ramaniyamicons/building-one.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">FLOORS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">2 Basement + Stilt + 25 Floors</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/arrow-right-circle.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">SALEABLE AREA</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">1250 to 1530 sq.ft</div>
                </div>
              </div>
              <div class="d-flex align-items-start mb-2">
                <img src="Ramaniyamicons/Location2.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">LOCATION</div>
                  <div class="location-text fw-light" style="font-weight: 300;font-size: 13px;">8th Main Road Kasturibai Nagar Adyar</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="available-btn"><a class="text-decoration-none text-light" href="ProjectsDetails">AVAILABLE</a></div>
      </div>
    </div>

    <!-- Available card-2 -->
    <div class="carousel-card">
      <div class="card position-relative">
        <img src="Ramaniyamimages/flat-2.png" class="card-img-top" alt="Project Image">
        <div class="card-header">
          <p class="Apartment-name">SRI DEVI</p>
        </div>
        <div class="card-body px-3 py-2" style="line-height: 23px">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/ordered-list.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">TOTAL UNITS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">10</div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-2">
                <img src="Ramaniyamicons/building-one.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">FLOORS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">2 Basement + Stilt + 25 Floors</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/arrow-right-circle.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">SALEABLE AREA</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">1250 to 1530 sq.ft</div>
                </div>
              </div>
              <div class="d-flex align-items-start mb-2">
                <img src="Ramaniyamicons/Location2.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">LOCATION</div>
                  <div class="location-text fw-light" style="font-weight: 300;font-size: 13px;">8th Main Road Kasturibai Nagar Adyar</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="available-btn">AVAILABLE</div>
      </div>
    </div>

    <!-- Available card-3 -->
    <div class="carousel-card">
      <div class="card position-relative">
        <img src="Ramaniyamimages/flat-2.png" class="card-img-top" alt="Project Image">
        <div class="card-header">
          <p class="Apartment-name">SRI DEVI</p>
        </div>
        <div class="card-body px-3 py-2" style="line-height: 23px">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/ordered-list.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">TOTAL UNITS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">10</div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-2">
                <img src="Ramaniyamicons/building-one.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">FLOORS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">2 Basement + Stilt + 25 Floors</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/arrow-right-circle.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">SALEABLE AREA</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">1250 to 1530 sq.ft</div>
                </div>
              </div>
              <div class="d-flex align-items-start mb-2">
                <img src="Ramaniyamicons/Location2.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">LOCATION</div>
                  <div class="location-text fw-light" style="font-weight: 300;font-size: 13px;">8th Main Road Kasturibai Nagar Adyar</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="available-btn">AVAILABLE</div>
      </div>
    </div>

    <!-- Available card-4 -->
    <div class="carousel-card">
      <div class="card position-relative">
        <img src="Ramaniyamimages/flat-2.png" class="card-img-top" alt="Project Image">
        <div class="card-header">
          <p class="Apartment-name">SRI DEVI</p>
        </div>
        <div class="card-body px-3 py-2" style="line-height: 23px">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/ordered-list.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">TOTAL UNITS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">10</div>
                </div>
              </div>
              <div class="d-flex align-items-center mb-2">
                <img src="Ramaniyamicons/building-one.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">FLOORS</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">2 Basement + Stilt + 25 Floors</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center mb-4">
                <img src="Ramaniyamicons/arrow-right-circle.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">SALEABLE AREA</div>
                  <div class="fw-light" style="font-weight: 300;font-size: 13px;">1250 to 1530 sq.ft</div>
                </div>
              </div>
              <div class="d-flex align-items-start mb-2">
                <img src="Ramaniyamicons/Location2.png">
                <div class="ms-2">
                  <div class="fw-semibold" style="font-size: 12px;">LOCATION</div>
                  <div class="location-text fw-light" style="font-weight: 300;font-size: 13px;">8th Main Road Kasturibai Nagar Adyar</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="available-btn">AVAILABLE</div>
      </div>
    </div>

  </div>

  <!-- Next Button -->
  <button class="carousel-btn next" id="availNext">
    <i class="bi bi-chevron-right"></i>
  </button>
</div>




</div>
</main>

<script>
// Get all buttons (desktop + mobile)
const availableBtns = document.querySelectorAll('#availableBtnDesktop, #availableBtnMobile');
const soldOutBtns   = document.querySelectorAll('#soldOutBtnDesktop, #soldOutBtnMobile');

// Carousels
const availableCarousel = document.getElementById('availableCarousel');
const soldOutCarousel   = document.getElementById('soldOutCarousel');

let soldOutInitialized = false;

// Show Available
function showAvailable() {
  availableCarousel.style.display = 'block';
  soldOutCarousel.style.display = 'none';

  availableBtns.forEach(btn => btn.classList.add('btn-success'));
  soldOutBtns.forEach(btn => {
    btn.classList.remove('btn-soldout-custom');
    btn.classList.add('btn-soldout-outline');
  });
}

// Show Sold Out
function showSoldOut() {
  soldOutCarousel.style.display = 'block';
  availableCarousel.style.display = 'none';

  soldOutBtns.forEach(btn => {
    btn.classList.remove('btn-soldout-outline');
    btn.classList.add('btn-soldout-custom');
  });
  availableBtns.forEach(btn => btn.classList.remove('btn-success'));

  // Initialize Sold Out carousel only once
  if (!soldOutInitialized) {
    initCarousel('soldPrev', 'soldNext', 'soldTrack');
    soldOutInitialized = true;
  }
}

// Attach click events to ALL buttons
availableBtns.forEach(btn => btn.addEventListener('click', showAvailable));
soldOutBtns.forEach(btn => btn.addEventListener('click', showSoldOut));

// Carousel logic
function initCarousel(prevBtnId, nextBtnId, trackId) {
  const track = document.getElementById(trackId);
  const prevBtn = document.getElementById(prevBtnId);
  const nextBtn = document.getElementById(nextBtnId);
  const cards = track.querySelectorAll('.carousel-card');

  let cardWidth = cards.length > 0 ? cards[0].offsetWidth + 15 : 0;
  let index = 0;

  function getVisibleCards() {
    if (window.innerWidth <= 576) return 1;
    if (window.innerWidth <= 991) return 2;
    return 3;
  }

  function updateButtons() {
    prevBtn.disabled = index === 0;
    nextBtn.disabled = index >= cards.length - getVisibleCards();
  }

  nextBtn.addEventListener('click', () => {
    if (index < cards.length - getVisibleCards()) {
      index++;
      track.style.transform = `translateX(${-cardWidth * index}px)`;
      updateButtons();
    }
  });

  prevBtn.addEventListener('click', () => {
    if (index > 0) {
      index--;
      track.style.transform = `translateX(${-cardWidth * index}px)`;
      updateButtons();
    }
  });

  window.addEventListener('resize', () => {
    cardWidth = cards.length > 0 ? cards[0].offsetWidth + 15 : 0;
    updateButtons();
  });

  updateButtons();
}

// Initialize Available carousel on load
initCarousel('availPrev', 'availNext', 'availTrack');

// Default view: show Available
showAvailable();
</script>



     
<?php include 'Footer.php' ; ?>





    
<!-- script section -->

<!-- enquirenow-modal script      -->
<script>
function generateCaptcha() {
  const length = Math.random() < 0.5 ? 6 : 8;
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let code = '';
  for (let i = 0; i < length; i++) {
    code += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  // assign to both spans
  document.getElementById('captchaCodeMobile').innerText = code;
  document.getElementById('captchaCodeDesktop').innerText = code;
}

document.getElementById('enquiryModal').addEventListener('show.bs.modal', generateCaptcha);
document.getElementById('captchaCodeMobile').addEventListener('click', generateCaptcha);
document.getElementById('captchaCodeDesktop').addEventListener('click', generateCaptcha);

document.getElementById('enquiryForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const name = this.name.value.trim();
  if (name.length === 0 || name.length > 40) { alert("Name must be between 1 and 40 characters."); return; }
  const email = this.email.value.trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) { alert("Please enter a valid email address."); return; }
  const phone = this.phone.value.trim();
  const phonePattern = /^\d{7,10}$/;
  if (!phonePattern.test(phone)) { alert("Phone number must be 7 to 10 digits."); return; }
  const entered = this.captchaInput.value.trim();
  const actual = (document.getElementById('captchaCodeDesktop').innerText.trim() || document.getElementById('captchaCodeMobile').innerText.trim());
  if (entered !== actual) { alert("Captcha does not match."); generateCaptcha(); return; }
  const message = this.message.value.trim();
  if (message.length === 0 || message.length > 500) { alert("Message must be between 1 and 500 characters."); return; }

  alert('Form submitted successfully!');
  bootstrap.Modal.getInstance(document.getElementById('enquiryModal')).hide();
  this.reset();
  generateCaptcha();
});
</script>




<!-- Header dropdown script -->
<script>
document.querySelectorAll('.nav-item.dropdown').forEach(function(dropdown) {
  let timer;

  dropdown.addEventListener('mouseenter', function() {
    clearTimeout(timer);
    this.classList.add('show');
    const menu = this.querySelector('.dropdown-menu');
    menu.classList.add('show');
    menu.style.opacity = '1';
    menu.style.visibility = 'visible';
  });

  dropdown.addEventListener('mouseleave', function() {
    const menu = this.querySelector('.dropdown-menu');
    timer = setTimeout(() => {
      this.classList.remove('show');
      menu.classList.remove('show');
      menu.style.opacity = '';
      menu.style.visibility = '';
    }, 300); // Short delay for user to move mouse
  });

  // Keep menu open when hovering over dropdown-menu
  const menu = dropdown.querySelector('.dropdown-menu');
  menu.addEventListener('mouseenter', function() {
    clearTimeout(timer);
    dropdown.classList.add('show');
    menu.classList.add('show');
    menu.style.opacity = '1';
    menu.style.visibility = 'visible';
  });
  menu.addEventListener('mouseleave', function() {
    timer = setTimeout(() => {
      dropdown.classList.remove('show');
      menu.classList.remove('show');
      menu.style.opacity = '';
      menu.style.visibility = '';
    }, 300);
  });
});
</script>

<script>
document.querySelectorAll('.dropdown-mega').forEach(function (dropdown) {
  if (window.innerWidth > 992) { // Desktop only
    dropdown.addEventListener('mouseenter', function () {
      let menu = this.querySelector('.dropdown-menu');
      if (menu) menu.classList.add('show');
    });
    dropdown.addEventListener('mouseleave', function () {
      let menu = this.querySelector('.dropdown-menu');
      if (menu) menu.classList.remove('show');
    });
  }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    
</body>
</html>