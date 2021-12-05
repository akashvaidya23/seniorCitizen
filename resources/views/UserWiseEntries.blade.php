<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Wise Entries') }}
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
                        
                    <br> 
                    
                    <div id="District_wise_Entries">
                        @php
                            $count = 0;
                            $countI = 0;
                        @endphp
                        @foreach($userCount as $item)
                            @php
                                $count = $count + $item->total;
                            @endphp
                        @endforeach
                        @foreach($Incomplete_Entries as $ItemI)
                            @php
                                $countI = $countI + $ItemI->total;
                            @endphp
                        @endforeach
                        @php
                            $i = 1;
                        @endphp
                        <table class="table table-bordered border-dark text-center">
                            </script>
                                <tr style="background-color:#0d3d54;color:white">
                                    <td class="fw-bolder">Sr.No</td>
                                    <td class="fw-bolder">Name of the user</td>
                                    <td class="fw-bolder">No of Entries</td>
                                    <td class="fw-bolder">No of Incomplete Entries</td>
                                </tr>
                                <tr style="background-color:#d9d9d9;">
                                    <td  class="fw-bolder" scope="row">-</td>
                                    <td  class="fw-bolder">Total</td>
                                    <td  class="fw-bolder">{{$count}}</td>
                                    <td  class="fw-bolder">{{$countI}}</td>
                                </tr>
                                @foreach($userCount as $item)
                                            <tr>
                                                <td scope="row">{{ $i }}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->total}}</td>
                                                @php
                                                    $Flag = False;
                                                @endphp
                                                @foreach($Incomplete_Entries as $I)
                                                    @if($item->id == $I->UID)
                                                    @php
                                                        $Flag = True;
                                                    @endphp
                                                    <td>{{$I->total}}</td>
                                                    @endif
                                                @endforeach
                                                    @if($Flag == False)
                                                        <td>0</td>                                        
                                                    @endif
                                            </tr>    
                                                @php
                                                    $i++;
                                                @endphp
                                        @endforeach
                            </script>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- <script type="text/javascript">
    $(document).ready(function() 
    {
        $('select[name="district"]').on('change', function() 
        {            
            var districtID = $(this).val();
            //alert (districtID);
            if(districtID) 
            {
                //alert("No");
                $.ajax({
                    url: '/Entries/District/'+districtID,
                    type: "GET",
                    dataType: "html",
                    success:function(result)
                    {
                        $("#District_wise_Entries").html(result);
                        $.each(data, function(key, value) 
                        {
                            $('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('select[name="district"]').append('<option value="0">--- All ---</option>'); 
            }
        });
    });
</script> -->

<script type="text/javascript">
    $("#district").change(function() 
    {
        var districtID = $(this).val();
        if(districtID) 
        {
            $.ajax({
                url: '/Entries/District/'+districtID,
                type: "GET",
                dataType: "html",
                success:function(data)
                {
                    $("#District_wise_Entries").html(data);
                }
            });  
        }
        else
        {  
            $("#display").empty();
        }
    });
</script>
