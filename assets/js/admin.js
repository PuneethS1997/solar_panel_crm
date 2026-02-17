document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");

    toggleBtn.addEventListener("click", function () {

        if (window.innerWidth < 768) {
            sidebar.classList.toggle("active"); // mobile
        } else {
            sidebar.classList.toggle("collapsed"); // desktop
        }

    });

});
