@php
    $count = 0;
    $countI = 0;
@endphp
@foreach($userCount as $item)
    @php
        $count = $count + $item->total;
    @endphp
@endforeach
@foreach($Incomplete_Entries as $ItemI)
    @php
        $countI = $countI + $ItemI->total;
    @endphp
@endforeach
@php
    $i = 1;
@endphp
<table class="table table-bordered border-dark text-center">
    </script>
        <tr style="background-color:#0d3d54;color:white">
            <td class="fw-bolder">Sr.No</td>
            <td class="fw-bolder">Name of the user</td>
            <td class="fw-bolder">No of Entries</td>
            <td class="fw-bolder">No of Incomplete Entries</td>
        </tr>
        <tr style="background-color:#d9d9d9;">
            <td  class="fw-bolder" scope="row">-</td>
            <td  class="fw-bolder">Total</td>
            <td  class="fw-bolder">{{$count}}</td>
            <td  class="fw-bolder">{{$countI}}</td>
        </tr>
        @foreach($userCount as $item)
            <tr>
                <td scope="row">{{ $i }}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->total}}</td>
                @php
                    $Flag = False;
                @endphp
                @foreach($Incomplete_Entries as $I)
                    @if($item->id == $I->UID)
                    @php
                        $Flag = True;
                    @endphp
                    <td>{{$I->total}}</td>
                    @endif
                @endforeach
                    @if($Flag == False)
                        <td>0</td>                                        
                    @endif
            </tr>    
                @php
                    $i++;
                @endphp
        @endforeach
</table> 