<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Medical Equipment') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" method="POST" data-parsley-validate action="/insert/equipment">
                    @csrf

                    <input type="hidden" id="id" name="id" value="">
                    <div>
                        <x-jet-label for="Equipment" value="{{ __('Add new medical equipment') }}" />
                        <x-jet-input id="Equipment" class="block mt-1" type="text" name="Equipment" :value="old('Equipment')" required />
                    </div>

                    <div class="mt-4">                           
                        <label for="deactivate">Shall I deactivate this column?</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($medical_equipments[0]->Active) && $medical_equipments[0]->Active == '0')
                                <input type="radio" id="deactivate" value="0" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate" value="0" name="deactivate" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="deactivate">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($medical_equipments[0]->Active) && $medical_equipments[0]->Active == '1')
                                <input type="radio" id="deactivate_2" value="1" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate_2" value="1" name="deactivate" class="custom-control-input" >
                            @endif
                                <label class="custom-control-label" for="deactivate_2">No</label>
                        </div>
                    </div>
                    
                    <br>

                    <x-jet-button id="Submit" class="ml-4">
                        {{ __('Submit') }}
                    </x-jet-button>            
                </form>        
            </div>

            <br><br>
            <div id="EquipmentList">
                <table class="table table-striped table-bordered border-dark text-center">
                    <tr>
                        <td class="fw-bolder">Sr.No</td>
                        <td class="fw-bolder">Name of the Equipment</td>
                        <td class="fw-bolder">Action</td>
                        <td class="fw-bolder">Activation Status</td>
                    </tr>
                    @php
                        $i=1
                    @endphp

                    @foreach($medical_equipments as $item)
                        <tr id="{{$item->id}}">
                            <td scope="row">{{$i}}</td>
                            <td>{{$item->name_of_equipment}}</td>
                            <td>
                                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->name_of_equipment}}','{{ $item->Active }}')">Edit</a>
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
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var id = $("#id").val();
    var Equipment = $("#Equipment").val();
    var deactivate = $("input[name='deactivate']:checked").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/insert/equipment',
            data:
            {
                id:id, Equipment:Equipment, deactivate:deactivate, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {
                //alert(result);
                $("#EquipmentList").html(result);
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
    function onEdit(id,name_of_equipment,Active)
    {
        $("#id").val(id);
        $("#Equipment").val(name_of_equipment);
        $('#deactivate'+Active).prop('checked',true);
    }
</script>