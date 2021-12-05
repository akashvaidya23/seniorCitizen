<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Incomplete Entries') }}
        </h2>
    </x-slot>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
        .search 
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
            <div id="log"></div>
                <form id="validate_form" data-parsley-validate action="#" method="POST">
                    @csrf
                    <div id = "search" style="display:inline">
                        <div class="dropdown dropdown-btn" style="display:block;align-content:space-between">    
                            <input type="text" name="searchReferenceNo" id="searchReferenceNo" placeholder="Search by reference no" style="display:inline">                    
                            <button type="submit" id="Search" class="btn btn-dark" style="display:inline">Search</button>

                            <div style="display:inline;margin-left:100px">
                                <label for="village" style="display:inline">गाव</label>            
                                <select name="village" id="village" class="block mt-1 border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" style="display:inline">
                                    <option value="0">--- Select Village ---</option>
                                    @foreach ($village as $key)    
                                        @if($key->id == $Village)
                                            <option value="{{ $key->id }}"selected>{{ $key->name_of_village }}</option>
                                        @else
                                            <option value="{{ $key->id }}">{{ $key->name_of_village }}</option>
                                        @endif
                                    @endforeach
                                </select>       
                            </div>
                        </div>
                    </div>

                    <br><br><br>
                    <div id="Citizens">
                        <table class="table table-striped table-bordered border-dark text-center">
                        @php
                            $i=1;
                        @endphp
                            <tr>
                                <td class="fw-bolder">Sr.No</td>
                                <td class="fw-bolder">Reference No</td>
                                <td class="fw-bolder">संपूर्ण नाव</td>
                                <td class="fw-bolder">जन्मतारीख</td>
                                <td class="fw-bolder">मोबाईल नंबर</td>
                                <td class="fw-bolder">गाव</td>
                                <td class="fw-bolder">Action</td>
                            </tr>
                        
                            @foreach($details_of_citizens as $item)
                                <tr id="{{$item->id}}">
                                    <td scope="row">{{ $i }}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->Full_name}}</td>
                                    <td>{{date('d-M-Y', strtotime($item->date_of_birth))}}</td>
                                    <td>{{$item->Mobile_no}}</td>
                                    <td>{{$item->name_of_village}}</td>
                                    <td>
                                        <a href="{{"/citizen/tab1/".$item->id}}" >Edit</a>
                                    </td>
                                </tr> 
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </table>
                        </div>
                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
    $("body").on("click","#Search",function(e)
    {
        e.preventDefault();
        var searchReferenceNo = $("#searchReferenceNo").val();
        $.ajax(
        {
            url: '/search/incomplete',
            data:
            {
                searchReferenceNo:searchReferenceNo, _token: '{{csrf_token()}}',
            },
            type: 'POST',
            success:function(response)
            {
                $("#Citizens").html(response);
            }
        });   
    });
</script>

<script>
    $('select[name="village"]').on('change', function()
    {
        var village = $(this).val();
        $.ajax(
        {
            url: '/search/incompleteRecords/'+village,
            data:
            {
                village:village, _token: '{{csrf_token()}}',
            },
            type: 'POST',
            success:function(response)
            {
                $("#Citizens").html(response);
            }
        });
    });
</script>