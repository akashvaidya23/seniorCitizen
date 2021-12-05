<table class="table table-bordered border-dark text-center">
    <thead>
        <tr style="background-color:#0d3d54;color:white">
            <th></th>
            <th>Total</th>
            <th>सदस्यांबरोबर राहणारे</th>
            <th>एकटे राहणारे</th>
            @php
                $Flag = "True";
                $total = 0;
                $totalT = 0;
                $TotalAlone = 0;
            @endphp
        </tr>
        @foreach( $count as $counts )
        @php
            $totalT = $totalT+$counts->totalCount;
        @endphp
        @endforeach
        @foreach( $member_count as $Member )
            @php
                $total = $total+$Member->total;
            @endphp
        @endforeach
        <tr>
            <td class="fw-bolder" scope="row" style="background-color:#d9d9d9;">Total</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{ $totalT }}</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{ $total }}</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{ $totalT - $total }}</td>
        </tr> 
        
        @foreach ($district as $dist)                                        
            <tr>
                <td class="">{{$dist->Name}}</td>
                @php
                    $Flag = "True";
                    $i = 0;  
                    $j = 0; 
                @endphp
                    @foreach( $member_count as $Member )
                        @foreach( $count as $counts )
                            @if( $counts->District_ID == $dist->ID  &&  $Member->District_id == $dist->ID )
                                <td align="right">{{ $counts->totalCount }}</td>
                                <td align="right">{{ $Member->total }}</td>
                                <td align="right"> {{ $counts->totalCount - $Member->total }} </td>
                                @php
                                    $Flag = "False";
                                @endphp
                                @break
                            @endif
                            @php
                                $j++;
                            @endphp
                        @endforeach
                    @endforeach
                    @if($Flag == "False")
                        @continue
                    @endif
                    <td align="right">0</td>
                    <td align="right">0</td>
                    <td align="right">0</td>
            </tr>
        @endforeach
    </thead>
</table>