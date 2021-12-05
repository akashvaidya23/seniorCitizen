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
                $total_11 = 0;
                $total_12 = 0;
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($Hobbies as $item)
                @php
                    $total[$i] = 0;
                @endphp
                    <th scope="col">{{ $item->name_of_hobby }}</th>
                    @php
                        $i++;
                    @endphp
            @endforeach
        </tr>
            @php
                $i = 0;
            @endphp
            @foreach($Hobbies as $item)
                @foreach( $Hobby_wise as $hobby )
                        @php
                            if( $hobby->Hobby_id == $item->id )
                                $total[$i] = $total[$i] + $hobby->total;
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
                @foreach( $Hobbies as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $Hobby_wise as $hobby )
                        @if( $hobby->District == $dist->ID && $hobby->Hobby_id == $item->id )
                            <td align="right">{{ $hobby->total }}</td>
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