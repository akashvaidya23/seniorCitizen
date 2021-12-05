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
                $total = [];
                $total_value = 0;
                $totalT = 0;
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach( $income_source_wise as $income )
                @php
                    $total_value = $total_value + $income->total;
                @endphp
            @endforeach
            @foreach($income_sources as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->type_of_income_source }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
            <th>Total</th>
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($income_sources as $item)
            @php
                $total[$i] = 0;
            @endphp
                @foreach( $income_source_wise as $income )
                        @php
                            if( $income->Income_source == $item->id )
                            {
                                $total[$i] = $total[$i] + $income->total;
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
                @foreach( $income_sources as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $income_source_wise as $income )
                        @if( $income->District == $dist->ID && $income->Income_source == $item->id )
                            <td align="right">{{ $income->total }}</td>
                            @php
                                $total_education = $total_education + $income->total;
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