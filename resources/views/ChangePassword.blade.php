<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Password') }}
        </h2>
    </x-slot>
    
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <form id="validate_form" data-parsley-validate action="{{url('/insert/Password/'.$user->id)}}" method="POST">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('New Password') }}" />
                    <x-jet-input id="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" class="block mt-1" type="password" 
                    name="password" required data-required-message="Please insert your name" />
                    <label for="password_pattern">Password must contain at least 1 uppercase letter, 1 lower case letter, 1 number and 1 special character.</label>
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirm New Password') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1" type="password" name="password_confirmation" required data-parsley-equalto="#password" />
                <!-- <span id="confirm_password_msg"></span> -->
                </div>

                <br>

                <x-jet-button class="ml-4">
                    {{ __('Submit') }}
                </x-jet-button>                    

            </form>        
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var password = $("#password").val();
    var id = $("#id").val();    
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/insert/Password/'+id,
            data:
            {
                password:password, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {
                alert("Password updated successfully");
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
    $(document).ready(function()
    { 
        $("#password").focus();
    });
</script>