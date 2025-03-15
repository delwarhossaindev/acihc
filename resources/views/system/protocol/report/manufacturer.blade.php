<div style="float:left; width:99%; border:0px solid #000;">
    <div style="float:left; width:99%; border-right:0px solid #000;">
        <p style="text-align:left; font-size:20px; font-weight:600">6.
            Manufacturing Site Address:</p>
        <p style="text-align:left; font-size:18px; font-weight:400; margin-bottom: 1px; margin-top: 1px;">
            {{ $protocol->manufacturer->ManufacturerName??'' }}</p>
        <p style="text-align:left; font-size:18px; font-weight:400; margin-bottom: 1px; margin-top: 1px;">
            {{ $protocol->manufacturer->address->address_line_1??'' }}</p>
        <p style="text-align:left; font-size:18px; font-weight:400; margin-bottom: 1px; margin-top: 1px;">
            {{ $protocol->manufacturer->address->email??'' }}</p>
        <p style="text-align:left; font-size:18px; font-weight:400; margin-bottom: 1px; margin-top: 1px;">
            {{ $protocol->manufacturer->address->city??'' }} - {{ $protocol->manufacturer->address->zip_code??'' }}</p>
        <p style="text-align:left; font-size:18px; font-weight:400;  margin-top: 1px;">
            {{ $protocol->manufacturer->address->address_line_2 ?? '' }}
        </p>
        <br>
    </div>
</div>
