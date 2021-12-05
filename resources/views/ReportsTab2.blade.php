<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('आपल्या कुटुंबातील सदस्य व त्यांचे व्यवसाय चे Reports') }}
        </h2>
    </x-slot>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

    <style>
        .dropdown-btn 
        {
            display: inline-block;
            *display: inline;
            padding: 20px 20px 20px;
            margin: 10px 0; 
        }
        .table-bordered td, .table-bordered th{border: 1px solid black;}
        
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" data-parsley-validate action="#" method="GET">
                    
                @if( Auth::user()->district_id == '')    
                        <div class="dropdown dropdown-btn">    
                            <label for="district">जिल्हा</label>            
                            <select name="district" id="district" class="block mt-1 border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="0">--- All ---</option>
                                    @foreach ($district as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name_of_district }}</option>
                                    @endforeach
                            </select>       
                        </div>
                    @else
                        <input type="hidden" name="district" id="district" value="{{Auth::user()->district_id}}">
                    @endif
                        
                    @if( Auth::user()->taluka_id == '') 
                        <div class="dropdown dropdown-btn">
                            <label for="taluka">तालुका</label>
                            <select name="taluka" id="taluka" class="block mt-1 border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="0">--- All ---</option>
                                @if(isset($taluka) && $taluka !='')
                                    @foreach($taluka as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->taluka_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="taluka" id="taluka" value="{{Auth::user()->taluka_id}}">
                    @endif
                    
                    <br>    

                    <div style="background-color:#f16c21;color:white">
                        <label for="MemberWise">Member wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="MemberWise" onclick="Member()" value="Y" name="MemberWise" class="custom-control-input">
                            <label class="custom-control-label" for="MemberWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="MemberWise2" onclick="Member()" value="N" name="MemberWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="MemberWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Member_wise_Dashboard">
                        
                    </div>

                    <x-jet-button id="Next_Page" class="ml-4">
                        {{ __('Next Page') }}
                    </x-jet-button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
jQuery("#Next_Page").click(function(e)
{
    jQuery.ajax({
        success:function(result)
        {
            window.location = "/Reports/tab3";
        }
    });
});
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
        $('select[name="district"]').on('change', function() 
        {
            var district = $("#district").val();
            if(district && $("input[name='MemberWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/MemberWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Member_wise_Dashboard").html(data);
                    }
                });
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
            
            if(talukaID>0 && $("input[name='MemberWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/MemberWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Member_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='MemberWise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/MemberWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Member_wise_Dashboard").html(data);
                    }
                });
            }
        });
    });
</script>

<script>
    function Member()
    {
        if($("input[name='MemberWise']:checked").val()=='N')
        {
            $("#Member_wise_Dashboard").hide();
        }
        else
        {
            $("#Member_wise_Dashboard").show();
        }
    }

    $("#MemberWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='MemberWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/MemberWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Member_wise_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='MemberWise']:checked").val()=='Y')
        {         
            $.ajax({
                url: '/village/MemberWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Member_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='MemberWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/MemberWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Member_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>
