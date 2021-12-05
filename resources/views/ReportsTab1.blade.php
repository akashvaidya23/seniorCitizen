<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('सर्वसाधारण माहिती चे Reports') }}
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
                        <input type="hidden" name="district" id="district" value="{{Auth::user()->district_id}}">

                    @endif
                    
                    <br>

                    <div>
                        <label for="age_group">Select age group</label>
                    </div>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Education_wise">Education wise report:</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Education_wise_Y" onclick="education()" value="Y" name="Education_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Education_wise_Y">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Education_wise_N" onclick="education()" value="N" name="Education_wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Education_wise_N">Hide</label>
                        </div>
                    </div>

                    <br>
                                        
                    <div id="Education_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Own_house_YN">Own house Yes/No report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Own_house_YN" onclick="own_house_YN()" value="Y" name="Own_house_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Own_house_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Own_house_YN2" onclick="own_house_YN()" value="N" name="Own_house_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Own_house_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Own_house_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Home_type_wise">Home type wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Home_type_wise" onclick="Home_type()" value="Y" name="Home_type_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Home_type_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Home_type_wise2" onclick="Home_type()" value="N" name="Home_type_wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Home_type_wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="HomeType_wise_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Stove_type_wise">Stove type wise report?</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Stove_type_wise" onclick="Stove_type()" value="Y" name="Stove_type_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Stove_type_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Stove_type_wise2" onclick="Stove_type()" value="N" name="Stove_type_wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Stove_type_wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Stove_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Income_source_wise">Income source wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Income_source_wise" onchange="Income_source()" value="Y" name="Income_source_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Income_source_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Income_source_wise2" onchange="Income_source()" value="N" name="Income_source_wise" class="custom-control-input"checked>
                            <label  class="custom-control-label" for="Income_source_wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Income_source_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Bank_YN">Bank Account Yes/No report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Bank_YN" onchange="Bank_account_YN()" value="Y" name="Bank_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Bank_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Bank_YN2" onchange="Bank_account_YN()" value="N" name="Bank_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Bank_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Bank_account_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="BankTypeWise">Bank Type wise</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="BankTypeWise" value="Y" onclick="Bank_Type()" name="BankTypeWise" class="custom-control-input">
                            <label class="custom-control-label" for="BankTypeWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="BankTypeWise2" value="N" onclick="Bank_Type()" name="BankTypeWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="BankTypeWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Bank_type_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="WashroomWise">Washroom wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="WashroomWise" onclick="Washroom()" value="Y" name="WashroomWise" class="custom-control-input">
                            <label class="custom-control-label" for="WashroomWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="WashroomWise2" onclick="Washroom()" value="N" name="WashroomWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="WashroomWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Washroom_wise_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="BathroomWise">Bathroom wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="BathroomWise" onclick="Bathroom()" value="Y" name="BathroomWise" class="custom-control-input">
                            <label class="custom-control-label" for="BathroomWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="BathroomWise2" value="N" onclick="Bathroom()" name="BathroomWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="BathroomWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Bathroom_wise_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="LandWise">Land/prpoerty wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="LandWise" onclick="Land()" value="Y" name="LandWise" class="custom-control-input">
                            <label class="custom-control-label" for="LandWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="LandWise2" onclick="Land()" value="N" name="LandWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="LandWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="LandWise_Dashboard">
                    
                    </div>
                    
                    <br>
                    
                    <div style="background-color:#f16c21;color:white">
                        <label for="LandDisputeWise">Land/prpoerty dispute wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="LandDisputeWise" onclick="Land_Dispute()" value="Y" name="LandDisputeWise" class="custom-control-input">
                            <label class="custom-control-label" for="LandDisputeWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="LandDisputeWise2" onclick="Land_Dispute()" value="N" name="LandDisputeWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="LandDisputeWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Land_Dispute_Dashboard">
                    
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
            window.location = "/Reports/tab2";
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
    function education()
    {
        if($("input[name='Education_wise']:checked").val()=='N')
        {
            $("#Education_wise_Dashboard").hide();
        }
        else
        {
            $("#Education_wise_Dashboard").show();                    
        }
    }
</script>

<script>
    $("#Education_wise_Y").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Education_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/education/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Education_wise_Dashboard").html(data);
                }
            });
        }
        if(talukaID>0 && $("input[name='Education_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Educationwise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Education_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Education_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/education/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Education_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function own_house_YN()
    {
        if($("input[name='Own_house_YN']:checked").val()=='N')
        {
            $("#Own_house_YN_Dashboard").hide();
        }
        else
        {
            $("#Own_house_YN_Dashboard").show();
        }
    }

    $("#Own_house_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Own_house_YN']:checked").val()=='Y') 
        {
            $.ajax({
                url: '/Taluka/OwnHouseYN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Own_house_YN_Dashboard").html(data);
                }
            });
        }
        if(talukaID>0 && $("input[name='Own_house_YN']:checked").val()=='Y') 
        {
            $.ajax({
                url: '/VillageWise/OwnHouseYN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Own_house_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Own_house_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/OwnHouseYN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Own_house_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {
            var district = $("#district").val();
            if(district && $("input[name='Education_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/education/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Education_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Own_house_YN']:checked").val()=='Y') 
            {
                $.ajax({
                    url: '/Taluka/OwnHouseYN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Own_house_YN_Dashboard").html(data);
                    }
                });
            }
            
            if(district && $("input[name='Home_type_wise']:checked").val()=='Y') 
            {
                $.ajax({
                    url: '/Taluka/Home_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#HomeType_wise_Dashboard").html(data);                        
                    }
                });
            }

            if(district && $("input[name='Stove_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Stove_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Stove_wise_Dashboard").html(data);                        
                    }
                });
            }

            if(district && $("input[name='Income_source_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Income_source_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Income_source_wise_Dashboard").html(data);
                    }
                });
            }


            if(district && $("input[name='Bank_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Bank_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bank_account_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='BankTypeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/BankTypeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bank_type_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='WashroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/WashroomWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Washroom_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='BathroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/BathroomWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bathroom_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='LandWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/LandWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#LandWise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='LandDisputeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/LandDisputeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Land_Dispute_Dashboard").html(data);
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
            
            if(talukaID>0 && $("input[name='Education_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Educationwise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Education_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Education_wise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/education/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Education_wise_Dashboard").html(data);
                    }
                });
            }
            
            if(talukaID>0 && $("input[name='Own_house_YN']:checked").val()=='Y') 
            {
                $.ajax({
                    url: '/VillageWise/OwnHouseYN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Own_house_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Own_house_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/OwnHouseYN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Own_house_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Home_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/Home_type_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#HomeType_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Home_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Home_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#HomeType_wise_Dashboard").html(data);                        
                    }
                });
            }
            if(talukaID>0 && $("input[name='Stove_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/Stove_type_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Stove_wise_Dashboard").html(data);                        
                    }
                });
            }
            else if(talukaID == 0 && $("input[name='Stove_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Stove_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Stove_wise_Dashboard").html(data);                        
                    }
                });
            }

            if(talukaID>0 && $("input[name='Income_source_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/Income_source_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Income_source_wise_Dashboard").html(data);                        
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Income_source_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Income_source_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Income_source_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Bank_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/Bank_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Bank_account_YN_Dashboard").html(data);                        
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Bank_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Bank_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bank_account_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='BankTypeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/BankTypeWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Bank_type_wise_Dashboard").html(data);                        
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='BankTypeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/BankTypeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bank_type_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='WashroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/WashroomWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Washroom_wise_Dashboard").html(data);                        
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='WashroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/WashroomWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Washroom_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='BathroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/BathroomWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Bathroom_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='BathroomWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/BathroomWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Bathroom_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='LandWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/LandWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#LandWise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='LandWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/LandWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#LandWise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='LandDisputeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Village/LandDisputeWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Land_Dispute_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='LandDisputeWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/LandDisputeWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data)
                    {
                        $("#Land_Dispute_Dashboard").html(data);
                    }
                });
            }
        });
    });
</script>

<script>
    function Home_type()
    {        
        if($("input[name='Home_type_wise']:checked").val()=='N')
        {
            $("#HomeType_wise_Dashboard").hide();
        }
        else
        {
            $("#HomeType_wise_Dashboard").show();
        }
    }

    $("#Home_type_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Home_type_wise']:checked").val()=='Y') 
        {
            $.ajax({
                url: '/Taluka/Home_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#HomeType_wise_Dashboard").html(data);                        
                }
            });
        }
        
        if(talukaID>0 && $("input[name='Home_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/Home_type_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#HomeType_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Home_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Home_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#HomeType_wise_Dashboard").html(data);                        
                }
            });
        }
    });
</script>

<script>
    function Stove_type()
    {        
        if($("input[name='Stove_type_wise']:checked").val()=='N')
        {        
            $("#Stove_wise_Dashboard").hide();
        }
        else
        {            
            $("#Stove_wise_Dashboard").show();
        }
    }

    $("#Stove_type_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Stove_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Stove_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Stove_wise_Dashboard").html(data);                        
                }
            });
        }

        if(talukaID>0 && $("input[name='Stove_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/Stove_type_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Stove_wise_Dashboard").html(data);                        
                }
            });
        }
        else if(talukaID == 0 && $("input[name='Stove_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Stove_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Stove_wise_Dashboard").html(data);                        
                }
            });
        }
    });
</script>

<script>
    function Income_source()
    {
        if($("input[name='Income_source_wise']:checked").val()=='N')
        {
            $("#Income_source_wise_Dashboard").hide();
        }
        else
        {         
            $("#Income_source_wise_Dashboard").show();
        }
    }

    $("#Income_source_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Income_source_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Income_source_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Income_source_wise_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='Income_source_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/Income_source_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Income_source_wise_Dashboard").html(data);                        
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Income_source_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Income_source_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Income_source_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Bank_account_YN()
    {        
        if($("input[name='Bank_YN']:checked").val()=='N')
        {
            $("#Bank_account_YN_Dashboard").hide();
        }
        else
        {
            $("#Bank_account_YN_Dashboard").show();
        }
    }

    $("#Bank_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='Bank_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Bank_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bank_account_YN_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Bank_YN']:checked").val()=='Y')
        {

            $.ajax({
                url: '/Village/Bank_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Bank_account_YN_Dashboard").html(data);                        
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Bank_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Bank_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bank_account_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Bank_Type()
    {        
        if($("input[name='BankTypeWise']:checked").val()=='N')
        {
            $("#Bank_type_wise_Dashboard").hide();
        }
        else
        {
            $("#Bank_type_wise_Dashboard").show();
        }
    }

    $("#BankTypeWise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='BankTypeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/BankTypeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bank_type_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='BankTypeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/BankTypeWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Bank_type_wise_Dashboard").html(data);                        
                }
            });
        }

        else if(talukaID == 0 && $("input[name='BankTypeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/BankTypeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bank_type_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Washroom()
    {
        if($("input[name='WashroomWise']:checked").val()=='N')
        {     
            $("#Washroom_wise_Dashboard").hide();
        }
        else
        {
            $("#Washroom_wise_Dashboard").show();
        }
    }

    $("#WashroomWise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='WashroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/WashroomWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Washroom_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='WashroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/WashroomWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Washroom_wise_Dashboard").html(data);                        
                }
            });
        }

        else if(talukaID == 0 && $("input[name='WashroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/WashroomWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Washroom_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Bathroom()
    {
        if($("input[name='BathroomWise']:checked").val()=='N')
        {
            $("#Bathroom_wise_Dashboard").hide();
        }
        else
        {         
            $("#Bathroom_wise_Dashboard").show();
        }
    }

    $("#BathroomWise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='BathroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/BathroomWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bathroom_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='BathroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/BathroomWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Bathroom_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='BathroomWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/BathroomWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Bathroom_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Land()
    {
        if($("input[name='LandWise']:checked").val()=='N')
        {
            $("#LandWise_Dashboard").hide();
        }
        else
        {
            $("#LandWise_Dashboard").show();
        }
    }

    $("#LandWise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();

        if(district && $("input[name='LandWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/LandWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#LandWise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='LandWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/LandWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#LandWise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='LandWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/LandWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#LandWise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Land_Dispute()
    {
        if($("input[name='LandDisputeWise']:checked").val()=='N')
        {
            $("#Land_Dispute_Dashboard").hide();
        }
        else
        {
            $("#Land_Dispute_Dashboard").show();
        }
    }

    $("#LandDisputeWise").click(function(e)
    {
        var talukaID = $("#taluka").val();   
        var district = $("#district").val();
        if(district && $("input[name='LandDisputeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/LandDisputeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Land_Dispute_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='LandDisputeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Village/LandDisputeWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Land_Dispute_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='LandDisputeWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/LandDisputeWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#Land_Dispute_Dashboard").html(data);
                }
            });
        }
    });
</script>