<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new Access') }}
        </h2>
        <script src="http://parsleyjs.org/dist/parsley.js"></script>        
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <form data-parsley-validate id="validate_form" name="validate_form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label for="Role">Select Role:</label>                        
                            <select name="role_id" id="role_id" class="form-control input dynamic" data-dependent="state" required data-dependent="Action_id">
                            <option value="">Select role</option>
                                @foreach($role as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <br>

                        <label for="access_permission" name="Action_id">Select Access Permission:</label>
                            
                        <table class="table table-striped text-center table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th width="20%" scope="col" class=""></th>
                                        @foreach($act as $act1)
                                            <th class="" width="20%" scope="col">{{$act1->name}}</th>
                                        @endforeach
                                </tr>
                                @foreach ($page as $page1)
                                    <tr class="font-bold">
                                        <td class="">{{$page1->name}}</td>
                                            @foreach($act as $act1)
                                                <td><input class="checkbox-inline" type="checkbox" name="Action_id[]" value="{{$page1->id}}_{{$act1->id}}" aria-label="Checkbox for following text input"></td>                                                
                                            @endforeach
                                    </tr>
                                @endforeach
                            </thead>                                
                        </table>

                        <x-jet-button class="ml-4">
                            {{ __('Submit') }}
                        </x-jet-button>
                </form>
            </div>
        </div>
    </div>    
</x-app-layout>

<script type="text/javascript">
$( document ).ready(function() 
{
    $('#role_id').change(function() 
    {
        var roleid = $('#role_id').val();
        $.ajax({
            url: "/Access/getRoleACL/"+roleid,
            type:'GET',
            success: function(data) 
            {
                $('input[name="Action_id[]"]').prop('checked', false);
                if(data != '')
                {
                    obj = JSON.parse(data);
                    if($.isEmptyObject(data.error))
                    {
                        $.each($("input[name='Action_id[]']"), function() 
                        {
                            for(var i=0;i<obj.length;i++)
                            {
                                if(obj[i] == $(this).val())
                                {
                                    $(this).prop('checked', true);
                                }
                            }
                        });
                    }
                    else
                    {
                        printErrorMsg(data.error);
                    }
                }
            }
        });
    });
});
</script>