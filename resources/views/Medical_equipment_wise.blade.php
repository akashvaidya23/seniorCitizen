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
                $total_6 = 0;
                $total_7 = 0;
                $total_8 = 0;
                $total_9 = 0;
                $total_10 = 0;
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($mediacl_instruments as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->name_of_equipment }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($mediacl_instruments as $item)
                @foreach( $Medical_equipment_wise as $medical )
                        @php
                            if( $medical->medical_equipment_id == $item->id )
                                $total[$i] = $total[$i] + $medical->total;
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
                @foreach( $mediacl_instruments as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $Medical_equipment_wise as $medical )
                        @if( $medical->District == $dist->ID && $medical->medical_equipment_id == $item->id )
                            <td align="right">{{ $medical->total }}</td>
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