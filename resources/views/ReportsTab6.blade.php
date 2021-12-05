<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('इतर माहिती चे Reports') }}
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
                        <label for="Income_increase_YN">Income increase Yes/No wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Income_increase_YN" onclick="Scheme_YN()" value="Y" name="Income_increase_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Income_increase_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Income_increase_YN2" onclick="Scheme_YN()" value="N" name="Income_increase_YN" class="custom-control-input" checked> 
                            <label  class="custom-control-label" for="Income_increase_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Income_increase_YN_Dashboard">
                    
                    </div>

                    <br>
                    
                    <div style="background-color:#f16c21;color:white">
                        <label for="income_increaseWise">Income increase Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="income_increaseWise" value="Y" onclick="Scheme_wise()" name="income_increaseWise" class="custom-control-input">
                            <label class="custom-control-label" for="income_increaseWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="income_increaseWise2" value="N" onclick="Scheme_wise()" name="income_increaseWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="income_increaseWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="income_increase_Wise_Dashboard" class="table-scroll">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Tools_YN">Tools YN wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Tools_YN" onclick="Tools()" value="Y" name="Tools_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Tools_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Tools_YN2" onclick="Tools()" value="N" name="Tools_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Tools_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Tools_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="ToolWise" class="fw-bolder">Tools Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="ToolWise" onclick="Tool_wise()" value="Y" name="ToolWise" class="custom-control-input">
                            <label class="custom-control-label" for="ToolWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ToolWise2" onclick="Tool_wise()" value="N" name="ToolWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="ToolWise2">Hide</label>
                        </div>
                    </div>

                    <br>
                    
                    <div id="Tool_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Medical_Equipment_Wise">Medical Equipment Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Medical_Equipment_Wise" onclick="Medical_wise()" value="Y" name="Medical_Equipment_Wise" class="custom-control-input">
                            <label class="custom-control-label" for="Medical_Equipment_Wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Medical_Equipment_Wise2" onclick="Medical_wise()" value="N" name="Medical_Equipment_Wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Medical_Equipment_Wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Medical_Equipment_Wise_Dashboard" class="table-scroll">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Social_service_YN">Social service YN report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Social_service_YN" onclick="Social_service()" value="Y" name="Social_service_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Social_service_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Social_service_YN2" onclick="Social_service()" value="N" name="Social_service_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Social_service_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Social_service_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Social_service_Wise">Social service Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Social_service_Wise" onclick="Social_wise()" value="Y" name="Social_service_Wise" class="custom-control-input">
                            <label class="custom-control-label" for="Social_service_Wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Social_service_Wise2" onclick="Social_wise()" value="N" name="Social_service_Wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Social_service_Wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Social_service_Wise_Dashboard" class="table-scroll">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Teaching_skill_Wise">Teaching skill Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Teaching_skill_Wise" value="Y" onclick="teaching_skill()" name="Teaching_skill_Wise" class="custom-control-input">
                            <label class="custom-control-label" for="Teaching_skill_Wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Teaching_skill_Wise2" value="N" onclick="teaching_skill()" name="Teaching_skill_Wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Teaching_skill_Wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Teaching_skill_Wise_Dashboard" class="table-scroll">

                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Hobby_Wise">Hobby Wise Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Hobby_Wise" value="Y" onclick="Hobby()" name="Hobby_Wise" class="custom-control-input">
                            <label class="custom-control-label" for="Hobby_Wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Hobby_Wise2" value="N" onclick="Hobby()" name="Hobby_Wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Hobby_Wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Hobby_wise_Dashboard" class="table-scroll">
                        
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
        });
    });
</script>

<script>
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {
            var district = $("#district").val();
            if(district && $("input[name='Income_increase_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Income_increase_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Income_increase_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='income_increaseWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/income_increaseWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#income_increase_Wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Tools_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Tools_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Tools_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='ToolWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/ToolWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Tool_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Medical_Equipment_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Medical_Equipment_Wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Social_service_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Social_service_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Social_service_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Social_service_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Social_service_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Social_service_Wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Teaching_skill_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Teaching_skill_Wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Hobby_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Hobby_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Hobby_wise_Dashboard").html(data);
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
            
            if(talukaID>0 && $("input[name='Income_increase_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Income_increase_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Income_increase_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Income_increase_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Income_increase_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Income_increase_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='income_increaseWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/income_increaseWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#income_increase_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='income_increaseWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/income_increaseWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#income_increase_Wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Tools_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Tools_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Tools_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Tools_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Tools_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Tools_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='ToolWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/ToolWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Tool_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='ToolWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/ToolWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Tool_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Medical_Equipment_Wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Medical_Equipment_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Medical_Equipment_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Medical_Equipment_Wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Social_service_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Social_service_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Social_service_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Social_service_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Social_service_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Social_service_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Social_service_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Social_service_Wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Social_service_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Social_service_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Social_service_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Social_service_Wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Teaching_skill_Wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Teaching_skill_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Teaching_skill_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Teaching_skill_Wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Hobby_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Hobby_Wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Hobby_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Hobby_Wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Hobby_Wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Hobby_wise_Dashboard").html(data);
                    }
                });
            }
        });
    });
</script>


<script>
    function Scheme_YN()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Income_increase_YN']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Income_increase_YN_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Income_increase_YN_Dashboard").show();
        }
    }

    $("#Income_increase_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();
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
        
        if(talukaID>0 && $("input[name='Income_increase_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Income_increase_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Income_increase_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Income_increase_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Income_increase_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Income_increase_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>


<script>
    function Scheme_wise()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='income_increaseWise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#income_increase_Wise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#income_increase_Wise_Dashboard").show();
        }
    }

    $("#income_increaseWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='income_increaseWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/income_increaseWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#income_increase_Wise_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='income_increaseWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/income_increaseWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#income_increase_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='income_increaseWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/income_increaseWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#income_increase_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Tools()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Tools_YN']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Tools_YN_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Tools_YN_Dashboard").show();
        }
    }

    $("#Tools_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Tools_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Tools_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Tools_YN_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Tools_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Tools_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Tools_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Tools_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Tools_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Tools_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Tool_wise()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='ToolWise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Tool_wise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Tool_wise_Dashboard").show();
        }
    }

    $("#ToolWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='ToolWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/ToolWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Tool_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='ToolWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/ToolWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Tool_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='ToolWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/ToolWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Tool_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>


<script>
    function Medical_wise()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Medical_Equipment_Wise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Medical_Equipment_Wise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Medical_Equipment_Wise_Dashboard").show();
        }
    }

    $("#Medical_Equipment_Wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Medical_Equipment_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Medical_Equipment_Wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Medical_Equipment_Wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Medical_Equipment_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Medical_Equipment_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Medical_Equipment_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Medical_Equipment_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Social_service()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Social_service_YN']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Social_service_YN_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Social_service_YN_Dashboard").show();
        }
    }

    $("#Social_service_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Social_service_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Social_service_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Social_service_YN_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='Social_service_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Social_service_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Social_service_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Social_service_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Social_service_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Social_service_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>


<script>
    function Social_wise()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Social_service_Wise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Social_service_Wise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Social_service_Wise_Dashboard").show();
        }
    }

    $("#Social_service_Wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Social_service_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Social_service_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Social_service_Wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Social_service_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Social_service_Wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Social_service_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Social_service_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Social_service_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Social_service_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>


<script>
    function teaching_skill()
    {
        if($("input[name='Teaching_skill_Wise']:checked").val()=='N')
        {
            $("#Teaching_skill_Wise_Dashboard").hide();
        }
        else
        {
            $("#Teaching_skill_Wise_Dashboard").show();
        }
    }

    $("#Teaching_skill_Wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Teaching_skill_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Teaching_skill_Wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Teaching_skill_Wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Teaching_skill_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Teaching_skill_Wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Teaching_skill_Wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Teaching_skill_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>


<script>
    function Hobby()
    {
        if($("input[name='Hobby_Wise']:checked").val()=='N')
        {
            $("#Hobby_wise_Dashboard").hide();
        }
        else
        {
            $("#Hobby_wise_Dashboard").show();
        }
    }

    $("#Hobby_Wise").click(function(e)
    {
        $.ajax({
            url: '/ReportTab6/Hobby_wise/',
            success:function(result)
            {
                $("#Hobby_wise_Dashboard").html(result);
            }
        });
    });
</script>