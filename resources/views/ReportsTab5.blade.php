<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('योजनांचा लाभ घेत असल्यास माहिती चे Reports') }}
        </h2>
    </x-slot>

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
                        <label for="SchemeAvail">Scheme Avail Yes/No report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="SchemeAvail" onclick="SchemeYN()" value="Y" name="SchemeAvail" class="custom-control-input">
                            <label class="custom-control-label" for="SchemeAvail">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="SchemeAvail2" onclick="SchemeYN()" value="N" name="SchemeAvail" class="custom-control-input" checked> 
                            <label  class="custom-control-label" for="SchemeAvail2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="SchemeAvail_Dashboard">
                    
                    </div>

                    <br>
                    
                    <div style="background-color:#f16c21;color:white">
                        <label for="Govt_SchemeWise">Govt Scheme Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Govt_SchemeWise" onclick="Scheme_wise()" value="Y" name="Govt_SchemeWise" class="custom-control-input">
                            <label class="custom-control-label" for="Govt_SchemeWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Govt_SchemeWise2" onclick="Scheme_wise()" value="N" name="Govt_SchemeWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Govt_SchemeWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Govt_Scheme_Wise_Dashboard">
                        
                    </div>

                    <br>
                    
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
            window.location = "/Reports/tab6";
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
        $('select[name="taluka"]').on('change', function() 
        {
            var talukaID = $(this).val();
            var district = $("#district").val();            
            if(talukaID) 
            {
                $.ajax({
                    url: '/village/count/'+talukaID+'/'+district,
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

<script type="text/javascript">
    $("#district").change(function() 
    {
        var districtID = $(this).val();
        if(districtID) 
        {
            $.ajax({
                url: '/district/count/'+districtID,
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
            $("#display").empty();
        }
    });
</script>

<script>
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {
            var district = $("#district").val();
            if(district && $("input[name='SchemeAvail']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/SchemeAvail/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#SchemeAvail_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Govt_SchemeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Govt_Scheme_Wise_Dashboard").html(data);
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
            
            if(talukaID>0 && $("input[name='SchemeAvail']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/SchemeAvail/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#SchemeAvail_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='SchemeAvail']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/SchemeAvail/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#SchemeAvail_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Govt_SchemeWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Govt_Scheme_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Govt_SchemeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Govt_Scheme_Wise_Dashboard").html(data);
                    }
                });
            }
        });
    });
</script>
<script>
    function SchemeYN()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='SchemeAvail']:checked").val()=='N')
        {
            //alert("Hide");
            $("#SchemeAvail_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#SchemeAvail_Dashboard").show();
        }
    }

    $("#SchemeAvail").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        
        if(district && $("input[name='SchemeAvail']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/SchemeAvail/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#SchemeAvail_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='SchemeAvail']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/SchemeAvail/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#SchemeAvail_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='SchemeAvail']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/SchemeAvail/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#SchemeAvail_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Scheme_wise()
    {
        if($("input[name='Govt_SchemeWise']:checked").val()=='N')
        {
            $("#Govt_Scheme_Wise_Dashboard").hide();
        }
        else
        {
            $("#Govt_Scheme_Wise_Dashboard").show();
        }
    }

    $("#Govt_SchemeWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Govt_SchemeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Govt_Scheme_Wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Govt_SchemeWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Govt_Scheme_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Govt_SchemeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Govt_SchemeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Govt_Scheme_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>
