@php
    $count = 0;
    $totalN = 0;
    $totalY = 0;
@endphp
@foreach($Own_House_YN as $item)  
    @php
        if($item->YES)
            $totalY = $totalY + $item->YES;
        if($item->Negative)
            $totalN = $totalN + $item->Negative;
    @endphp
@endforeach
<table class="table table-bordered border-dark text-center">
    <thead>
        <tr style="background-color:#0d3d54;color:white">
            <th scope="col"></th>
            <th>मालकीचे घर नसणारे</th>
            <th>मालकीचे घर असलेले</th>
            <th class="fw-bolder">Total</th>
        </tr>
        <tr>
            <td align="center" class="fw-bolder" scope="row" style="background-color:#d9d9d9;">Total</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{$totalN}}</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{$totalY}}</td>
            <td align="right" class="fw-bolder" style="background-color:#d9d9d9;">{{$totalY + $totalN}}</td>
        </tr> 
        
        @php
            $i = 0;
            $districts = '';
            $Income_Increase = '';
            $prev_total = 0;
            $total = 0;
        @endphp
        @foreach ($Own_House_YN as $item)
            <tr>
                <td align="center">{{$item->Name}}</td>
                <td align="right">{{$item->Negative}}</td>
                <td align="right">{{$item->YES}}</td>
                <td align="right">{{$item->Negative + $item->YES}}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </thead>       
</table>