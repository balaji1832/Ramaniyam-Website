<?php
// Base folder for images
$imageBasePath = "Ramaniyamimages/";

// List of image files (you can change these names later or load from DB)
$imageFiles = [
  "img-1.png",
  "img-2.png",
  "img-3.png",
  "img-4.png",
  "img=5.png",
  "img-6.png",
  "img-7.png",
  "img-8.png",
];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramaniyam</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
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



<main class="container mt-lg-3 mt-3 mt-md-2 d-flex flex-column justify-content-center align-items-center" style="min-height: 65vh;">

  <!-- Initial Content -->
  <div id="initial-content" class="content-section visible d-none d-lg-block">
    <div class="summary d-flex justify-content-center">
      <p class="text-wrap text-center" style="letter-spacing: 1px;">
        "A  MAN  TRAVELS  THE  WORLD  OVER  IN  SEARCH  OF  WHAT  HE  NEEDS
        <span class="text-danger">AND RETURNS HOME TO FIND IT"</span>
      </p>
    </div>
    <center>
  <div class="row g-3" style="max-width: 1200px;">
    <?php for ($i = 0; $i < 4; $i++): ?>
      <div class="col-6 col-md-6 col-lg-3 mt-2">
        <div class="initial-card">
          <img
            src="<?php echo $imageBasePath . $imageFiles[$i]; ?>"
            class="initial-card-img"
            alt="Ramaniyam Image <?php echo $i + 1; ?>"
          >
        </div>
      </div>
    <?php endfor; ?>
  </div>
</center>



    

    <section class="Main-text">
  <div class="row text-center" style="letter-spacing: 1px;">
    <!-- 1 -->
    <div class="col-6 col-md-6 col-lg-3 mb-4 mb-lg-0 text-light pt-3">
      <h2 class="info-number" data-target="39" data-suffix="+">0</h2>
      <p class="info-label fw-semibold">Years Of Experience</p>
    </div>
    <!-- 2 -->
    <div class="col-6 col-md-6 col-lg-3 mb-4 mb-lg-0 text-light pt-3">
      <h2 class="info-number" data-target="12" data-suffix=" Million+">0</h2>
      <p class="info-label fw-semibold">Sq.Ft. Developed</p>
    </div>
    <!-- 3 -->
    <div class="col-6 col-md-6 col-lg-3 mb-4 mb-lg-0 text-light pt-3">
      <h2 class="info-number" data-target="370" data-suffix="+">0</h2>
      <p class="info-label fw-semibold">Projects</p>
    </div>
    <!-- 4 -->
    <div class="col-6 col-md-6 col-lg-3 text-light pt-3">
      <h2 class="info-number" data-target="6500" data-suffix="+">0</h2>
      <p class="info-label fw-semibold">Dreams Accommodated</p>
    </div>
  </div>
</section>


  </div>

  <!-- After Content -->
   
<div id="after-content" class="content-section hidden d-block">
  <center>
    <div class="container pb-4">

      <!-- ✅ Desktop Collage -->
      <div class="row img-row justify-content-center d-none d-lg-flex"
     id="image-collage"
     style="max-width: 1300px; position: relative; overflow: hidden;">

  <?php for ($col = 0; $col < 4; $col++): ?>
    <div class="col-6 col-lg-3 collage-slot">
      <!-- Top image for this column -->
      <img
        src="<?php echo $imageBasePath . $imageFiles[$col]; ?>"
        class="img-fluid collage-img"
        alt="Collage Image Top <?php echo $col + 1; ?>"
      >
      <!-- Bottom image for this column (offset by +4) -->
      <img
        src="<?php echo $imageBasePath . $imageFiles[$col + 4]; ?>"
        class="img-fluid collage-img"
        alt="Collage Image Bottom <?php echo $col + 5; ?>"
      >
    </div>
  <?php endfor; ?>

</div>


      <!-- ✅ Mobile Carousel -->
      <div id="imageCarousel"
     class="carousel slide vertical-carousel d-block d-lg-none"
     data-bs-ride="carousel"
     data-bs-interval="2000">

  <div class="carousel-inner">
    <?php foreach ($imageFiles as $index => $file): ?>
      <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
        <img
          src="<?php echo $imageBasePath . $file; ?>"
          class="d-block img-fluid mx-auto carousel-sm-img"
          alt="Carousel Image <?php echo $index + 1; ?>"
        >
      </div>
    <?php endforeach; ?>
  </div>
</div>



      <!-- ✅ Website Title -->
      <div class="Website-name d-md-block d-lg-block website-title mt-4" style="line-height: 6px;">
        <h1 class="text-center mt-lg-3">RAMANIYAM</h1>
        <p class="text-center fw-lighter title-border" style="border-top: 1px solid white; display: inline; border-bottom: 1px solid white;">
          SINCE 1986
        </p>
      </div>

    </div>
  </center>
</div>
 
</main>

<!-- ✅ Hidden by default (opacity 0) -->

<!-- tablet -function -->
<!-- <div id="ramaniyam-banner" 
     class="container-fluid d-md-block d-none d-lg-none"
     style="background-color: #722525; line-height: 20px; opacity: 0;">
  <h1 class="text-center text-light mt-lg-3">RAMANIYAM</h1>
  <center>
    <p class="text-center fw-lighter title-border text-light fw-lighter pb-2"
       style="border-top: 1px solid white; display: inline; border-bottom: 1px solid white;">
      SINCE 1986
    </p>
  </center>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.getElementById("ramaniyam-banner").classList.add("show");
  }, 3000); // start fade-in after 5 seconds
});
</script> -->
<!-- tablet-function-end -->


 <!-- <footer class="mt-4 " >
    <div class="container">
      <nav class="navbar ">
            <div class="container text-light ">
                <div class="navbar-item Footer-elements ">Copyrights @ 2025 All Rights<br> Reserved Ramaniyam</div>
                <div class="navbar-item Footer-elements ms-lg-5 "><img src="Ramaniyamicons/Location.png"style="cursor: pointer;" width="40" alt="location.png" data-bs-toggle="modal" data-bs-target="#locationmodal">Contact Us</div>
                <div class="navbar-item Footer-elements">Site Map</div>
                <div class="navbar-item Footer-elements">Blogs</div>
                <div class="navbar-item Footer-elements">
                    <img class="facebook-logo ms-lg-2" width="40" src="Ramaniyamicons/facebook.png" alt="facebook.img">
                    <img class="instagram-logo ms-lg-2 ms-3" width="40" src="Ramaniyamicons/instagram.png" alt="instagram.img"></div>
                <div class="navbar-item Footer-elements">Designed and Developed by <br>AyatiWorks</div>
            </div>
        </nav>
    </div>
        
</footer> -->
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

<!-- main content script -->
<script>
let scrollTimer = null;
let afterShown = false;

// Function to switch content
function showAfterContent() {
  if (!afterShown) {
    document.getElementById("initial-content").classList.remove("visible");
    document.getElementById("initial-content").classList.add("hidden");

    document.getElementById("after-content").classList.remove("hidden");
    document.getElementById("after-content").classList.add("visible");

    afterShown = true;

    // Clear any pending scroll timer
    if (scrollTimer) {
      clearTimeout(scrollTimer);
      scrollTimer = null;
    }
  }
}

// Page-load timer (11 seconds)
setTimeout(showAfterContent, 11000);

// Scroll-triggered timer (10 seconds after scroll)
window.addEventListener("scroll", function() {
  const triggerHeight = 100;

  if (!afterShown && window.scrollY > triggerHeight) {
    if (!scrollTimer) {
      scrollTimer = setTimeout(showAfterContent, 10000);
    }
  }
});
</script>

<!-- <script>
  const collage = document.getElementById("image-collage");
  const cols = Array.from(collage.children);

  function fadeRotate() {
    // Fade out all images
    cols.forEach(col => col.firstElementChild.classList.add('fade-out'));

    setTimeout(() => {
      // Rotate the array (1234 -> 2341)
      cols.push(cols.shift());
      cols.forEach(col => collage.appendChild(col)); // reorder DOM

      // Fade in all images
      cols.forEach(col => col.firstElementChild.classList.remove('fade-out'));
    }, 1000); // matches CSS transition duration
  }

  setInterval(fadeRotate, 1000); // change every 3 seconds
</script> -->

<!-- after content script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const slots = document.querySelectorAll('#image-collage .collage-slot');

  slots.forEach(slot => {
    const imgs = slot.querySelectorAll('.collage-img');
    let currentIndex = 0;

    function showNextImage() {
      imgs[currentIndex].classList.remove('visible');
      currentIndex = (currentIndex + 1) % imgs.length;
      imgs[currentIndex].classList.add('visible');
    }

    setInterval(showNextImage, 3000);
  });
});
</script>

<!-- Animation script -->

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Detect device size
  const isSmallOrMedium = window.innerWidth < 992;

  // Use shorter delays for small/medium screens
  const summaryDelay = isSmallOrMedium ? 300 : 800;
  const imageDelay = isSmallOrMedium ? 300 : 800;
  const statDelay = isSmallOrMedium ? 150 : 400;
  const headerFooterDelay = isSmallOrMedium ? 300 : 800;

  const summary = document.querySelector(".summary p");
  const images = document.querySelectorAll("#initial-content img");
  const stats = document.querySelectorAll(".info-number, .info-label");
  const header = document.querySelector("header");
  const footer = document.querySelector("footer");

  const allElements = [summary, ...images, ...stats, header, footer];
  allElements.forEach(el => el.classList.add("hidden-seq"));

  let delay = 0;

  // 1. SUMMARY (random)
  setTimeout(() => {
    summary.classList.remove("hidden-seq");
    summary.classList.add("anim-" + pickRandom(1, 5));
  }, delay += summaryDelay);

  // 2. IMAGES (slide from right only)
  images.forEach(img => {
    setTimeout(() => {
      img.classList.remove("hidden-seq");
      img.classList.add("img-slide-right");
    }, delay += imageDelay);
  });

  // 3. STATS (random)
  stats.forEach(stat => {
    setTimeout(() => {
      stat.classList.remove("hidden-seq");
      stat.classList.add("anim-" + pickRandom(1, 5));
      if (stat.classList.contains("info-number")) {
        animateCounter(stat);
      }
    }, delay += statDelay);
  });

  // 4. HEADER + FOOTER → use smoothFadeUp
  setTimeout(() => {
    header.classList.remove("hidden-seq");
    footer.classList.remove("hidden-seq");
    header.classList.add("show-seq");
    footer.classList.add("show-seq");
  }, delay += headerFooterDelay);

  // remove overlay
  setTimeout(() => {
    const overlay = document.getElementById("introOverlay");
    if (overlay) overlay.style.display = "none";
  }, delay + 600);

  function pickRandom(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }

  function animateCounter(element) {
    const target = parseFloat(element.getAttribute("data-target") || 0);
    const suffix = element.getAttribute("data-suffix") || "";
    let count = 0;
    const duration = isSmallOrMedium ? 400 : 1000; // Faster counter
    const increment = target / (duration / 16);
    const intv = setInterval(() => {
      count += increment;
      if (count >= target) {
        element.textContent = target + suffix;
        clearInterval(intv);
      } else {
        element.textContent = Math.floor(count) + suffix;
      }
    }, 16);
  }
});
</script>


<!-- background color  -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Detect device size
  const isSmallOrMedium = window.innerWidth < 992;
  // Set background image faster on small/medium screens
  const bgDelay = isSmallOrMedium ? 2500 : 4500; // 1.5s for small/medium, 4.5s for large

  setTimeout(() => {
    document.body.style.background = "url('Ramaniyamimages/background.png') no-repeat center center";
    document.body.style.backgroundSize = "cover";
  }, bgDelay);
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



 <script>
    // Only run animation and initial/after content switch on large screens
    if (window.innerWidth >= 992) {
        let scrollTimer = null;
        let afterShown = false;

        function showAfterContent() {
            if (!afterShown) {
                document.getElementById("initial-content").classList.remove("visible");
                document.getElementById("initial-content").classList.add("hidden");

                document.getElementById("after-content").classList.remove("hidden");
                document.getElementById("after-content").classList.add("visible");

                afterShown = true;
                if (scrollTimer) {
                    clearTimeout(scrollTimer);
                    scrollTimer = null;
                }
            }
        }

        setTimeout(showAfterContent, 14000);

        window.addEventListener("scroll", function() {
            const triggerHeight = 100;
            if (!afterShown && window.scrollY > triggerHeight) {
                if (!scrollTimer) {
                    scrollTimer = setTimeout(showAfterContent, 10000);
                }
            }
        });
    } else {
        // On small/medium screens, show after-content only
        document.getElementById("initial-content").classList.add("d-none");
        document.getElementById("after-content").classList.remove("hidden");
        document.getElementById("after-content").classList.add("visible");
    }
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    
</body>

</html>





