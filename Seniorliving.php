<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seniorliving</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="Seniorliving.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body >
  
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

    <main >
      <div class="container">
        <div class="row" > 
          <div class="left-section col-12 col-lg-8" >
            <div class="breadcrumb pt-5">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index" class="text-decoration-none text-dark"
                    >Home</a
                  >
                </li>
                <li class="breadcrumb-item active text-danger ps-3">
                  SENIOR LIVING
                </li>
              </ol>
            </div>
            <div class="content">
              <div class="Heading-content text-center justify content-center mt-4 p-2">
                <h1>RAMANIYAM SAMARPPAN</h1>
                <h4 class="fw-medium fw-italic">
                  <em>Senior living Redefined in Chennai</em>
                </h4>
              </div>
              <div class="Body-wrapper mt-4 p-5">
                <div class="Body-content ">
                  <p>
                    Samarppan is Ramaniyam’s exclusive senior living
                    community,<br />
                    ideally located within Chennai city limits at 200 Ft
                    Road,<br />
                    Pallavaram Radial Road, opposite Kamakshi Memorial Hospital.
                  </p>
                  <div>
                    <p>With multiple locations and the main campus just:</p>
                    <ul>
                      <li>
                        3 km from Velachery MRTS & 4 km from Velachery Bus
                        Terminus
                      </li>
                      <li>30 minutes from Chennai International Airport</li>
                      <li>
                        165 thoughtfully designed 1 BHK apartments. Residents
                        enjoy access to the full range of Ocean Dew’s
                        amenities—including a theatre, recreation room, swimming
                        pool, and multipurpose hall.
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="Flat col-12 col-lg-4 ps-1 pb-0">
            <img
              src="Ramaniyamimages/Flat Bulding.png"
              width="100%"
              height="100%"
              alt=""
              srcset=""
            />
          </div>
        </div>
      </div>
    </main>


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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
