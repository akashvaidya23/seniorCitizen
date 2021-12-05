<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New ration card type') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" method="POST" data-parsley-validate action="/insert/ration">
                    @csrf

                    <input type="hidden" id="id" name="id" value="">
                    <div>
                        <x-jet-label for="ration" value="{{ __('Add new type of ration card') }}" />
                        <x-jet-input id="ration" class="block mt-1" type="text" name="ration" :value="old('ration')" required />
                    </div>
                    
                    <br>

                    <div class="mt-4">                           
                        <label for="deactivate">Shall I deactivate this column?</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($ration[0]->Active) && $ration[0]->Active == '0')
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="deactivate_0">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($ration[0]->Active) && $ration[0]->Active == '1')
                                <input type="radio" id="deactivate_1" value="1" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate_1" value="1" name="deactivate" class="custom-control-input" >
                            @endif
                                <label class="custom-control-label" for="deactivate_1">No</label>
                        </div>
                    </div>

                    <br>

                    <x-jet-button id="Submit" class="ml-4">
                        {{ __('Submit') }}
                    </x-jet-button>            
                </form>        
            </div>

            <br><br>
            <div id="RationList">
                <table class="table table-striped table-bordered border-dark text-center">
                    <tr>
                        <td class="fw-bolder">Sr.No</td>
                        <td class="fw-bolder">Name of the Page</td>
                        <td class="fw-bolder">Action</td>
                        <td class="fw-bolder">Activation Status</td>
                    </tr>
                    @php
                        $i=1
                    @endphp

                    @foreach($ration as $item)
                        <tr id="{{$item->id}}">
                            <td scope="row">{{$i}}</td>
                            <td>{{$item->type_of_ration_card}}</td>
                            <td>
                                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->type_of_ration_card}}','{{$item->Active}}')">Edit</a>
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
    var ration = $("#ration").val();
    var deactivate = $("input[name='deactivate']:checked").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/insert/ration',
            data:
            {
                deactivate:deactivate, id:id, ration:ration, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {                
                $("#RationList").html(result);
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
    function onEdit(id,name,Active)
    {
        $("#id").val(id);
        $("#ration").val(name);
        $('#deactivate_'+Active).prop('checked',true);   
    }
</script>