<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('आपल्या कुटुंबातील सदस्य व त्यांचे व्यवसाय ') }}
        </h2>
    </x-slot>
    
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
      .table-bordered td, .table-bordered th{border: 1px solid black;}
   </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" text="center">
                <form id="validate_form" data-parsley-validate action="#" method="POST">
                    @csrf     
                    
                    <input type="hidden" id="id" name="id" value="">
                    <div style="color:red" id="log"></div>
                        <div class="col-6">
                            <x-jet-label for="name_of_member" value="{{ __('सदस्याचे नाव') }}" />
                            <x-jet-input id="name_of_member" class="block mt-1 w-full" type="text" name="name_of_member" :value="old('name_of_member')" required autofocus />
                        </div>
                    
                        <br>

                        <div class="col-6">
                            <x-jet-label for="Relation" value="{{ __('नाते') }}" />
                            <select name="Relation" id="Relation" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                        <option value="">नाते</option>
                                        @foreach ($relations as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->type_of_relation }}</option>
                                        @endforeach
                            </select>
                        </div>
                        
                        <br>

                        <div class="col-6">
                            <x-jet-label for="occupation" value="{{ __('व्यवसाय') }}" />
                            <x-jet-input id="occupation" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation')" required autofocus />
                        </div>
                        
                        <br>
                        
                        <div class="col-6">
                            <x-jet-label for="lives_with_you" value="{{ __('आपल्या सोबत राहणाऱ्या') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="lives_with_you_Y" value="Y" name="lives_with_you" class="custom-control-input" required>
                                <label class="custom-control-label" for="lives_with_you_Y">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="lives_with_you_N" value="N" name="lives_with_you" class="custom-control-input" checked>
                                <label class="custom-control-label" for="lives_with_you_N">नाही</label>
                            </div>
                        </div>
                        
                        <br>

                        <div class="col-6">
                            <x-jet-label for="Mobile_no" value="{{ __('मोबाईल नं.') }}" />
                            <x-jet-input id="Mobile_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="Mobile_no" :value="old('Mobile_no')" required autofocus />
                        </div>
                        
                        <br>

                        <x-jet-button id="submit" name="submit" class="ml-4">
                            {{ __('Submit') }}
                        </x-jet-button>      
                        
                        <x-jet-button id="Next_Page" name="Next_Page" class="ml-4">
                            {{ __('Next Page') }}
                        </x-jet-button>   

                        <x-jet-button id="Previous_page" name="Previous_page" class="ml-4">
                            {{ __('Previous Page') }}
                        </x-jet-button> 
                            
                </form>        
            </div>

            <br><br>

            <div id="MemberList">
                <table class="table table-striped table-bordered border-dark text-center">
                    <tr>
                        <td class="fw-bolder">Sr.No</td>
                        <td class="fw-bolder">सदस्याचे नाव</td>
                        <td class="fw-bolder">नाते</td>
                        <td class="fw-bolder">व्यवसाय</td>
                        <td class="fw-bolder">आपल्या सोबत राहतात का?</td>
                        <td class="fw-bolder">मोबाईल नं.</td>
                        <td class="fw-bolder">Action</td>
                    </tr>
                    @php
                        $i=1
                    @endphp

                    @foreach($c as $item)
                        <tr id="{{$item->id}}">
                            <td scope="row">{{$i}}</td>
                            <td>{{$item->name_of_member}}</td>
                            <td>{{$item->type_of_relation}}</td>
                            <td>{{$item->occupation}}</td>
                            <td>
                                @if($item->lives_with_you == 'Y')
									होय
                                @else
									नाही
                                @endif       
                                </td>
                            <td>{{$item->Mobile_no}}</td>
                            <td>
                                <a href="#" class="btn btn-danger" id="Deletemember" onClick="DeleteMember('{{$item->id}}')" >Delete</a>
                                <a href="#" class="btn btn-primary" onClick="onEdit('{{$item->id}}','{{$item->name_of_member}}','{{$item->Relation}}',
                                    '{{$item->occupation}}','{{$item->lives_with_you}}','{{$item->Mobile_no}}')">Edit</a>
                            </td>
                        </tr> 
                        @php
                            $i++
                        @endphp
                    @endforeach
                </table>
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var id = $("#id").val();
    var name_of_member = $("#name_of_member").val();
    var Relation = $("#Relation").val();
    var occupation = $("#occupation").val();
    var lives_with_you = $("input[name='lives_with_you']:checked").val();
    var Mobile_no = $("#Mobile_no").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/citizen/tab2/insert',
            data:
            {
                id:id,name_of_member:name_of_member, Relation:Relation, occupation:occupation, 
                lives_with_you:lives_with_you, Mobile_no:Mobile_no, _token: '{{csrf_token()}}',
            },
            method: 'POST',
            success:function(result)
            {
                $("#id").val('');
                $("#MemberList").html(result);
                jQuery("#validate_form")['0'].reset();  
            }
        });
    }
});
</script>

<script>
jQuery("#Previous_page").click(function(e)
{
    jQuery.ajax({
        success:function(result)
        {
            window.location = "/citizen/tab1/0";
        }
    });
});
</script>

<script>
jQuery("#Next_Page").click(function(e)
{
    jQuery.ajax({
        success:function(result)
        {
            window.location = "/citizen/tab3/";
        }
    });
});
</script>

<script>
    function onEdit(id,name_of_member,Relation,occupation,lives_with_you,Mobile_no)
    {
        $("#id").val(id);
        $("#name_of_member").val(name_of_member);
        $("#Relation").val(Relation);
        $("#occupation").val(occupation);
        $('#lives_with_you_'+lives_with_you).prop('checked',true);   
        $("#Mobile_no").val(Mobile_no);
    }
</script>

<script>
    function DeleteMember(id)
    {
        var a = confirm("Do you want to delete this record?");
        if (a == true) 
        {
            $.ajax(
            {
                url: '/delete/member/'+id,
                data:
                {
         
                },
                success:function(response)
                {
                    $("#MemberList").html(response);
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