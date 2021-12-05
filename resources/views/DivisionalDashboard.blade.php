<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Entry Reports') }}
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

        a {
    text-decoration: none;
    }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" data-parsley-validate action="#" method="POST">
                    
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
                </form>
                <br><br>

                    
                <div id="List_Dashboard">
                    @php
                        $count = 0;
                        $countI = 0;
                    @endphp
                    @foreach($district_count as $item)  
                        @php
                            $count = $count + $item->total;
                        @endphp
                    @endforeach

                    @foreach($Incomplete_Entries as $I)
                        @php
                            $countI = $countI + $I->total;
                        @endphp
                    @endforeach
                
                    @php
                        $j = 1;
                    @endphp
                    <table class="table table-bordered border-dark text-center">
                        <tr style="background-color:#0d3d54;color:white">
                            <td class="fw-bolder">Sr.No</td>
                            <td class="fw-bolder">Name</td>
                            <td class="fw-bolder">Total No of Records</td>
                            <td class="fw-bolder">No of Incomplete Records</td>
                        </tr>
                        <tr style="background-color:#d9d9d9;">
                            <td  class="fw-bolder" scope="row">-</td>
                            <td  class="fw-bolder">Total</td>
                            <td  class="fw-bolder">{{$count}}</td>
                            <td  class="fw-bolder">{{$countI}}</td>
                        </tr> 
                        
                        @foreach($district_count as $item)
                            <tr style="background-color:white;">
                                <td scope="row">{{$j}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->total}}</td>
                                @php
                                    $Flag = False;
                                @endphp
                                @foreach($Incomplete_Entries as $I)
                                    @if($item->VID == $I->id)
                                        @php
                                            $Flag = True;
                                        @endphp
                                        @if(Auth::user()->role_id == 4)
                                            <td>
                                                <a href="all/Incomplete/{{$I->id}}">{{$I->total}}</a>
                                            </td>
                                        @else
                                            <td>{{$I->total}}</td>
                                        @endif
                                    @endif
                                @endforeach
                                    @if($Flag == False)
                                        <td>0</td>                                        
                                    @endif
                            </tr>    
                                @php
                                    $j++;
                                @endphp
                        @endforeach
                    </table>
                </div>
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
				alert('if');
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
                alert("else");
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
    $("#clickable").click(function()
    {
        alert("Akash");
    });
</script>
