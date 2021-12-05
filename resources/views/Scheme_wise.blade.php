<table class="table table-bordered border-dark text-center">
    <thead>
        <tr style="background-color:#0d3d54;color:white">
            <th scope="col"></th>
            @php
                $Flag = "True";
                $total_1 = 0;
                $total_2 = 0;
                $total_3 = 0;
                $total_4 = 0;
                $total_5 = 0;
                $total_6 = 0;
                $total_7 = 0;
                $total_8 = 0;
                $total_9 = 0;
                $total_10 = 0;
                $total_11 = 0;
                $total_12 = 0;
                $total_13 = 0;
                $total_14 = 0;
                $total_15 = 0;
                $total_16 = 0;
                $total_17 = 0;
                $total_18 = 0;
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($schemes as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->type_of_govt_scheme }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($schemes as $item)
                @foreach( $SchemeWise as $scheme )
                        @php
                            if( $scheme->Govt_scheme_id == $item->id )
                                $total[$i] = $total[$i] + $scheme->total;
                        @endphp
                @endforeach
                @php
                    $i++;
                @endphp
            @endforeach
        </tr>
        <tr>
        <td style="background-color:#d9d9d9;" class="fw-bolder" scope="row">Total</td>
            @foreach($total as $key => $value)
                <td style="background-color:#d9d9d9;" align="right" class="fw-bolder">{{$value}}</td>
            @endforeach
        </tr> 
        @foreach ($district as $dist)                                        
            <tr>
                <td class="">{{ $dist->Name }}</td>
                @foreach( $schemes as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $SchemeWise as $scheme )
                        @if( $scheme->District == $dist->ID && $scheme->Govt_scheme_id == $item->id )
                            <td align="right">{{ $scheme->total }}</td>
                            @php
                                $Flag = "False";
                            @endphp
                            @break
                        @endif
                    @endforeach
                    @if($Flag == "False")
                        @continue
                    @endif
                    <td align="right">0</td> 
                @endforeach
            </tr>
        @endforeach
    </thead>
</table>