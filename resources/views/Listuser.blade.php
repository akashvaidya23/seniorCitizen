<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Users') }}
        </h2>
    </x-slot>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
   </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div id="log"></div>
                <form id="validate_form" data-parsley-validate action="/citizen/tab6/insert/" method="POST">
                    @csrf
                    <div id="Citizens">
                        <table class="table table-striped table-bordered border-dark text-center">
                            <tr>
                                <td class="fw-bolder">Sr.No</td>
                                <td class="fw-bolder">User_id</td>
                                <td class="fw-bolder">User's Name</td>
                                <td class="fw-bolder">E-mail</td>
                                <td class="fw-bolder">District</td>
                                <td class="fw-bolder">Taluka</td>
                                <td class="fw-bolder">Activation status</td>
                                <td class="fw-bolder">Action</td>
                            </tr>
                        
                            @foreach($users as $item)
                                <tr id="sid{{$item->id}}">
                                    <td scope="row">{{ $users->firstItem()+$loop->index }}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->name_of_district}}</td>
                                    <td>{{$item->taluka_name}}</td>
                                    <td>
                                        @if($item->Banned == '1')
                                            <label class="badge btn-danger">Deactive</label>
                                        @else
                                            <label class="badge btn-success">Active</label>
                                        @endif    
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="{{"/Edit/user/".$item->id}}">Edit</a>
                                        <a class="btn btn-success" href="{{"/change/password/".$item->id}}">Change Password</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        </div>
                    <span>
                        {{$users->links()}}
                    </span>
                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
function deleteRecord(id)   
{
    var a = confirm("Do you want to delete this record?");
    if (a == true) 
    {
        $.ajax(
        {
            url: '/delete/'+id,
            data:
            {
        
            },
            success:function(response)
            {
                $("#Citizens").html(response);
                document.getElementById('log').innerHTML = "Data deleted successfully.";
            }
        });
    }       
    else
    {
        return false;
    } 
}
</script>