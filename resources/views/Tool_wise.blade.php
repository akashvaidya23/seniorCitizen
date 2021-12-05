<table class="table table-bordered border-dark text-center main-table">
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
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($tools as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->type_of_tools }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($tools as $item)
                @foreach( $Tool_wise as $tool )
                        @php
                            if( $tool->Tool_type_id == $item->id )
                                $total[$i] = $total[$i] + $tool->total;
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
                <td color="whitesmoke" class="fixed-side">{{$dist->Name}}</td>
                @foreach( $tools as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $Tool_wise as $tool )
                        @if( $tool->District == $dist->ID && $tool->Tool_type_id == $item->id )
                            <td align="right">{{ $tool->total }}</td>
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