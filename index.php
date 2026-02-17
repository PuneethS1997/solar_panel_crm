<?php include 'includes/header.php'; ?>

<!-- HERO SECTION -->
<!-- HERO SECTION -->
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6 text-white">
                <h1 class="hero-title">
                    Power Your Future <br>
                    With Clean <span class="text-warning">Solar Energy</span>
                </h1>
                <p class="hero-subtitle mt-3">
                    Save up to 90% on electricity bills with premium solar panel installation.
                </p>

                <div class="mt-4">
                    <a href="#calculator" class="btn btn-warning btn-lg me-3">Calculate Savings</a>
                    <a href="contact.php" class="btn btn-outline-light btn-lg">Get Free Quote</a>
                </div>
            </div>

            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <!-- <img src="assets/videos/hero.mp.4" 
                     class="img-fluid hero-img" 
                     alt="Solar Panel"> -->

                     <video src="assets/videos/hero.mp4" class="img-fluid hero-img" 
                     alt="Solar Panel"></video>
            </div>

        </div>
    </div>
</section>


<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">Our Solar Solutions</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box p-4 shadow-sm">
                    <i class="fas fa-solar-panel fa-3x text-warning mb-3"></i>
                    <h5>Residential Solar</h5>
                    <p>Efficient rooftop solar systems for homes.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-box p-4 shadow-sm">
                    <i class="fas fa-industry fa-3x text-warning mb-3"></i>
                    <h5>Commercial Solar</h5>
                    <p>Reduce business electricity costs significantly.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-box p-4 shadow-sm">
                    <i class="fas fa-battery-full fa-3x text-warning mb-3"></i>
                    <h5>Battery Storage</h5>
                    <p>Store solar power for uninterrupted supply.</p>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- WHY CHOOSE US -->
<section class="py-5 bg-dark text-white">
    <div class="container text-center">
        <h2 class="mb-5">Why Choose Rera Energy?</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="feature-card p-4">
                    <h4>⚡ High Efficiency Panels</h4>
                    <p>Latest generation solar modules with maximum output.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4">
                    <h4>💰 Government Subsidy</h4>
                    <p>We help you claim all available solar subsidies.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card p-4">
                    <h4>🛠 25 Year Warranty</h4>
                    <p>Long-term protection and maintenance support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-6">
                <img src="assets/images/solar-install.jpg" 
                     class="img-fluid rounded-4 shadow" 
                     alt="">
            </div>

            <div class="col-lg-6 mt-4 mt-lg-0">
                <!-- <h2 class="fw-bold">Why Choose RERA Energy?</h2> -->
                <ul class="list-unstyled mt-4">
                    <li class="mb-3">✔ 25 Year Performance Warranty</li>
                    <li class="mb-3">✔ Government Subsidy Assistance</li>
                    <li class="mb-3">✔ Premium Tier-1 Solar Panels</li>
                    <li class="mb-3">✔ Expert Installation Team</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- TRUST SECTION -->
<!-- STATS SECTION -->
<section class="stats-section py-5 text-white">
    <div class="container text-center">
        <div class="row g-4">

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="counter" data-target="1200">0</h2>
                    <p>Installations Completed</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="counter" data-target="25">0</h2>
                    <p>Years Warranty</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="counter" data-target="98">0</h2>
                    <p>% Customer Satisfaction</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stat-box">
                    <h2 class="counter" data-target="5000">0</h2>
                    <p>KW Installed</p>
                </div>
            </div>

        </div>
    </div>
</section>




<section id="calculator" class="solar-calculator py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3">Calculate Your Solar Savings</h2>
                <p class="text-muted mb-4">Enter your monthly electricity bill and see how much you can save</p>

                <div class="card shadow-lg p-4 border-0 rounded-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="number" id="billAmount" class="form-control form-control-lg"
                                   placeholder="Enter Monthly Bill (₹)">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-warning btn-lg w-100"
                                    onclick="calculateSavings()">Calculate</button>
                        </div>
                    </div>

                    <div id="resultBox" class="mt-4" style="display:none;">
                        <h5 class="fw-bold">Estimated Results</h5>
                        <p id="systemSize"></p>
                        <p id="yearlySavings"></p>
                        <p id="lifetimeSavings" class="fw-bold text-success fs-5"></p>
                        <p id="redirecttofullCalc"><a href="calculator" target="_blank" class="btn btn-primary btn-lg w-100" rel="noopener noreferrer">For more Calculation</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- TESTIMONIALS SECTION -->
<section class="testimonials-section py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">What Our Clients Say</h2>

        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- Testimonial 1 -->
                <div class="carousel-item active">
                    <div class="testimonial-card mx-auto">
                        <p class="testimonial-text">
                            "RERA Energy reduced our electricity bill by 85%. The installation was smooth and professional!"
                        </p>
                        <h5 class="mt-3 mb-1">Rahul Sharma</h5>
                        <div class="stars text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="carousel-item">
                    <div class="testimonial-card mx-auto">
                        <p class="testimonial-text">
                            "Excellent service and premium quality solar panels. Highly recommended!"
                        </p>
                        <h5 class="mt-3 mb-1">Priya Verma</h5>
                        <div class="stars text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="carousel-item">
                    <div class="testimonial-card mx-auto">
                        <p class="testimonial-text">
                            "Very supportive team. They helped us with government subsidy and documentation."
                        </p>
                        <h5 class="mt-3 mb-1">Amit Patel</h5>
                        <div class="stars text-warning">
                            ★★★★★
                        </div>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
            </button>

        </div>
    </div>
</section>



<!-- CTA SECTION -->
<section class="cta-section text-white text-center py-5">
    <div class="container">
        <h2 class="fw-bold mb-3">Ready To Go Solar?</h2>
        <p class="mb-4">Start saving today with zero upfront consultation cost.</p>
        <a href="contact" class="btn btn-light btn-lg px-5">Book Free Site Visit</a>
    </div>
</section>


<?php include 'includes/footer.php'; ?>
