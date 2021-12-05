<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New village') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" method="POST" data-parsley-validate action="/insert/Village">
                    @csrf
                    
                    <a style="float:right" href="/create/Village/0" class="btn btn-danger">Add new village</a>
                    
                    <br>

                    <table class="table table-striped table-bordered border-dark text-center">
                        <tr>
                            <td class="fw-bolder">Sr.No</td>
                            <td class="fw-bolder">Name of the District</td>
                            <td class="fw-bolder">Name of the Taluka</td>
                            <td class="fw-bolder">Name of the village</td>
                            <td class="fw-bolder">Action</td>
                            <td class="fw-bolder">Activation Status</td>
                        </tr>

                        @foreach($villages as $item)
                            <tr>
                                <td scope="row">{{ $villages->firstItem()+$loop->index }}</td>
                                <td scope="row">{{$item->name_of_district}}</td>
                                <td scope="row">{{$item->taluka_name}}</td>
                                <td scope="row">{{$item->name_of_village}}</td>
                                <td>        
                                    <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->Village_id}}','{{$item->District_id}}','{{$item->Taluka_id}}',
                                        '{{$item->name_of_village}}','{{$item->Active}}')">Edit</a>
                                </td>
                                <td>
                                    @if($item->Active == '0')
                                        <label class="badge btn-danger">Deactive</label>
                                    @else
                                        <label class="badge btn-success">Active</label>
                                    @endif
                                </td>
                            </tr> 
                        @endforeach
                    </table>
                    <span>
                        {{$villages->links()}}
                  </span>
                </form>             
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
    function onEdit(id,District_id,Taluka_id,name_village,Active)
    {
        $("#id").val(id);
        $("#district").val(District_id);
        $("#taluka").val(Taluka_id);
        $("#village").val(name_village);
        $('#deactivate_'+Active).prop('checked',true);   
        window.location ="/create/Village/"+id;
    }
</script>