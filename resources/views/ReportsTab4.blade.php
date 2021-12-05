<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ज्येष्ठांकडे असलेल्या कागदपत्रांचे Reports') }}
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
                        <label for="RationCardYN">Ration Card Yes/No report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="RationCardYN" onchange="Ration_Card_YN()" value="Y" name="RationCardYN" class="custom-control-input">
                            <label class="custom-control-label" for="RationCardYN">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="RationCardYN2" onchange="Ration_Card_YN()" value="N" name="RationCardYN" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="RationCardYN2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="RationCardYN_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="RationCardWise">Ration Card Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="RationCard" onchange="Ration()" value="Y" name="RationCard" class="custom-control-input">
                            <label class="custom-control-label" for="RationCard">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="RationCard2" onchange="Ration()" value="N" name="RationCard" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="RationCard2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="RationCard_Type_Wise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="AadharWise">Aadhar card wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="AadharWise" onchange="Aadhar()" value="Y" name="AadharWise" class="custom-control-input">
                            <label class="custom-control-label" for="AadharWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="AadharWise2" onchange="Aadhar()" value="N" name="AadharWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="AadharWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="AadharWise_Dashboard">
                        
                    </div>

                    <br>                    

                    <div style="background-color:#f16c21;color:white">
                        <label for="AadharDiscrepancyWise">Aadhar card Discrepancy wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="AadharDiscrepancyWise" onclick="AadharDiscrepancy()" value="Y" name="AadharDiscrepancyWise" class="custom-control-input">
                            <label class="custom-control-label" for="AadharDiscrepancyWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="AadharDiscrepancyWise2" onclick="AadharDiscrepancy()" value="N" name="AadharDiscrepancyWise" class="custom-control-input"checked>
                            <label  class="custom-control-label" for="AadharDiscrepancyWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="AadharDiscrepancyWise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="VoterIDWise">VoterID wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="VoterIDWise" onclick="VoterID()" value="Y" name="VoterIDWise" class="custom-control-input">
                            <label class="custom-control-label" for="VoterIDWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="VoterIDWise2" onclick="VoterID()" value="N" name="VoterIDWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="VoterIDWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="VoterIDWise_Dashboard">
                        
                    </div>

                    <br>

                    <div style="background-color:#f16c21;color:white">
                        <label for="STPassWise">ST Pass Wise report</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">		
                            <input type="radio" id="STPassWise" onclick="STPass()" value="Y" name="STPassWise" class="custom-control-input">
                            <label class="custom-control-label" for="STPassWise">Show</label>
                        </div>	
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="STPassWise2" onclick="STPass()" value="N" name="STPassWise" class="custom-control-input" checked>
                            <label  class="custom-control-label" for="STPassWise2">Hide</label>
                        </div>
                    </div>

                    <br>

                    <div id="STPassWise_Dashboard">
                        
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
            window.location = "/Reports/tab5";
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
            if(district && $("input[name='RationCardYN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/RationCardYN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#RationCardYN_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='RationCard']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/RationCard/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#RationCard_Type_Wise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='AadharWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/AadharWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#AadharWise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/AadharDiscrepancyWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#AadharDiscrepancyWise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='VoterIDWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/VoterIDWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#VoterIDWise_Dashboard").html(data);
                    }
                });
            }

            if(district && $("input[name='STPassWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/Taluka/STPassWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#STPassWise_Dashboard").html(data);
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
            
            if(talukaID>0 && $("input[name='RationCardYN']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/RationCardYN/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#RationCardYN_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='RationCardYN']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/RationCardYN/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#RationCardYN_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='RationCard']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/RationCard/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#RationCard_Type_Wise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='RationCard']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/RationCard/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#RationCard_Type_Wise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='AadharWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/AadharWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#AadharWise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='AadharWise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/AadharWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#AadharWise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/AadharDiscrepancyWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#AadharDiscrepancyWise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
            {
                 $.ajax({
                    url: '/Taluka/AadharDiscrepancyWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#AadharDiscrepancyWise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='VoterIDWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/VoterIDWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#VoterIDWise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='VoterIDWise']:checked").val()=='Y')
            {
                    $.ajax({
                    url: '/Taluka/VoterIDWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#VoterIDWise_Dashboard").html(data);
                    }
                });
            }

            if(talukaID>0 && $("input[name='STPassWise']:checked").val()=='Y')
            {
                $.ajax({
                    url: '/village/STPassWise/'+talukaID,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {
                        $("#STPassWise_Dashboard").html(data);
                    }
                });
            }

            else if(talukaID == 0 && $("input[name='STPassWise']:checked").val()=='Y')
            {
                    $.ajax({
                    url: '/Taluka/STPassWise/'+district,
                    type: "GET",
                    dataType: "html",
                    success:function(data) 
                    {     
                        $("#STPassWise_Dashboard").html(data);
                    }
                });
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
    function Ration_Card_YN()
    {
        if($("input[name='RationCardYN']:checked").val()=='N')
        {
            $("#RationCardYN_Dashboard").hide();
        }
        else
        {         
            $("#RationCardYN_Dashboard").show();
        }
    }

    $("#RationCardYN").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();
        
        if(district && $("input[name='RationCardYN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/RationCardYN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#RationCardYN_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='RationCardYN']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/RationCardYN/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#RationCardYN_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='RationCardYN']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/RationCardYN/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#RationCardYN_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Ration()
    {
        if($("input[name='RationCard']:checked").val()=='N')
        {
            $("#RationCard_Type_Wise_Dashboard").hide();
        }
        else
        {
            $("#RationCard_Type_Wise_Dashboard").show();
        }
    }

    $("#RationCard").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='RationCard']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/RationCard/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#RationCard_Type_Wise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='RationCard']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/RationCard/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#RationCard_Type_Wise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='RationCard']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/RationCard/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#RationCard_Type_Wise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function Aadhar()
    {
        if($("input[name='AadharWise']:checked").val()=='N')
        {
            $("#AadharWise_Dashboard").hide();
        }
        else
        {     
            $("#AadharWise_Dashboard").show();
        }
    }

    $("#AadharWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='AadharWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/AadharWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#AadharWise_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='AadharWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/AadharWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#AadharWise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='AadharWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/AadharWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#AadharWise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function AadharDiscrepancy()
    {
        //alert($("input[name='WashroomWise']:checked").val());
        if($("input[name='AadharDiscrepancyWise']:checked").val()=='N')
        {
            //alert("Hide");
            $("#AadharDiscrepancyWise_Dashboard").hide();
        }
        else
        {
            //alert("Show");
            $("#AadharDiscrepancyWise_Dashboard").show();
        }
    }

    $("#AadharDiscrepancyWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/AadharDiscrepancyWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#AadharDiscrepancyWise_Dashboard").html(data);
                }
            });
        }
        
        if(talukaID>0 && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/AadharDiscrepancyWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#AadharDiscrepancyWise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='AadharDiscrepancyWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/AadharDiscrepancyWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#AadharDiscrepancyWise_Dashboard").html(data);
                }
            });
        }

        
    });
</script>

<script>
    function VoterID()
    {
        if($("input[name='VoterIDWise']:checked").val()=='N')
        {
            $("#VoterIDWise_Dashboard").hide();
        }
        else
        {         
            $("#VoterIDWise_Dashboard").show();
        }
    }

    $("#VoterIDWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='VoterIDWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/VoterIDWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#VoterIDWise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='VoterIDWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/VoterIDWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#VoterIDWise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='VoterIDWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/VoterIDWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#VoterIDWise_Dashboard").html(data);
                }
            });
        }
    });
</script>

<script>
    function STPass()
    {
        if($("input[name='STPassWise']:checked").val()=='N')
        {     
            $("#STPassWise_Dashboard").hide();
        }
        else
        {
            $("#STPassWise_Dashboard").show();
        }
    }

    $("#STPassWise").click(function(e)
    {
        var talukaID = $("#taluka").val();
        var district = $("#district").val();

        if(district && $("input[name='STPassWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/Taluka/STPassWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#STPassWise_Dashboard").html(data);
                }
            });
        }

        if(talukaID>0 && $("input[name='STPassWise']:checked").val()=='Y')
        {
            $.ajax({
                url: '/village/STPassWise/'+talukaID,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {
                    $("#STPassWise_Dashboard").html(data);
                }
            });
        }

        else if(talukaID == 0 && $("input[name='STPassWise']:checked").val()=='Y')
        {
                $.ajax({
                url: '/Taluka/STPassWise/'+district,
                type: "GET",
                dataType: "html",
                success:function(data) 
                {     
                    $("#STPassWise_Dashboard").html(data);
                }
            });
        }
    });
</script>