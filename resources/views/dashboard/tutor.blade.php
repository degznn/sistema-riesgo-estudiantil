@extends('layouts.app')

@section('title', 'Dashboard tutor')

@section('content')
<style>
    .tutor-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-bottom: 20px;
        padding: 4px 0 2px;
    }

    .tutor-header h1 {
        color: #0b3d73;
        font-size: clamp(1.45rem, 2vw, 2rem);
        font-weight: 800;
        margin: 0;
    }

    .metric-card {
        min-height: 148px;
        position: relative;
        overflow: hidden;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(11, 61, 115, .08);
        animation: riseIn .4s ease both;
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 46px rgba(11, 61, 115, .13);
    }

    .metric-card::after {
        content: "";
        position: absolute;
        right: -40px;
        bottom: -52px;
        width: 136px;
        height: 136px;
        border-radius: 50%;
        background: rgba(8, 118, 201, .10);
    }

    .metric-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, #0b3d73, #0f9f6e);
    }

    .metric-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1.3rem;
        box-shadow: 0 12px 22px rgba(11, 61, 115, .15);
    }

    .metric-value {
        font-size: 2.1rem;
        font-weight: 800;
        color: #101828;
        line-height: 1;
    }

    .metric-label {
        color: #667085;
        font-weight: 700;
        font-size: .88rem;
    }

    .bg-blue { background: #0b3d73; }
    .bg-green { background: #0f9f6e; }
    .bg-amber { background: #f3b21a; }
    .bg-red { background: #d64242; }
    .bg-slate { background: #475467; }

    .tutor-chart-card,
    .tutor-table-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(11, 61, 115, .08);
    }

    .panel-badge {
        border-radius: 999px;
        padding: .45rem .7rem;
        font-weight: 700;
    }

    .student-row {
        transition: background .15s ease;
    }

    .student-row:hover {
        background: #f7fbff;
    }

    .student-table tbody td {
        padding-top: .9rem;
        padding-bottom: .9rem;
        border-color: #edf2f7;
    }

    .student-name {
        color: #101828;
        font-weight: 700;
    }

    .student-meta {
        color: #667085;
        font-size: .84rem;
    }

    @keyframes riseIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 767.98px) {
        .tutor-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .tutor-header .btn {
            width: 100%;
        }
    }
</style>

@php
    $cards = [
        ['label' => 'Mis estudiantes asignados', 'value' => $kpis['total_estudiantes'] ?? 0, 'icon' => 'bi-people-fill', 'color' => 'bg-blue'],
        ['label' => 'Entrevistas pendientes', 'value' => $kpis['entrevistas_pendientes'] ?? 0, 'icon' => 'bi-hourglass-split', 'color' => 'bg-amber'],
        ['label' => 'Entrevistas realizadas', 'value' => $kpis['entrevistas_realizadas'] ?? 0, 'icon' => 'bi-clipboard2-check-fill', 'color' => 'bg-slate'],
        ['label' => 'Riesgo alto', 'value' => $kpis['riesgo_alto'] ?? 0, 'icon' => 'bi-exclamation-octagon-fill', 'color' => 'bg-red'],
        ['label' => 'Riesgo medio', 'value' => $kpis['riesgo_medio'] ?? 0, 'icon' => 'bi-exclamation-triangle-fill', 'color' => 'bg-amber'],
        ['label' => 'Riesgo bajo', 'value' => $kpis['riesgo_bajo'] ?? 0, 'icon' => 'bi-check-circle-fill', 'color' => 'bg-green'],
    ];
@endphp

<div class="tutor-header">
    <div>
        <h1>Panel del tutor</h1>
        <p class="text-muted mb-0">Seguimiento de tus estudiantes asignados y entrevistas registradas.</p>
    </div>
    <a href="{{ route('entrevistas.index') }}" class="btn btn-primary shadow-sm rounded-3 fw-semibold">
        <i class="bi bi-clipboard2-pulse-fill"></i>
        Ver entrevistas
    </a>
</div>

<div class="row g-3 mb-4">
    @foreach ($cards as $index => $card)
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card metric-card h-100" style="animation-delay: {{ $index * 45 }}ms">
                <div class="card-body position-relative">
                    <div class="metric-icon {{ $card['color'] }} mb-4">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                    <div class="metric-value">{{ $card['value'] }}</div>
                    <div class="metric-label mt-2">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card h-100 tutor-chart-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-0">Resumen de riesgo</h2>
                        <div class="small text-muted">Solo estudiantes asignados</div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary panel-badge">Tutor</span>
                </div>
                <div style="height: 270px">
                    <canvas id="tutorRiskChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card tutor-table-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-0">Mis estudiantes</h2>
                        <div class="small text-muted">Listado operativo para registrar entrevistas</div>
                    </div>
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-primary btn-sm rounded-3 fw-semibold">
                        <i class="bi bi-list-ul"></i>
                        Ver listado completo
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover student-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Estudiante</th>
                                <th>Carrera</th>
                                <th>Ciclo</th>
                                <th>Grupo</th>
                                <th>Riesgo</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($estudiantes as $estudiante)
                                @php $nivel = optional($estudiante->ultimaEntrevista)->nivel_riesgo ?? 'Sin entrevista'; @endphp
                                <tr class="student-row">
                                    <td>{{ $estudiante->codigo }}</td>
                                    <td>
                                        <div class="student-name">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</div>
                                        <div class="student-meta">{{ optional($estudiante->periodo)->nombre ?? 'Sin periodo' }}</div>
                                    </td>
                                    <td>{{ $estudiante->carrera }}</td>
                                    <td>{{ $estudiante->semestre }}</td>
                                    <td><span class="badge text-bg-light border">{{ $estudiante->grupo }}</span></td>
                                    <td><span class="badge badge-risk-{{ str_replace(' entrevista', '', $nivel) }}">{{ $nivel }}</span></td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ route('entrevistas.create', $estudiante) }}">
                                            <i class="bi bi-pencil-square"></i>
                                            Entrevistar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted">No tienes estudiantes asignados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('tutorRiskChart'), {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($resumen)),
            datasets: [{
                data: @json(array_values($resumen)),
                backgroundColor: ['#d64242', '#f3b21a', '#0f9f6e', '#667085'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 14, usePointStyle: true }
                }
            }
        }
    });
</script>
@endpush
