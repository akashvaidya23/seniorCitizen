<table class="table table-bordered border-dark text-center">
    <thead>
        <tr style="background-color:#0d3d54;color:white">
            <th scope="col"></th>
            @php
                $Flag = "True";
                $total_1 = 0;
                $total_2 = 0;
                $total_3 = 0;
                $total = [];
                $total_value = 0;
                $totalT = 0;
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach( $Daily_Chores_wise as $Chores )
                @php
                    $total_value = $total_value + $Chores->total;
                @endphp
            @endforeach
            @foreach($daily_chores as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->type_of_help }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
            <th>Total</th>
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($daily_chores as $item)
            @php
				$total[$i] = 0;
            @endphp
                @foreach( $Daily_Chores_wise as $Chores )
                        @php
                            if( $Chores->daily_chores == $item->id )
                            {
                                $total[$i] = $total[$i] + $Chores->total;
                            }
                        @endphp
                @endforeach
                @php
                    $i++;
                @endphp
            @endforeach
        </tr>
        <tr>
        <td style="background-color:#d9d9d9;" class="fw-bolder" scope="row">Total</td>
        @php
            $Grand_total = 0;
        @endphp
            @foreach($total as $key => $value)
                <td style="background-color:#d9d9d9;" align="right" class="fw-bolder">{{$value}}</td>
                @php
                    $Grand_total = $Grand_total + $value;
                @endphp
            @endforeach
            <td style="background-color:#d9d9d9;" align="right" class="fw-bolder">{{ $Grand_total }}</td>
        </tr>
        @php
			$total_education = 0;
        @endphp
        @foreach ($district as $dist)
        @php
            $total_education = 0;
        @endphp                                       
            <tr>
                <td class="">{{$dist->Name}}</td>
                @foreach( $daily_chores as $item )
                    @php
                        $Flag = "True";
                        $i=0;
                    @endphp
                    @foreach( $Daily_Chores_wise as $Chores )
                        @if( $Chores->District == $dist->ID && $Chores->daily_chores == $item->id )
                            <td align="right">{{ $Chores->total }}</td>
                            @php
                                $total_education = $total_education + $Chores->total;
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
                <td align="right">{{$total_education}}</td>
            </tr>
        @endforeach
    </thead>
</table>