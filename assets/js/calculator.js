console.log("JS Loaded");


document.addEventListener("DOMContentLoaded", function () {

    const calculateBtn = document.getElementById("calculateBtn");
    if (!calculateBtn) return;

    calculateBtn.addEventListener("click", async function () {

        console.log("Button Clicked");


        const monthlyBillInput = document.getElementById("bill");
        if (!monthlyBillInput) return;

        const monthly_bill = parseFloat(monthlyBillInput.value);

        if (!monthly_bill || monthly_bill <= 0) {
            alert("Enter valid bill amount");
            return;
        }

        // 🔥 Ensure solarSettings exists
        if (typeof solarSettings === "undefined") {
            console.error("solarSettings not loaded");
            return;
        }

        // 🔥 Settings from DB
        const {
            unit_price,
            sunlight_factor,
            cost_per_kw,
            subsidy_percent,
            co2_per_kw,
            co2_per_tree,
            export_rate
        } = solarSettings;

        // 🔥 Core Calculations
        const units = monthly_bill / unit_price;
        const systemKW = units / sunlight_factor;

        const installation_cost = systemKW * cost_per_kw;
        const subsidy = installation_cost * subsidy_percent / 100;
        const final_cost = installation_cost - subsidy;

        const yearly_savings = monthly_bill * 12;
        const payback_years = (final_cost / yearly_savings).toFixed(1);
        const total_25_year_savings = (yearly_savings * 25 - final_cost).toFixed(0);

        // 🌍 Environmental
        const total_co2_saved = (systemKW * co2_per_kw * 25).toFixed(0);
        const trees_equivalent = Math.floor(total_co2_saved / co2_per_tree);

        // 📊 Projection Data
        const projectionData = calculateProjection(
            systemKW,
            unit_price,
            export_rate || 3,
            units
        );

        // Show Results
        document.getElementById("resultSection")?.classList.remove("d-none");

        setText("payback", payback_years + " Years");
        setText("totalSavings", "₹" + Number(total_25_year_savings).toLocaleString());
        setText("systemSize", systemKW.toFixed(2) + " kW");

        animateValue("trees", 0, trees_equivalent, 2000);
        animateValue("co2", 0, total_co2_saved, 2000);

        generateROIChart(yearly_savings, final_cost);
        generateProjectionChart(projectionData);

        // AFTER systemKW calculation

            const totalCO2 = systemKW * solarSettings.co2_per_kw * 25;
            const trees = totalCO2 / solarSettings.co2_per_tree;

            console.log("SystemKW:", systemKW);
            console.log("TotalCO2:", totalCO2);
            console.log("Trees:", trees);

            animateValue("treeCount", 0, Math.floor(trees), 2000);
            animateValue("co2Count", 0, Math.floor(totalCO2), 2500);

            document.getElementById("ecoImpact")?.classList.add("active");


    

        window.calculatedData = {
            monthly_bill: monthly_bill,
            estimated_kw: systemKW,
            estimated_cost: final_cost,
            yearly_savings: yearly_savings
        };
        

    });

    document.getElementById("submitLead")?.addEventListener("click", function() {

        const name = document.getElementById("leadName").value.trim();
        const phone = document.getElementById("leadPhone").value.trim();
        const email = document.getElementById("leadEmail").value.trim();
        const city = document.getElementById("leadCity").value.trim();
    
        if (!name || !phone) {
            alert("Please enter name and phone");
            return;
        }
    
        fetch("saveLead.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                name,
                phone,
                email,
                city,
                monthly_bill: window.calculatedData.monthly_bill,
                estimated_kw: window.calculatedData.estimated_kw,
                estimated_cost: window.calculatedData.estimated_cost,
                yearly_savings: window.calculatedData.yearly_savings,
                message: "Lead from Solar Calculator"
            })
        })
        .then(res => res.json())
        .then(data => {

            console.log(data);


            const message = `🔥 New Solar Calculator Lead
        
        Name: ${name}
        Phone: ${phone}
        City: ${city}
        Monthly Bill: ₹${window.calculatedData.monthly_bill}
        System Size: ${window.calculatedData.estimated_kw} kW
        Yearly Savings: ₹${window.calculatedData.yearly_savings}
        
        Status: New Lead`;
        
            const adminNumber = "919738805931"; // replace with your number (with country code)
        
            window.open(`https://wa.me/${adminNumber}?text=${encodeURIComponent(message)}`, "_blank");
        
            alert("Thank you! Our solar expert will contact you soon.");
        });
        
    });
    


});



/* ------------------------------
   Utility Safe Text Setter
--------------------------------*/
function setText(id, value) {
    const el = document.getElementById(id);
    if (el) el.innerText = value;
}


/* ------------------------------
   Projection Logic
--------------------------------*/
function calculateProjection(systemSize, tariff, exportRate, consumption) {

    let yearlyData = [];
    let degradation = 0.005;
    let productionPerYear = systemSize * 4 * 365;

    for (let year = 1; year <= 25; year++) {

        let degradedProduction = productionPerYear * Math.pow((1 - degradation), year - 1);

        let selfUse = Math.min(degradedProduction, consumption * 12);
        let extra = Math.max(degradedProduction - consumption * 12, 0);

        let savings = (selfUse * tariff) + (extra * exportRate);

        yearlyData.push(Math.round(savings));
    }

    return yearlyData;
}


/* ------------------------------
   ROI Chart
--------------------------------*/
function generateROIChart(yearly_savings, final_cost) {

    const canvas = document.getElementById("roiChart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    if (window.roiChartInstance) {
        window.roiChartInstance.destroy();
    }

    window.roiChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({ length: 25 }, (_, i) => "Year " + (i + 1)),
            datasets: [{
                label: 'Net Savings Growth',
                data: Array.from({ length: 25 }, (_, i) =>
                    (yearly_savings * (i + 1) - final_cost)
                ),
                borderColor: '#f9a825',
                backgroundColor: 'rgba(249,168,37,0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true }
    });
}


/* ------------------------------
   Projection Chart
--------------------------------*/
function generateProjectionChart(yearlySavings) {

    const canvas = document.getElementById("projectionChart");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");

    if (window.projectionChartInstance) {
        window.projectionChartInstance.destroy();
    }

    window.projectionChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({ length: 25 }, (_, i) => `Year ${i + 1}`),
            datasets: [{
                label: 'Annual Savings',
                data: yearlySavings,
                borderColor: 'green',
                tension: 0.3
            }]
        }
    });
}


/* ------------------------------
   Animate Counter
--------------------------------*/
function animateValue(id, start, end, duration) {

    const obj = document.getElementById(id);
    if (!obj) return;

    if (end <= 0) {
        obj.innerText = 0;
        return;
    }

    let startTimestamp = null;

    const step = (timestamp) => {

        if (!startTimestamp) startTimestamp = timestamp;

        const progress = Math.min((timestamp - startTimestamp) / duration, 1);

        obj.innerText =
            Math.floor(progress * (end - start) + start).toLocaleString();

        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };

    window.requestAnimationFrame(step);
}
const totalCO2 = systemKW * solarSettings.co2_per_kw * 25;
const trees = totalCO2 / solarSettings.co2_per_tree;

animateValue("treeCount", 0, Math.floor(trees), 2000);
animateValue("co2Count", 0, Math.floor(totalCO2), 2500);
