<table class="table table-striped table-bordered border-dark text-center">
@php
    $i=1;
@endphp
    <tr>
        <td class="fw-bolder">Sr.No</td>
        <td class="fw-bolder">Reference No</td>
        <td class="fw-bolder">संपूर्ण नाव</td>
        <td class="fw-bolder">जन्मतारीख</td>
        <td class="fw-bolder">मोबाईल नंबर</td>
        <td class="fw-bolder">गाव</td>
        <td class="fw-bolder">Action</td>
    </tr>
    @foreach($details_of_citizens as $item) 
        <tr id="{{$item->id}}">
            <td scope="row">{{ $i }}</td>
            <td>{{$item->id}}</td>
            <td>{{$item->Full_name}}</td>
            <td>{{date('d-M-Y', strtotime($item->date_of_birth))}}</td>
            <td>{{$item->Mobile_no}}</td>
            <td>{{$item->name_of_village}}</td>
            <td>
                <a href="{{"/citizen/tab1/".$item->id}}" >Edit</a>
            </td>
        </tr> 
        @php
            $i++;
        @endphp
    @endforeach
</table>