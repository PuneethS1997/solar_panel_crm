
document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("calculateBtn").addEventListener("click", function () {

        // your calculation logic here
        let monthly_bill = parseFloat(document.getElementById("bill").value);

        if (!monthly_bill || monthly_bill <= 0) {
            alert("Enter valid bill amount");
            return;
        }
    
        // 🔥 Dynamic Values From DB
        let unit_price = solarSettings.unit_price;
        let sunlight_factor = solarSettings.sunlight_factor;
        let cost_per_kw = solarSettings.cost_per_kw;
        let subsidy_percent = solarSettings.subsidy_percent;
        let co2_per_kw = solarSettings.co2_per_kw;
        let co2_per_tree = solarSettings.co2_per_tree;
    
        // 🔥 Calculations
        let units = monthly_bill / unit_price;
        let kw = units / sunlight_factor;
    
        let installation_cost = kw * cost_per_kw;
        let subsidy = installation_cost * subsidy_percent / 100;
        let final_cost = installation_cost - subsidy;
    
        let yearly_savings = monthly_bill * 12;
        let payback_years = (final_cost / yearly_savings).toFixed(1);
        let total_25_year_savings = (yearly_savings * 25 - final_cost).toFixed(0);
    
        // 🌍 Environmental
        let total_co2_saved = (kw * co2_per_kw * 25).toFixed(0);
        let trees_equivalent = Math.floor(total_co2_saved / co2_per_tree);
    
        // Show section
        document.getElementById("resultSection").classList.remove("d-none");
    
        document.getElementById("payback").innerHTML = payback_years + " Years";
        document.getElementById("totalSavings").innerHTML = "₹" + total_25_year_savings;
        document.getElementById("systemSize").innerHTML = kw.toFixed(2) + " kW";
    
        // Animate Environmental
        animateValue("trees", 0, trees_equivalent, 2000, " Trees 🌳");
        animateValue("co2", 0, total_co2_saved, 2000, " kg CO₂ Reduced");
    
        // ROI Chart
        generateChart(yearly_savings, final_cost);

    });

});

function animateValue(id, start, end, duration) {
    const obj = document.getElementById(id);
    if (!obj) return;

    let startTimestamp = null;

    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString();

        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };

    window.requestAnimationFrame(step);
}



function generateChart(yearly_savings, final_cost) {

    const ctx = document.getElementById('roiChart').getContext('2d');

    if(window.myChart) {
        window.myChart.destroy();
    }

    window.myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({length: 25}, (_, i) => "Year " + (i+1)),
            datasets: [{
                label: 'Net Savings Growth',
                data: Array.from({length: 25}, (_, i) => (yearly_savings * (i+1) - final_cost)),
                borderColor: '#f9a825',
                backgroundColor: 'rgba(249,168,37,0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            animation: { duration: 2000 }
        }
    });
}


async function fetchStateData() {

    const state = document.getElementById("state").value;
    const type = document.getElementById("connectionType").value;

    const response = await fetch(`getStateData.php?state_id=${state}&connection_type=${type}`);
    const data = await response.json();

    return data;
}
function calculateSubsidy(systemSize, costPerKW, subsidyPercent, maxKW) {

    const eligibleKW = Math.min(systemSize, maxKW);

    const eligibleAmount = eligibleKW * costPerKW;

    return eligibleAmount * (subsidyPercent / 100);
}
function calculateProjection(systemSize, tariff, exportRate, consumption) {

    let yearlyData = [];
    let degradation = 0.005; // 0.5%

    let productionPerYear = systemSize * 4 * 365;

    for(let year = 1; year <= 25; year++) {

        let degradedProduction = productionPerYear * Math.pow((1 - degradation), year - 1);

        let selfUse = Math.min(degradedProduction, consumption * 12);
        let extra = Math.max(degradedProduction - consumption * 12, 0);

        let savings = (selfUse * tariff) + (extra * exportRate);

        yearlyData.push(Math.round(savings));
    }

    return yearlyData;
}
const yearlySavings = calculateProjection(...);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: Array.from({length: 25}, (_, i) => `Year ${i+1}`),
        datasets: [{
            label: 'Annual Savings',
            data: yearlySavings,
            borderColor: 'green',
            tension: 0.3
        }]
    }
});
