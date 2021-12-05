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
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($diseases as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->name_of_disease }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($diseases as $item)
                @foreach( $Disease_wise as $Disease )
                        @php
                            if( $Disease->Disease_id == $item->id )
                                $total[$i] = $total[$i] + $Disease->total;
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
                <td class="">{{$dist->Name}}</td>
                @foreach( $diseases as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $Disease_wise as $Disease )
                        @if( $Disease->District == $dist->ID && $Disease->Disease_id == $item->id )
                            <td align="right">{{ $Disease->total }}</td>
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