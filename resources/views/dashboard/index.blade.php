@extends('layouts.app')

@section('title', 'Dashboard administrativo')

@section('content')
<style>
    .dashboard-shell {
        display: grid;
        gap: 20px;
    }

    .page-title {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding: 4px 0 2px;
    }

    .page-title h1 {
        font-size: clamp(1.5rem, 2vw, 2.1rem);
        font-weight: 800;
        margin: 0;
        color: #0b3d73;
    }

    .page-title p {
        max-width: 720px;
    }

    .dashboard-action {
        border: 0;
        border-radius: 12px;
        padding: .72rem 1rem;
        box-shadow: 0 12px 24px rgba(11, 61, 115, .18);
        background: linear-gradient(135deg, #0b69c7 0%, #0b3d73 100%);
        font-weight: 700;
    }

    .filter-panel {
        background: rgba(255, 255, 255, .96);
        border: 1px solid #d9e2ec;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 14px 34px rgba(11, 61, 115, .06);
    }

    .kpi-card {
        position: relative;
        overflow: hidden;
        min-height: 148px;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(11, 61, 115, .08);
        animation: riseIn .45s ease both;
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 46px rgba(11, 61, 115, .13);
    }

    .kpi-card::after {
        content: "";
        position: absolute;
        inset: auto -40px -52px auto;
        width: 136px;
        height: 136px;
        border-radius: 50%;
        background: rgba(8, 118, 201, .10);
    }

    .kpi-card::before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, #0b3d73, #0f9f6e);
    }

    .kpi-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1.32rem;
        box-shadow: 0 12px 22px rgba(11, 61, 115, .15);
    }

    .kpi-value {
        font-size: 2.15rem;
        font-weight: 800;
        color: #101828;
        line-height: 1;
    }

    .kpi-label {
        color: #667085;
        font-weight: 700;
        font-size: .88rem;
    }

    .bg-blue { background: #0b3d73; }
    .bg-green { background: #0f9f6e; }
    .bg-amber { background: #f3b21a; }
    .bg-red { background: #d64242; }
    .bg-slate { background: #475467; }

    .chart-card {
        min-height: 372px;
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(11, 61, 115, .08);
    }

    .chart-box {
        height: 292px;
        padding-top: 8px;
    }

    .panel-badge {
        border-radius: 999px;
        padding: .45rem .7rem;
        font-weight: 700;
    }

    .table-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 18px 36px rgba(11, 61, 115, .08);
    }

    .table-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .search-box {
        max-width: 360px;
        flex: 1 1 240px;
    }

    .search-box .input-group-text,
    .search-box .form-control,
    .filter-panel .form-select {
        border-radius: 12px;
    }

    .filter-panel .form-select {
        border-color: #d9e2ec;
        min-height: 44px;
    }

    .filter-panel .form-select:focus,
    .search-box .form-control:focus {
        border-color: #0b69c7;
        box-shadow: 0 0 0 .2rem rgba(11, 105, 199, .12);
    }

    .sortable {
        border: 0;
        background: transparent;
        color: inherit;
        font: inherit;
        font-weight: 700;
        padding: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .student-table tbody tr {
        transition: background .15s ease;
    }

    .student-table tbody tr:hover {
        background: #f7fbff;
    }

    .student-table tbody td {
        padding-top: .9rem;
        padding-bottom: .9rem;
        border-color: #edf2f7;
    }

    .student-name {
        font-weight: 700;
        color: #101828;
    }

    .student-code {
        color: #667085;
        font-size: .82rem;
    }

    .pagination-button {
        border: 1px solid #d9e2ec;
        background: #fff;
        min-width: 36px;
        height: 36px;
        border-radius: 10px;
        color: #0b3d73;
        font-weight: 700;
        transition: background .18s ease, color .18s ease, transform .18s ease;
    }

    .pagination-button:hover {
        transform: translateY(-1px);
        background: #eef6ff;
    }

    .pagination-button.active {
        background: #0b3d73;
        color: #fff;
        border-color: #0b3d73;
    }

    @keyframes riseIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 767.98px) {
        .page-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .chart-card {
            min-height: 310px;
        }

        .chart-box {
            height: 240px;
        }
    }
</style>

@php
    $cards = [
        ['label' => 'Total estudiantes', 'value' => $kpis['total_estudiantes'] ?? 0, 'icon' => 'bi-people-fill', 'color' => 'bg-blue'],
        ['label' => 'Total tutores', 'value' => $kpis['total_tutores'] ?? 0, 'icon' => 'bi-person-workspace', 'color' => 'bg-green'],
        ['label' => 'Entrevistas realizadas', 'value' => $kpis['entrevistas_realizadas'] ?? 0, 'icon' => 'bi-clipboard2-check-fill', 'color' => 'bg-slate'],
        ['label' => 'Riesgo alto', 'value' => $kpis['riesgo_alto'] ?? 0, 'icon' => 'bi-exclamation-octagon-fill', 'color' => 'bg-red'],
        ['label' => 'Riesgo medio', 'value' => $kpis['riesgo_medio'] ?? 0, 'icon' => 'bi-exclamation-triangle-fill', 'color' => 'bg-amber'],
        ['label' => 'Riesgo bajo', 'value' => $kpis['riesgo_bajo'] ?? 0, 'icon' => 'bi-check-circle-fill', 'color' => 'bg-green'],
    ];
@endphp

<div class="page-title">
    <div>
        <h1>Dashboard administrativo</h1>
        <p class="text-muted mb-0">Seguimiento institucional de riesgo estudiantil, tutorias y entrevistas.</p>
    </div>
    <a href="{{ route('estudiantes.index') }}" class="btn btn-primary dashboard-action">
        <i class="bi bi-upload"></i>
        Cargar estudiantes
    </a>
</div>

<form class="filter-panel" method="GET">
    <div class="row g-3 align-items-end">
        @if (auth()->user()->hasRole('administrador', 'bienestar'))
            <div class="col-lg-3 col-md-6">
                <label class="form-label fw-semibold">Tutor</label>
                <select name="tutor_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach ($tutores as $tutor)
                        <option value="{{ $tutor->id }}" @selected(($filtros['tutor_id'] ?? '') == $tutor->id)>{{ $tutor->user->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-lg-3 col-md-6">
            <label class="form-label fw-semibold">Carrera</label>
            <select name="carrera" class="form-select">
                <option value="">Todas</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera }}" @selected(($filtros['carrera'] ?? '') == $carrera)>{{ $carrera }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4">
            <label class="form-label fw-semibold">Ciclo</label>
            <select name="semestre" class="form-select">
                <option value="">Todos</option>
                @foreach ($semestres as $semestre)
                    <option value="{{ $semestre }}" @selected(($filtros['semestre'] ?? '') == $semestre)>{{ $semestre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4">
            <label class="form-label fw-semibold">Grupo</label>
            <select name="grupo" class="form-select">
                <option value="">Todos</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo }}" @selected(($filtros['grupo'] ?? '') == $grupo)>{{ $grupo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 d-grid">
            <button class="btn btn-primary">
                <i class="bi bi-funnel-fill"></i>
                Filtrar
            </button>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
    @foreach ($cards as $index => $card)
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card kpi-card h-100" style="animation-delay: {{ $index * 55 }}ms">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="kpi-icon {{ $card['color'] }}"><i class="bi {{ $card['icon'] }}"></i></div>
                    </div>
                    <div class="kpi-value" data-count="{{ $card['value'] }}">0</div>
                    <div class="kpi-label mt-2">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-4 col-lg-6">
        <div class="card chart-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-0">Distribucion de riesgo</h2>
                        <div class="small text-muted">Ultima entrevista por estudiante</div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary panel-badge">Semaforo</span>
                </div>
                <div class="chart-box"><canvas id="riskChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card chart-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-0">Riesgo por carrera</h2>
                        <div class="small text-muted">Comparativo por programa academico</div>
                    </div>
                    <span class="badge bg-success-subtle text-success panel-badge">Carreras</span>
                </div>
                <div class="chart-box"><canvas id="careerRiskChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card chart-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h5 fw-bold mb-0">Entrevistas por periodo</h2>
                        <div class="small text-muted">Actividad registrada en el sistema</div>
                    </div>
                    <span class="badge bg-warning-subtle text-warning-emphasis panel-badge">Periodos</span>
                </div>
                <div class="chart-box"><canvas id="periodInterviewChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div class="card table-card">
    <div class="card-body">
        <div class="table-toolbar">
            <div>
                <h2 class="h5 fw-bold mb-0">Estudiantes monitoreados</h2>
                <div class="small text-muted"><span id="visibleRows">{{ $estudiantes->count() }}</span> registros visibles</div>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input id="studentSearch" type="search" class="form-control" placeholder="Buscar estudiante, codigo, carrera o tutor">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover student-table align-middle mb-0">
                <thead>
                    <tr>
                        <th><button class="sortable" type="button" data-sort="codigo">Codigo <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="estudiante">Estudiante <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="carrera">Carrera <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="semestre">Ciclo <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="grupo">Grupo <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="tutor">Tutor <i class="bi bi-arrow-down-up"></i></button></th>
                        <th><button class="sortable" type="button" data-sort="riesgo">Riesgo <i class="bi bi-arrow-down-up"></i></button></th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @forelse ($estudiantes as $estudiante)
                        @php
                            $nivel = optional($estudiante->ultimaEntrevista)->nivel_riesgo ?? 'Sin entrevista';
                            $tutorNombre = optional(optional($estudiante->tutor)->user)->name ?? 'Sin tutor';
                            $textoBusqueda = strtolower($estudiante->codigo.' '.$estudiante->apellidos.' '.$estudiante->nombres.' '.$estudiante->carrera.' '.$estudiante->semestre.' '.$estudiante->grupo.' '.$tutorNombre.' '.$nivel);
                        @endphp
                        <tr
                            data-search="{{ $textoBusqueda }}"
                            data-codigo="{{ $estudiante->codigo }}"
                            data-estudiante="{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}"
                            data-carrera="{{ $estudiante->carrera }}"
                            data-semestre="{{ $estudiante->semestre }}"
                            data-grupo="{{ $estudiante->grupo }}"
                            data-tutor="{{ $tutorNombre }}"
                            data-riesgo="{{ $nivel }}"
                        >
                            <td>
                                <div class="student-code">{{ $estudiante->codigo }}</div>
                            </td>
                            <td>
                                <div class="student-name">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</div>
                            </td>
                            <td>{{ $estudiante->carrera }}</td>
                            <td>{{ $estudiante->semestre }}</td>
                            <td><span class="badge text-bg-light border">{{ $estudiante->grupo }}</span></td>
                            <td>{{ $tutorNombre }}</td>
                            <td><span class="badge badge-risk-{{ str_replace(' entrevista', '', $nivel) }}">{{ $nivel }}</span></td>
                        </tr>
                    @empty
                        <tr class="empty-row"><td colspan="7">No hay estudiantes para mostrar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="small text-muted" id="paginationInfo">Mostrando registros</div>
            <div class="d-flex gap-2" id="paginationControls"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartColors = {
        rojo: '#d64242',
        ambar: '#f3b21a',
        verde: '#0f9f6e',
        gris: '#667085',
        azul: '#0b3d73'
    };

    const commonChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { labels: { boxWidth: 14, usePointStyle: true } }
        }
    };

    new Chart(document.getElementById('riskChart'), {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($resumen)),
            datasets: [{
                data: @json(array_values($resumen)),
                backgroundColor: [chartColors.rojo, chartColors.ambar, chartColors.verde, chartColors.gris],
                borderWidth: 0
            }]
        },
        options: {
            ...commonChartOptions,
            cutout: '68%'
        }
    });

    new Chart(document.getElementById('careerRiskChart'), {
        type: 'bar',
        data: {
            labels: @json($riesgoPorCarrera['labels'] ?? []),
            datasets: [
                { label: 'Rojo', data: @json($riesgoPorCarrera['rojo'] ?? []), backgroundColor: chartColors.rojo, borderRadius: 6 },
                { label: 'Ambar', data: @json($riesgoPorCarrera['ambar'] ?? []), backgroundColor: chartColors.ambar, borderRadius: 6 },
                { label: 'Verde', data: @json($riesgoPorCarrera['verde'] ?? []), backgroundColor: chartColors.verde, borderRadius: 6 }
            ]
        },
        options: {
            ...commonChartOptions,
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    new Chart(document.getElementById('periodInterviewChart'), {
        type: 'line',
        data: {
            labels: @json($entrevistasPorPeriodo['labels'] ?? []),
            datasets: [{
                label: 'Entrevistas',
                data: @json($entrevistasPorPeriodo['totales'] ?? []),
                borderColor: chartColors.azul,
                backgroundColor: 'rgba(11, 61, 115, .12)',
                pointBackgroundColor: chartColors.verde,
                pointRadius: 4,
                tension: .35,
                fill: true
            }]
        },
        options: {
            ...commonChartOptions,
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    document.querySelectorAll('[data-count]').forEach((element) => {
        const target = Number(element.dataset.count || 0);
        const duration = 700;
        const start = performance.now();

        const animate = (time) => {
            const progress = Math.min((time - start) / duration, 1);
            element.textContent = Math.floor(target * progress).toLocaleString('es-PE');

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    });

    const tableBody = document.getElementById('studentTableBody');
    const searchInput = document.getElementById('studentSearch');
    const paginationControls = document.getElementById('paginationControls');
    const paginationInfo = document.getElementById('paginationInfo');
    const visibleRows = document.getElementById('visibleRows');
    const pageSize = 10;
    let currentPage = 1;
    let currentSort = { key: 'estudiante', direction: 'asc' };
    let rows = Array.from(tableBody.querySelectorAll('tr:not(.empty-row)'));

    function normalize(value) {
        return String(value || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function filteredRows() {
        const query = normalize(searchInput.value);

        return rows
            .filter(row => normalize(row.dataset.search).includes(query))
            .sort((a, b) => {
                const valueA = normalize(a.dataset[currentSort.key]);
                const valueB = normalize(b.dataset[currentSort.key]);
                const result = valueA.localeCompare(valueB, 'es', { numeric: true });

                return currentSort.direction === 'asc' ? result : -result;
            });
    }

    function renderTable() {
        const result = filteredRows();
        const totalPages = Math.max(Math.ceil(result.length / pageSize), 1);
        currentPage = Math.min(currentPage, totalPages);

        rows.forEach(row => row.style.display = 'none');
        result.slice((currentPage - 1) * pageSize, currentPage * pageSize).forEach(row => row.style.display = '');

        visibleRows.textContent = result.length;
        paginationInfo.textContent = result.length
            ? `Mostrando ${((currentPage - 1) * pageSize) + 1} - ${Math.min(currentPage * pageSize, result.length)} de ${result.length}`
            : 'No hay registros con ese filtro';

        paginationControls.innerHTML = '';
        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = `pagination-button ${page === currentPage ? 'active' : ''}`;
            button.textContent = page;
            button.addEventListener('click', () => {
                currentPage = page;
                renderTable();
            });
            paginationControls.appendChild(button);
        }
    }

    document.querySelectorAll('[data-sort]').forEach(button => {
        button.addEventListener('click', () => {
            const key = button.dataset.sort;
            currentSort = {
                key,
                direction: currentSort.key === key && currentSort.direction === 'asc' ? 'desc' : 'asc'
            };
            renderTable();
        });
    });

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    renderTable();
</script>
@endpush
