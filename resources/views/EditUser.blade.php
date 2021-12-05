<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
           
        </x-slot>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{url('/Update/user/'.$user->id)}}">
            @csrf

            <div class="mt-4">
                <label for="Name">Change name</label><br>
                <input type="text" name="name" id="name" class="w-full" value="{{$user['name']}}">
            </div>

            <div class="mt-4">
                <label for="email">Change Email</label><br>
                <input type="email" name="email" id="email" class="w-full" value="{{$user['email']}}" required>
            </div>
            
            <div class="mt-4">
                <label for="district">जिल्हा</label>
                    <select name="district" id="district" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">--- जिल्हा ---</option>
                        @foreach ($district as $key => $value)
                            @if(isset($c[0]->district_id) && $c[0]->district_id!='' && $c[0]->district_id == $value->id ) 
                                <option value="{{ $value->id }}" selected >{{ $value->name_of_district }}</option>
                            @else
                                <option value="{{ $value->id }}">{{ $value->name_of_district }}</option>
                            @endif
                        @endforeach
                    </select>
            </div>

            <div class="mt-4">
                <label for="taluka">तालुका</label>
                    <select name="taluka" id="taluka" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">--- तालुका ---</option>
                        @foreach ($taluka as $key => $value)
                            @if(isset($c[0]->taluka_id) && $c[0]->taluka_id!='' && $c[0]->taluka_id == $value->id )
                                <option value="{{ $value->id }}" selected>{{ $value->taluka_name }}</option>
                            @else
                                <option value="{{ $value->id }}">{{ $value->taluka_name }}</option>
                            @endif
                        @endforeach
                    </select>
            </div>

            <div class="mt-4">                           
               <label for="Ban_user">Shall I deactivate the user?</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    @if(isset($c[0]->Banned) && $c[0]->Banned == '1')
                    <input type="radio" id="Ban_user" value="1" name="Ban_user" class="custom-control-input" checked>
                    @else
                    <input type="radio" id="Ban_user" value="1" name="Ban_user" class="custom-control-input">
                    @endif
                    <label class="custom-control-label" for="Ban_user">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    @if(isset($c[0]->Banned) && $c[0]->Banned == '0')
                    <input type="radio" id="Ban_user_2" value="0" name="Ban_user" class="custom-control-input" checked>
                    @else
                    <input type="radio" id="Ban_user_2" value="0" name="Ban_user" class="custom-control-input" >
                    @endif
                    <label class="custom-control-label" for="Ban_user_2">No</label>
                </div>
            </div>

            <!-- <div> 
                <select id="Ban_user" name="Ban_user">
                    <option value="">Select Ban Status</option>
                    <option value="1" name="Deactivate">Deactivate</option>
                    <option value="0" name="Activate">Activate</option>
                </select>
            </div> -->

            <!-- <div class="mt-4">
                <label for="Ban_user">Select Ban Status</label>
                    <select name="Ban_user" id="Ban_user" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm" required>
                        <option value="">--- Ban Status ---</option>
                        <option value="1" name="Deactivate">Deactivate</option>
                        <option value="0" name="Activate">Activate</option>
                    </select>
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Submit') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
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
               
            }
        });
    });
    $("#taluka").trigger("change");
</script>

<!-- <script>
$(document).ready(function() 
    {
        $("#taluka").trigger("change");
        $('select[name="taluka"]').on('change', function() 
        {
            var talukaID = $(this).val();
            if(talukaID) 
            {
				$.ajax({
                    url: '/myform/myVillage/'+talukaID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) 
                    {                        
                        $('select[name="village"]').empty();
                        $('select[name="village"]').append('<option value="">Select</option>'); 
                        $.each(data, function(key, value)
                        {
                            $('select[name="village"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
				});
            }
            else
            {
                $('#village').empty();
            }
        });
    });
</script> -->