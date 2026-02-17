<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container text-center">
        <h5 class="text-warning">Rera Energy</h5>
        <p>Powering a sustainable future with smart solar solutions.</p>

        <p class="mt-3 mb-0">
            © <?php echo date("Y"); ?> Rera Energy. All rights reserved.
        </p>
    </div>
</footer>
<!-- Floating WhatsApp Button -->
<a href="https://wa.me/919449313497?text=Hello%20I%20am%20interested%20in%20solar%20installation"
   class="whatsapp-float"
   target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    function calculateSavings() {
    let bill = document.getElementById("billAmount").value;

    if (bill <= 0) {
        alert("Please enter valid bill amount");
        return;
    }

    // Approximation logic
    let systemSize = (bill / 1000).toFixed(1); // 1kW per 1000₹
    let yearlySavings = (bill * 12 * 0.9).toFixed(0); // 90% savings
    let lifetimeSavings = (yearlySavings * 25).toFixed(0); // 25 years life

    document.getElementById("systemSize").innerHTML =
        "Recommended System Size: <strong>" + systemSize + " kW</strong>";

    document.getElementById("yearlySavings").innerHTML =
        "Estimated Yearly Savings: ₹" + yearlySavings;

    document.getElementById("lifetimeSavings").innerHTML =
        "25 Year Savings: ₹" + lifetimeSavings;

    document.getElementById("resultBox").style.display = "block";
}

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const startCounting = (counter) => {
        const target = +counter.getAttribute('data-target');
        const increment = target / speed;

        let count = 0;

        const updateCount = () => {
            count += increment;

            if (count < target) {
                counter.innerText = Math.floor(count);
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    };

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounting(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        observer.observe(counter);
    });

});
</script>

<script>
var testimonialCarousel = new bootstrap.Carousel(document.querySelector('#testimonialCarousel'), {
    interval: 4000,
    ride: 'carousel',
    pause: false
});
</script>


<!-- Custom JS -->
<script src="assets/js/calculator.js"></script>

<script src="assets/js/main.js"></script>



</body>
</html>
