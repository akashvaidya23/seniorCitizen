<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New type of home') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" method="POST" data-parsley-validate action="#">
                    @csrf

                    <input type="hidden" id="id" name="id" value="">
                    <div>
                        <x-jet-label for="Home" value="{{ __('Add new type of help') }}" />
                        <x-jet-input id="Home" class="block mt-1" type="text" name="Home" :value="old('Home')" required />
                    </div>
                    
                    <br>

                    <div class="mt-4">                           
                        <label for="deactivate">Shall I deactivate this column?</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($page[0]->Active) && $page[0]->Active == '0')
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="deactivate_0">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($page[0]->Active) && $page[0]->Active == '1')
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
            <div id="HomeTypeList">
                <table class="table table-striped table-bordered border-dark text-center">
                    <tr>
                        <td class="fw-bolder">Sr.No</td>
                        <td class="fw-bolder">Type of home</td>
                        <td class="fw-bolder">Action</td>
                        <td class="fw-bolder">Activation Status</td>
                    </tr>
                    @php
                        $i=1
                    @endphp

                    @foreach($home as $item)
                        <tr id="{{$item->id}}">
                            <td scope="row">{{$i}}</td>
                            <td>{{$item->type_of_home}}</td>
                            <td>
                                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->type_of_home}}','{{$item->Active}}')">Edit</a>
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
    var Home = $("#Home").val();
    var deactivate = $("input[name='deactivate']:checked").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/insert/home',
            data:
            {
                deactivate:deactivate, id:id, Home:Home, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {                
                $("#HomeTypeList").html(result);
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
    function onEdit(id,name)
    {
        $("#id").val(id);
        $("#Home").val(name);
    }
</script>