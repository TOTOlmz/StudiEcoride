

<div class ="staff-panel">
    <h2>Graphiques des covoiturages journaliers</h2>
    
    <canvas id="carpoolsChart" width="400" height="200"></canvas>

</div>

<div class ="staff-panel">
    <h2>Graphiques des crédits journaliers de la société</h2>

    <canvas id="creditsChart" width="400" height="200"></canvas>
    <p style="text-align:center; margin:30px 0 0 0;">Total des crédits gagnés par la plateforme : <strong><?php echo htmlspecialchars($totalCredits); ?> crédits</strong></p>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>


    // Graphique des covoiturages journaliers

    // Je récupère les données PHP
    const carpoolsData = <?php echo json_encode($carpoolsData); ?>;
    const creditsData = <?php echo json_encode($creditsData); ?>;

    // Graphique affichant les covoiturages par jour
    const carpoolsChart = document.getElementById('carpoolsChart');
    new Chart(carpoolsChart, {
    type: 'line',
    data: {
        labels: carpoolsData.map(item => item.date),
        datasets: [{
        label: 'Nombre de covoiturages',
        data: carpoolsData.map(item => item.total),
        borderWidth: 2,
        borderColor: '#00754a',
        pointStyle: 'rect',
        pointRotation: 45,
        tension: 0.1,
        fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
        legend: { onClick: false, }
        },
        scales: { y: { beginAtZero: true } }
    }
    });


    // Graphique affichant les crédits gagnés par jour
    const creditsChart = document.getElementById('creditsChart');
    new Chart(creditsChart, {
    type: 'line',
    data: {
        labels: creditsData.map(item => item.date),
        datasets: [{
        label: 'Crédits gagnés',
        data: creditsData.map(item => item.total_credits),
        borderWidth: 2,
        borderColor: '#00754a',
        pointStyle: 'rect',
        pointRotation: 45,
        tension: 0.1,
        fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
        legend: { onClick: false, }
        },
        scales: { y: { beginAtZero: true } }
    }
    });



</script>