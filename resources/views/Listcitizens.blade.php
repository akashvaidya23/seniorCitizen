<table class="table table-striped table-bordered border-dark text-center">
    <tr>
        <td class="fw-bolder">Sr.No</td>
        <td class="fw-bolder">Reference No</td>
        <td class="fw-bolder">संपूर्ण नाव</td>
        <td class="fw-bolder">जन्मतारीख</td>
        <td class="fw-bolder">मोबाईल नंबर</td>
        <td class="fw-bolder">Action</td>
    </tr>
    
    @foreach($details_of_citizens as $item)
        <tr id="{{$item->id}}">
            <td scope="row">{{ $details_of_citizens->firstItem()+$loop->index }}</td>
            <td>{{$item->id}}</td>
            <td>{{$item->Full_name}}</td>
            <td>{{date('d-M-Y', strtotime($item->date_of_birth))}}</td>
            <td>{{$item->Mobile_no}}</td>
            <td>
                <a class="btn btn-primary" href="{{"/citizen/tab1/".$item->id}}" >Edit</a>
                <a class="btn btn-danger" href="#" onclick="Delete('{{$item->id}}')">Delete</a>
            </td>
        </tr> 
    @endforeach
</table>