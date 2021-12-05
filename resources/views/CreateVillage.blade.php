<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add/Update village') }}
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

                    <input type="hidden" id="id" name="id" value="{{$id}}">
                   
                    <div class="dropdown dropdown-btn">    
                        <label for="district">जिल्हा</label>            
                        <select name="district" id="district" class="block mt-1 border-gray-300
                            focus:border-indigo-300 focus:ring focus:ring-indigo-300
                            focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="0">--- All ---</option>
                                @foreach ($district as $value)
                                    @if(isset($v[0]->District_id) && $v[0]->District_id !='' && $v[0]->District_id == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->name_of_district }}</option>                                        
                                    @endif
                                        <option value="{{ $value->id }}">{{ $value->name_of_district }}</option>
                                @endforeach
                        </select>       
                    </div>

                    <br>
                   

                    <div class="mt-4">
                       <div class="dropdown dropdown-btn">
                        <label for="taluka">तालुका</label>
                        <select name="taluka" id="taluka" class="block mt-1 border-gray-300
                            focus:border-indigo-300 focus:ring focus:ring-indigo-300
                            focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="0">--- All ---</option>
                                @if(isset($t) && $t!='')
                                    @foreach($t as $value)
                                        @if(isset($v[0]->Taluka_id) && $v[0]->Taluka_id!='' && $v[0]->Taluka_id == $value->id)
                                            <option value="{{ $value->id }}"selected>{{ $value->taluka_name }}</option>    
                                        @endif
                                            <option value="0">--- All ---</option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                    </div>
            
                    <br>

                    <div>
                        <x-jet-label for="village" value="{{ __('Add new village') }}" />
                        @if(isset($v[0]->name_of_village) && $v[0]->name_of_village!='')
                            <x-jet-input id="village" class="block mt-1" type="text" name="village" :value="$v[0]->name_of_village" required />
                        @else
                            <x-jet-input id="village" class="block mt-1" type="text" name="village" :value="old('village')" required />
                        @endif
                    </div>
                    
                    <br>
                    
                    <div class="mt-4">                           
                        <label for="deactivate">Shall I deactivate this column?</label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($v[0]->Active) && $v[0]->Active == '0' )
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="deactivate_0" value="0" name="deactivate" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="deactivate_0">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($v[0]->Active) && $v[0]->Active != '' && $v[0]->Active == '1' )
                                <input type="radio" id="deactivate_1" value="1" name="deactivate" class="custom-control-input" checked>
                            @elseif(isset($id) && $id==0 )
                                <input type="radio" id="deactivate_1" value="1" name="deactivate" class="custom-control-input">
                            @else
                               <input type="radio" id="deactivate_1" value="1" name="deactivate" class="custom-control-input">
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
            <div id="List_Villages">
                
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var id = $("#id").val();
    var district = $("#district").val();
    var taluka = $("#taluka").val();
    var village = $("#village").val();
    var deactivate = $("input[name='deactivate']:checked").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/insert/Village',
            data:
            {
                deactivate:deactivate, id:id, district:district, taluka:taluka, village:village, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {
                alert('Village added successfully');
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
    function onEdit(id,name_district,name_taluka,name_village,Active)
    {
        $("#id").val(id);
        $("#district").val(name_district);
        $("#taluka").val(name_taluka);
        $("#village").val(name_village);
        $('#deactivate_'+Active).prop('checked',true);   
        window.location = "/create/Village";
    }
</script>
<script type="text/javascript">
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {            
            var districtID = $(this).val();
            if(districtID) 
            {
				$.ajax({
                    url: '/myform/ajax/'+districtID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {                        
                        $('select[name="taluka"]').empty();
                        $('select[name="taluka"]').append('<option value="0">--- All ---</option>'); 
                        $.each(data, function(key, value) 
                        {
                            $('select[name="taluka"]').append('<option value="'+ key +'">'+ value +'</option>');
                           
                        });
                    }
				});
				
            }
            else
            {
                $('#taluka').empty();
                $('select[name="taluka"]').append('<option value="0">--- All ---</option>'); 
            }
        });
    });
</script>

<script>
$(document).ready(function() 
    {
        $('select[name="taluka"]').on('change', function() 
        {
            var talukaID = $(this).val();
            var district = $("#district").val();            
            if(talukaID) 
            {
				$.ajax({
                    url: '/List/Village/'+district+'/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#List_Dashboard").html(data);
                    }
				});
            }
            else
            {
                $('#village').empty();
            }
        });
    });
</script>