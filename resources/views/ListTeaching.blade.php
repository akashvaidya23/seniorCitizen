<table class="table table-striped table-bordered border-dark text-center">
    <tr>
        <td class="fw-bolder">Sr.No</td>
        <td class="fw-bolder">Name of the teaching skill</td>
        <td class="fw-bolder">Action</td>
        <td class="fw-bolder">Activation Status</td>
    </tr>
    @php
        $i=1
    @endphp

    @foreach($teaching as $item)
        <tr id="{{$item->id}}">
            <td scope="row">{{$i}}</td>
            <td>{{$item->name_of_skill}}</td>
            <td>
                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->name_of_skill}}','{{$item->Active}}')">Edit</a>
            </td>
            <td>
                @if($item->Active == '0')
                    <label class="badge btn-danger">Deactive</label>
                @else
                    <label class="badge btn-success">Active</label>
                @endif
            </td>
        </tr> 
        @php
            $i++
        @endphp
    @endforeach
</table>