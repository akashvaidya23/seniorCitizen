
    
    

            <table class="table table-striped table-bordered border-dark text-center">
            <tr>
            <td class="fw-bolder">Sr.No</td>
            <td class="fw-bolder">सदस्याचे नाव</td>
            <td class="fw-bolder">नाते</td>
            <td class="fw-bolder">व्यवसाय</td>
            <td class="fw-bolder">आपल्या सोबत राहतात का?</td>
            <td class="fw-bolder">मोबाईल नं.</td>
            <td class="fw-bolder">Action</td>
        </tr>
        @php
            $i=1
        @endphp
        
        @foreach($c as $item)
        <tr id="{{$item->id}}">
            <td scope="row">{{$i}}</td>
            <td>{{$item->name_of_member}}</td>
            <td>{{$item->type_of_relation}}</td>
            <td>{{$item->occupation}}</td>
            <td> 
                @if($item->lives_with_you == 'Y')
                    होय
                @else
                    नाही
                @endif    
            </td>
            <td>{{$item->Mobile_no}}</td>
            <td>
                <a href="#" class="btn btn-danger" id="Deletemember" onClick="DeleteMember('{{$item->id}}')" >Delete</a>
                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->name_of_member}}','{{$item->Relation}}',
                                                            '{{$item->occupation}}','{{$item->lives_with_you}}','{{$item->Mobile_no}}')">Edit</a>
            </td>
        </tr> 
            @php
            $i++
         @endphp
         
        @endforeach
        </table>
   