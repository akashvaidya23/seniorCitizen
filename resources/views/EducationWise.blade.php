@php
    $count = 0;
@endphp
@foreach($EducationCount as $item)  
    @php
        $count = $count + $item->total;
    @endphp
@endforeach

@php
    $i=1;
@endphp
<table class="table table-bordered border-dark text-center">
    <tr style="background-color:#0d3d54;color:white">
        <td class="fw-bolder">Sr.No</td>
        <td class="fw-bolder">Name</td>
        <td class="fw-bolder">No of Records</td>
    </tr>
    <tr style="background-color:d9d9d9">
            <td  class="fw-bolder" scope="row">-</td>
            <td  class="fw-bolder">Total</td>
            <td  class="fw-bolder">{{$count}}</td>
        </tr> 
    @foreach($EducationCount as $item)
        <tr>
            <td scope="row">{{$i}}</td>
            <td>{{$item->name_of_degree}}</td>
            <td>{{$item->total}}</td>
        </tr> 
        @php
            $i++
        @endphp
    @endforeach