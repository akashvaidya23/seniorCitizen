<table class="table table-bordered border-dark text-center main-table">
    <thead>
        <tr style="background-color:#0d3d54;color:white">
            <th style=" position:absolute;
             width: 150px;
    height: 200px;
    /* border-left-width: 1px;
    padding-right: 70px;
    padding-left: 79px;
    padding-top: 0px;
    padding-bottom: 0px;
    border-top-width: 0px;
    border-bottom-width: 1px;
    z-index:0; */
    background-color:#0d3d54;
" scope="col"></th>
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
                $total_19 = 0;
                $total_20 = 0;
                $total = [];
            @endphp
            @php
                $i = 0;
            @endphp
            @foreach($handicap_types as $item)
                @php
                    $total[$i] = 0;
                @endphp
                @if($i==0)
                    <th style="
                        border-left-width: 150px;
                        padding-right: 60px;
                        padding-left: 60px;
                        padding-top: 0px;
                        padding-bottom: 0px;
                        border-top-width: 0px;
                        border-bottom-width: 0px;
                        margin-left:120px;" scope="col">{{ $item->type_of_disability }}</th>
                @else
                    <th style="
                                padding-right: 60px;
                                padding-left: 60px;
                                padding-top: 0px;
                                padding-bottom: 0px;
                                border-top-width: 0px;
                                border-bottom-width: 0px;" scope="col">{{ $item->type_of_disability }}</th>
                @endif
                @php
                    $i++;
                @endphp
            @endforeach
        </tr>
        
            @php
                $i = 0;
            @endphp
            @foreach($handicap_types as $item)
                @foreach( $Hancicap_wise as $handicap )
                        @php
                            if( $handicap->Handicap_id == $item->id )
                                $total[$i] = $total[$i] + $handicap->total;
                        @endphp
                @endforeach
                @php
                    $i++;
                @endphp
            @endforeach
        </tr>
        <tr>
        <td style="position:absolute;width:150px;background-color:#d9d9d9;" class="fw-bolder" scope="row">Total</td>
            @foreach($total as $key => $value)
                <td style="background-color:#d9d9d9;" align="right" class="fw-bolder">{{$value}}</td>
            @endforeach
        </tr> 
        @foreach ($district as $dist)                                        
            <tr>
                <td style="position:absolute;width:150px;background-color:white" color="whitesmoke">{{$dist->Name}}</td>
                @foreach( $handicap_types as $item )
                @php
                    $Flag = "True";
                    $i=0;
                @endphp
                    @foreach( $Hancicap_wise as $handicap )
                        @if( $handicap->District == $dist->ID && $handicap->Handicap_id == $item->id )
                            <td style="width:150px;" align="right">{{ $handicap->total }}</td>
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