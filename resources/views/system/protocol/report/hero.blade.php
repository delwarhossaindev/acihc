@php
$versionCount = \DB::table('ProtocolVersion')
                               ->where('protocol_id', $protocol->ProtocolID)
                               ->lockForUpdate()
                                ->max('version_no'); 

                              
$versionCount =     number_format((float)$versionCount, 2, '.', '') ?? number_format((float)1.00, 2, '.', '') ;                                                 
@endphp
<div style="float:left; width:99%; border:1px solid #000;">
    <div style="float:left; width:60px; border-right:1px solid  #000;">
        <div
            style="float:left; width:99%; text-align:left; padding:15px; border:0px solid  red;">
            <img src="{{ asset('logo.png') }}" width="40" height="40" />
        </div>
    </div>
    <div style="float:left; width:460px; border-right:1px solid #000;">
        <div
            style="float:left; width:99%; font-size:24px; padding-top:15px; padding-bottom:15px; line-height:30px; border:0px solid  red;">
            ACI HealthCare Limited
        </div>
    </div>
    <div style="float:left; width:460px; border-right:0px solid #000;">
        <div
            style="float:left; width:99%; font-size:24px; text-align:center; padding-top:15px; line-height:30px; border:0px solid  red;">
            Stability Protocol
        </div>
        <span>Protocol No:STB/PROT/{{ sprintf('%04d', $protocol->ProtocolID)  }}; Version:{{  $versionCount}}</span>
    </div>
</div>
<div
    style="float:left; width:99%; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">

    <div style="float:left; width:99%; border-right:0px solid #000;">
        <div
            style="float:left; width:99%; font-size:24px; padding-top:10px; padding-bottom:10px; line-height:30px; border:0px solid  red;">
            {{ $protocol->Title }}
        </div>
    </div>
</div>
<div
    style="float:left; width:99%; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">

    <div style="float:left; width:99%; border-right:0px solid #000;">
        <div
            style="float:left; width:99%; font-size:20px; padding-top:15px; padding-bottom:15px; line-height:30px; border:0px solid  red;">
            Strength:
            <span style="font-weight:400">
                @forelse ($protocol->product->skus as $strength)
                {{ $strength->ProductStrength }} mg
                @empty
                @endforelse
            </span>
        </div>
    </div>
</div>

