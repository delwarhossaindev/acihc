@php
    $cards = [
        [
            'label'  => 'Total Protocol',
            'count'  => \App\Models\Protocol::count(),
            'route'  => 'protocol',
            'icon'   => 'bx-copy',
            'color'  => 'primary',
        ],
        [
            'label'  => 'Total Sample',
            'count'  => \App\Models\Sample::count(),
            'route'  => 'sample.index',
            'icon'   => 'bx-list-check',
            'color'  => 'success',
        ],
        [
            'label'  => 'Total Product',
            'count'  => \App\Models\Product::count(),
            'route'  => 'product',
            'icon'   => 'bx-package',
            'color'  => 'danger',
        ],
        [
            'label'  => 'Total Report',
            'count'  => \App\Models\SampleReport::count(),
            'route'  => 'sample.report.index',
            'icon'   => 'bx-file',
            'color'  => 'warning',
        ],
    ];
@endphp

<div class="row g-3 mb-4">
    @foreach ($cards as $card)
        <div class="col-6 col-md-6 col-xl-3">
            <a href="{{ route($card['route']) }}" class="text-decoration-none text-dark">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="flex-grow-1 me-2">
                                <span class="stat-label">{{ $card['label'] }}</span>
                                <div class="stat-value mt-1">{{ number_format($card['count']) }}</div>
                            </div>
                            <span class="stat-icon bg-label-{{ $card['color'] }}">
                                <i class="bx {{ $card['icon'] }}"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
