<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of the citizens') }}
        </h2>
    </x-slot>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div id="log"></div>
                <form id="validate_form" data-parsley-validate action="/search" method="POST">
                    @csrf
                    <input type="text" name="searchReferenceNo" id="searchReferenceNo" placeholder="Search by reference no" style="display:inline">                    
                    <button type="submit" id="Search" class="btn btn-dark">Search</button>

                    <br><br><br>
                    <div id="Citizens">
                        <table class="table table-striped table-bordered border-dark text-center">
                        
                            <tr>
                                <td class="fw-bolder">Sr.No</td>
                                <td class="fw-bolder">Reference No</td>
                                <td class="fw-bolder">संपूर्ण नाव</td>
                                <td class="fw-bolder">जन्मतारीख</td>
                                <td class="fw-bolder">मोबाईल नंबर</td>
                                <td class="fw-bolder">Action</td>
                            </tr>
                        
                            @foreach($details_of_citizens as $item)
                                <tr id="{{$item->id}}">
                                    <td scope="row">{{ $details_of_citizens->firstItem()+$loop->index }}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->Full_name}}</td>
                                    <td>{{date('d-M-Y', strtotime($item->date_of_birth))}}</td>
                                    <td>{{$item->Mobile_no}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{"/citizen/tab1/".$item->id}}" >Edit</a>
                                        <a class="btn btn-danger" href="#" onclick="Delete('{{$item->id}}')">Delete</a>
                                    </td>
                                </tr> 
                            @endforeach
                        </table>                                
                    </div>
                    <span>
                        {{$details_of_citizens->links()}}
                    </span>
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
        var searchName = $("#searchName").val();
        var searchMobileNo = $("#searchMobileNo").val();
        var district = $("#district").val();
        var taluka = $("#taluka").val();
        var village = $("#village").val();
        $.ajax(
        {
            url: '/search',
            data:
            {
                searchReferenceNo:searchReferenceNo, searchName:searchName, searchMobileNo:searchMobileNo,
                district:district, taluka:taluka, village:village, _token: '{{csrf_token()}}',
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
    function Delete(id)
    {
        var a = confirm("Do you want to delete this record?");
        if (a == true) 
        {
            $.ajax(
            {
                url: '/delete/'+id,
                data:
                {
         
                },
                success:function(response)
                {
                    $("#Citizens").html(response);
                    alert("Data Deleted successfully.");
                }
            });
        }
        else
        {
            return false;
        }      
    }
</script>