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

        <script src="http://parsleyjs.org/dist/parsley.js"></script>

        <form method="POST" data-parsley-validate action="/insert/user">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="role_id" value="{{ __('Register as:')}}"/>
                    <select name="role_id" id="role_id" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm" required>
                        <option value="">--- Select Role ---</option>
                        @foreach ($Role as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="district" value="{{ __('जिल्हा:')}}"/>
                    <select name="district" id="district" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm"required>
                        <option value="">--- जिल्हा ---</option>
                        @foreach ($district as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name_of_district }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="taluka" value="{{ __('तालुका:')}}"/>
                    <select name="taluka" id="taluka" class="block mt-1 w-full border-gray-300
                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                        focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">--- तालुका ---</option>
                    </select>
            </div>
            
            <x-jet-button class="ml-4">
                {{ __('Submit') }}
            </x-jet-button>
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
                        $('select[name="taluka"]').append('<option value="">--- तालुका --- </option>');
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

<script>
    $("#role_id").change(function()
    {
        if($("#role_id").val() == '4')
        {
            $('#taluka').attr('required', 'required');
        }
        else
        {
            $('#taluka').removeAttr('required');
        }
        if($("#role_id").val() == '3' || $("#role_id").val() == '4' )
        {
            $('#district').attr('required', 'required');
        }
        else
        {
            $('#district').removeAttr('required');
        }
    });

    
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