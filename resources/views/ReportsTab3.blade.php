<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('आरोग्य विषयक माहिती चे Reports') }}
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
        
        .sticky-col 
        {
            position: -webkit-sticky;
            position: sticky;
        }
        .table
        {
            width: 100%;
        }
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
                        <label for="CheckupWise">Regular check-up Yes/No report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="CheckupWise" value="Y" onclick="CheckUp()" name="CheckupWise" class="custom-control-input">
                            <label class="custom-control-label" for="CheckupWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="CheckupWise2" value="N" onclick="CheckUp()" name="CheckupWise" class="custom-control-input"checked>
                            <label  class="custom-control-label" for="CheckupWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Regular_CheckUp_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="disease_YN">Disease YN report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="disease_YN" onclick="DiseaseYN()" value="Y" name="disease_YN" class="custom-control-input">
                            <label class="custom-control-label" for="disease_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="disease_YN2" onclick="DiseaseYN()" value="N" name="disease_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="disease_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Disease_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="diseaseWise">Disease wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="diseaseWise" onclick="diseaseW()" value="Y" name="diseaseWise" class="custom-control-input">
                            <label class="custom-control-label" for="diseaseWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="diseaseWise2" onclick="diseaseW()" value="N" name="diseaseWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="diseaseWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Disease_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Hospital_type_wise">Hospital type wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Hospital_type_wise" onclick="Hospital_type()" value="Y" name="Hospital_type_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Hospital_type_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Hospital_type_wise2" onclick="Hospital_type()" value="N" name="Hospital_type_wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Hospital_type_wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Hospital_type_wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Handicap_YN">Handicap YN report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Handicap_YN" onclick="HandicapYN()" value="Y" name="Handicap_YN" class="custom-control-input">
                            <label class="custom-control-label" for="Handicap_YN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Handicap_YN2" onclick="HandicapYN()" value="N" name="Handicap_YN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Handicap_YN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Handicap_YN_Dashboard">
                    
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Handicap_wise">Handicap wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Handicap_wise" onclick="Handicap()" value="Y" name="Handicap_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Handicap_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Handicap_wise2" value="N" onclick="Handicap()" name="Handicap_wise" class="custom-control-input"checked>
                            <label  class="custom-control-label" for="Handicap_wise2">Hide</label>
                        </div>
                    </div>

                    <br>                    

                    <div id="Handicap_wise_Dashboard" style="overflow:scroll;" class="table-scroll">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="Chores_wise">Chores wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="Chores_wise" onclick="Chores()" value="Y" name="Chores_wise" class="custom-control-input">
                            <label class="custom-control-label" for="Chores_wise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="Chores_wise2" onclick="Chores()" value="N" name="Chores_wise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="Chores_wise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="Chores_wise_Dashboard">
                        
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
            window.location = "/Reports/tab4";
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

<script>
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {
            var district = $("#district").val();
            if(district && $("input[name='CheckupWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/CheckupWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Regular_CheckUp_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='disease_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/disease_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Disease_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='diseaseWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/diseaseWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Disease_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Hospital_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Hospital_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Hospital_type_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Handicap_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Handicap_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Handicap_YN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Handicap_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Handicap_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Handicap_wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='Chores_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/Chores_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Chores_wise_Dashboard").html(data);
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
            
            if(talukaID>0 && $("input[name='CheckupWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/CheckupWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Regular_CheckUp_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='CheckupWise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/CheckupWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Regular_CheckUp_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='disease_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/disease_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Disease_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='disease_YN']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/disease_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Disease_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='diseaseWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/diseaseWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Disease_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='diseaseWise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/diseaseWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Disease_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Hospital_type_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Hospital_type_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Hospital_type_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Hospital_type_wise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/Hospital_type_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Hospital_type_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Handicap_YN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Handicap_YN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Handicap_YN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Handicap_YN']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/Handicap_YN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Handicap_YN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Handicap_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Handicap_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Handicap_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Handicap_wise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/Handicap_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Handicap_wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='Chores_wise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/Chores_wise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#Chores_wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='Chores_wise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/Chores_wise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#Chores_wise_Dashboard").html(data);
                    }
                });
            }
        });
    });
</script>

<script>
    function CheckUp()
    {
        if($("input[name='CheckupWise']:checked").val()=='N')
        {
            $("#Regular_CheckUp_Dashboard").hide();
        }
        else
        {
            $("#Regular_CheckUp_Dashboard").show();
        }
    }

    $("#CheckupWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        
        if(district && $("input[name='CheckupWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/CheckupWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Regular_CheckUp_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='CheckupWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/CheckupWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Regular_CheckUp_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='CheckupWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/CheckupWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Regular_CheckUp_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function DiseaseYN()
    {
        if($("input[name='disease_YN']:checked").val()=='N')
        {
            $("#Disease_YN_Dashboard").hide();
        }
        else
        {
            $("#Disease_YN_Dashboard").show();
        }
    }

    $("#disease_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='disease_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/disease_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Disease_YN_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='disease_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/disease_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Disease_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='disease_YN']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/disease_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Disease_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function diseaseW()
    {
        if($("input[name='diseaseWise']:checked").val()=='N')
        {
            $("#Disease_wise_Dashboard").hide();
        }
        else
        {
            $("#Disease_wise_Dashboard").show();
        }
    }

    $("#diseaseWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        if(district && $("input[name='diseaseWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/diseaseWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Disease_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='diseaseWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/diseaseWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Disease_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='diseaseWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/diseaseWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Disease_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Hospital_type()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='Hospital_type_wise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#Hospital_type_wise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#Hospital_type_wise_Dashboard").show();
        }
    }

    $("#Hospital_type_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        
        if(district && $("input[name='Hospital_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Hospital_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Hospital_type_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Hospital_type_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Hospital_type_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Hospital_type_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Hospital_type_wise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/Hospital_type_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Hospital_type_wise_Dashboard").html(data);
                }
            });
        }

    });
</script>

<script>
    function HandicapYN()
    {
        if($("input[name='Handicap_YN']:checked").val()=='N')
        {
            $("#Handicap_YN_Dashboard").hide();
        }
        else
        {
            $("#Handicap_YN_Dashboard").show();
        }
    }

    $("#Handicap_YN").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        if(district && $("input[name='Handicap_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Handicap_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Handicap_YN_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Handicap_YN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Handicap_YN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Handicap_YN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Handicap_YN']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/Handicap_YN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Handicap_YN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Handicap()
    {
        if($("input[name='Handicap_wise']:checked").val()=='N')
        {
            $("#Handicap_wise_Dashboard").hide();
        }
        else
        {
            $("#Handicap_wise_Dashboard").show();
        }
    }

    $("#Handicap_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        if(district && $("input[name='Handicap_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Handicap_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Handicap_wise_Dashboard").html(data);
                }
            });
        }
        if(talukaID>0 && $("input[name='Handicap_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Handicap_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Handicap_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Handicap_wise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/Handicap_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Handicap_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Chores()
    {
        if($("input[name='Chores_wise']:checked").val()=='N')
        {
            $("#Chores_wise_Dashboard").hide();
        }
        else
        {         
            $("#Chores_wise_Dashboard").show();
        }
    }

    $("#Chores_wise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        if(district && $("input[name='Chores_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/Chores_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Chores_wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='Chores_wise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/Chores_wise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#Chores_wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='Chores_wise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/Chores_wise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#Chores_wise_Dashboard").html(data);
                }
            });
        }
    });
</script>