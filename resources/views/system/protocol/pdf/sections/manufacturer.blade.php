<p class="pdf-section-heading"><b>6. Manufacturing Site Address:</b></p>
<div class="pdf-block">
    <div>{{ $protocol->manufacturer->ManufacturerName ?? '' }}</div>
    <div>{{ $protocol->manufacturer->address->address_line_1 ?? '' }}</div>
    <div>{{ $protocol->manufacturer->address->email ?? '' }}</div>
    <div>{{ $protocol->manufacturer->address->city ?? '' }} - {{ $protocol->manufacturer->address->zip_code ?? '' }}</div>
    <div>{{ $protocol->manufacturer->address->address_line_2 ?? '' }}</div>
</div>
