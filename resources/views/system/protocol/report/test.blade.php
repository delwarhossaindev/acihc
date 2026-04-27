@php

    $skus = [];
    $skus_unique = [];
    foreach ($protocol->product->skus as $sku) {
        $skus[] = $sku->ProductStrength;
    }

    $skus_unique = array_unique($skus) ?? [];

@endphp


<table border="1" width="1000px" cellspacing="1" cellpadding="" class="white" style="margin-top:2px;">

    <thead>
        <tr>
            <th>Test No.</th>
            <th>Test Parameters</th>
            <th colspan="{{ $protocol->product->skus->count() ?? 0 }}">(No. of Unit Per Test)</th>
        </tr>
        <tr>

            <th colspan="2">
                Strength
            </th>
            @foreach ($protocol->product->skus as $sku)
                <th colspan="">
                    {{ App\Models\ProductDetail::where('SkuID', $sku->SkuID)->first()['ProductStrength'] }} </th>
                {{-- <th colspan="2"> {{ implode(",",$skus_unique) ?? '' }} mg</th> --}}
            @endforeach

        </tr>
    </thead>


    <tbody>
        @php
            $sum = 0;
            $sum2 = 0;
            $count = 1;
            $sumIndexZero = 0;
            $sumIndexOne = 0;
            $sumIndexThree = 0;
            $unitPerTestTotal = 0;
        @endphp


        @foreach ($protocol->tests as $key => $element)
            <tr>
                <td align="center">{{ $key + 1 }}</td>
                <td align="center">{{ App\Models\Test::find($element->TestID)->TestName }}</td>



                @foreach (json_decode($element->Value) as $index => $unitPerTest)
                    @php
                        //    dd($unitPerTest,$index);

                        $unitPerTestTotal = 0;
                    @endphp

                    <td align="center">{{ $unitPerTest }}</td>
                    @php
                        $index % 2 == 0 ? ($sum += $unitPerTest) : ($sum2 += $unitPerTest);

                        if ($index == 0) {
                            $sumIndexZero += $unitPerTest;
                        }

                        if ($index == 1) {
                            $sumIndexOne += $unitPerTest;
                        }

                        if ($index == 2) {
                            $sumIndexThree += $unitPerTest;
                        }
                        $unitPerTestTotal += $unitPerTest;
                    @endphp
                @endforeach
            </tr>
            @php$count++;
                //dd()
            @endphp
        @endforeach


        <tr>
            <td align="center" colspan="">Total Number of Unit</td>
            @if ($protocol->product->skus->count() == '3')
                <td></td>
                <td align="center">{{ $sumIndexZero == 0 ? $unitPerTestTotal : $sumIndexZero }}</td>
            @elseif($protocol->product->skus->count() == '2')
                <td></td>
            @else
                <td></td>
            @endif

            {{-- <td align="center">{{ $sumIndexOne == 0 ? $unitPerTestTotal : $sumIndexOne }}</td> --}}
            <td align="center">{{ $sumIndexZero }}</td>
            @if ($sum2 != '0')
                <td align="center">{{ $sumIndexOne }}</td>
            @endif
        </tr>

        <tr>
            <td align="center" rowspan="">Total Number of Bottle/Blister/Samples</td>
            <td align="center">
                <table width="100%" cellspacing="1" cellpadding="3" class="white" border="0">
                    @if (!is_null($protocol->protocolTestPackBottle))
                        @php
                            $bottles = json_decode($protocol->protocolTestPackBottle->PackID);
                        @endphp
                        @foreach ($bottles as $bottle)
                            <tr>
                                <td align="center">For {{ $bottle }}{{ Str::endsWith($bottle, 's') ? '' : 's' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </td>

            @php
                if (isset($protocol->protocolTestPackBottle->NumberOfBottle)) {
                    $bottles = json_decode($protocol->protocolTestPackBottle->NumberOfBottle);
                }
            @endphp

            @if ($protocol->product->skus->count() > 0)
                @if (isset($bottles[0]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[0] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

            @if ($protocol->product->skus->count() > 1)
                @if (isset($bottles[1]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[1] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

            @if ($protocol->product->skus->count() > 2)
                @if (isset($bottles[2]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[2] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

            @if ($protocol->product->skus->count() > 3)
                @if (isset($bottles[3]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[3] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

            @if ($protocol->product->skus->count() > 4)
                @if (isset($bottles[4]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[4] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

            @if ($protocol->product->skus->count() > 5)
                @if (isset($bottles[5]))
                    <td align="center">
                        <table border="0" width="100%" cellspacing="0" cellpadding="3" class="white">
                            @foreach ($bottles[5] as $key => $item)
                                <tr>
                                    <td align="center">{{ $item }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endif
            @endif

        </tr>
    </tbody>
</table>
