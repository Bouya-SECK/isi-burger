@extends('layouts.gestionnaire')

@section('page-title', 'Statistiques')

@section('content')

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Statistiques & Rapports</h4>
        <p class="text-muted mb-0" style="font-size:0.9rem;">
            Aperçu des 12 derniers mois
        </p>
    </div>

    <div class="row g-4">

        {{-- Commandes par mois --}}
        <div class="col-md-6">
            <div class="table-card">
                <h6 class="fw-bold mb-3">Commandes par mois</h6>
                <canvas id="chartCommandes"></canvas>
            </div>
        </div>

        {{-- Recettes par mois --}}
        <div class="col-md-6">
            <div class="table-card">
                <h6 class="fw-bold mb-3">Recettes par mois (F CFA)</h6>
                <canvas id="chartRecettes"></canvas>
            </div>
        </div>

        {{-- Produits par catégorie --}}
        <div class="col-md-6">
            <div class="table-card">
                <h6 class="fw-bold mb-3">Burgers par catégorie</h6>
                <canvas id="chartCategories"></canvas>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart commandes par mois
        new Chart(document.getElementById('chartCommandes'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Commandes',
                    data: @json($commandesParMois),
                    backgroundColor: 'rgba(255, 107, 0, 0.7)',
                    borderColor: '#ff6b00',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Chart recettes par mois
        new Chart(document.getElementById('chartRecettes'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Recettes (F)',
                    data: @json($recettesParMois),
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderColor: '#0d6efd',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart catégories (donut)
        new Chart(document.getElementById('chartCategories'), {
            type: 'doughnut',
            data: {
                labels: @json($catLabels),
                datasets: [{
                    data: @json($catData),
                    backgroundColor: [
                        '#ff6b00', '#0d6efd', '#198754',
                        '#ffc107', '#dc3545', '#6f42c1'
                    ],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
@endsection
