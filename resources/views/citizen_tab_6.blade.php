<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('इतर माहिती') }}
        </h2>
    </x-slot>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <style>
    
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" data-parsley-validate action="/citizen/tab6/insert/" method="POST">
                    @csrf

                    <div>
                        <x-jet-label for="income_increase" value="{{ __('आपल्याला काही काम करून मिळकत वाढविण्याची इच्छा आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->income_increase) && $c[0]->income_increase == 'Y' )
                                <input type="radio" id="income_increase" onclick="scheme()" value="Y" name="income_increase" class="custom-control-input" checked required>
                            @else
                                <input type="radio" id="income_increase" onclick="scheme()" value="Y" name="income_increase" class="custom-control-input" required>
                            @endif
                                <label class="custom-control-label" for="income_increase">होय</label>
                        </div>
                        
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->income_increase) && $c[0]->income_increase == 'N' )
                                <input type="radio" id="income_increase2" value="N" onclick="scheme()" name="income_increase" class="custom-control-input" required checked>
                            @elseif($c[0]->income_increase == '0')
                                <input type="radio" id="income_increase2" value="N" onclick="scheme()" name="income_increase" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="income_increase2" value="N" onclick="scheme()" name="income_increase" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="income_increase2">नाही</label>
                        </div>
                    </div>
        
                    <br>
                    

                    @if(isset($c[0]->income_increase) && $c[0]->income_increase == 'Y')
                    <div id="Work_type_div">
                    @else
                    <div id="Work_type_div" style="display:none;">
                    @endif
                        <x-jet-label for="Work_type[]" value="{{ __('असल्यास कोणते?') }}" />
                        @php
                            $i=1
                        @endphp
                        @foreach ($work_type as $key => $value)
                            @if(in_array($value->id, $income_increase))
                                <li>
                                    <input name="Work_type[]" id="Work_type_{{$i}}" class="work" type="checkbox" checked value="{{ $value->id }}" data-parsley-errors-container="#checkbox-errors" >
                                    {{ $value->type_of_work }}
                                </li>
                            @else
                                <li>
                                    <input name="Work_type[]" id="Work_type_{{$i}}" class="work" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#checkbox-errors">
                                    {{ $value->type_of_work }}
                                </li>
                            @endif
                            @php
                                $i++
                            @endphp
                        @endforeach
                        <div id="checkbox-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="tools_required" value="{{ __('आपल्याला औजारांची गरज आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->tools_required) && $c[0]->tools_required == 'Y' )
                                <input type="radio" id="tools_required" onclick="tool()" value="Y" name="tools_required" class="custom-control-input" checked required>
                            @else
                                <input type="radio" id="tools_required" onclick="tool()" value="Y" name="tools_required" class="custom-control-input" required>
                            @endif
                                <label class="custom-control-label" for="tools_required">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->tools_required) && $c[0]->tools_required == 'N' )                                
                                <input type="radio" id="tools_required2" onclick="tool()" value="N" name="tools_required" class="custom-control-input" checked>
                            @elseif($c[0]->tools_required == '0')
                                <input type="radio" id="tools_required2" value="N" onclick="tool()" name="tools_required" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="tools_required2" onclick="tool()" value="N" name="tools_required" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="tools_required2">नाही</label>
                        </div>
                    </div>

                    <br>

                    @if(isset($c[0]->tools_required) && $c[0]->tools_required == 'Y')
                    <div id="Tool_type_div">
                    @else
                    <div id="Tool_type_div" style="display:none;">
                    @endif
                        <x-jet-label for="Tool_type[]" value="{{ __(' असल्यास, कोणती औजारे?') }}" />
                        @php
                            $i=1
                            @endphp
                        @foreach ($tool_type as $key => $value)
                        @if(in_array($value->id, $tool))
                            <li>
                                <input name="Tool_type[]" id="Tool_type_{{$i}}" class="tools" type="checkbox" value="{{ $value->id }}"  data-parsley-errors-container="#tool-errors" checked>
                                {{ $value->type_of_tools }}
                            </li>
                        @else
                            <li>
                                <input name="Tool_type[]" id="Tool_type_{{$i}}" class="tools" type="checkbox" value="{{ $value->id }}"  data-parsley-errors-container="#tool-errors">
                                {{ $value->type_of_tools }}
                            </li>
                        @endif
                            @php
                                $i++
                                @endphp
                        @endforeach
                        <div id="tool-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="medical_equipment[]" value="{{ __('पुढीलपैकी आपल्याला गरज असलेल्या कोणत्या वस्तू आपल्याकडे आहेत?') }}" />
                        @foreach ($medical_equipment_type as $key => $value)
                        @if(in_array($value->id, $medical_equipment))
                        <li>
                            <input name="medical_equipment[]" id="medical_equipment[]" class="medical" type="checkbox" checked value="{{ $value->id }}" data-parsley-errors-container="#medical-errors" required>
                            {{ $value->name_of_equipment }}
                        </li>
                        @else
                        <li>
                        <input name="medical_equipment[]" id="medical_equipment[]" class="medical" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#medical-errors" required>
                            {{ $value->name_of_equipment }}
                        </li>
                        @endif
                        @endforeach
                        <div id="medical-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="social_service" value="{{ __('आपल्याला समाजासाठी काही काम करण्याची इच्छा आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->social_service) && $c[0]->social_service == 'Y' )
                                <input type="radio" id="social_service" value="Y" onclick="service()" name="social_service" class="custom-control-input" checked required>
                            @else
                                <input type="radio" id="social_service" value="Y" onclick="service()" name="social_service" class="custom-control-input" required>
                            @endif
                                <label class="custom-control-label" for="social_service">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->social_service) && $c[0]->social_service == 'N' )
                                <input type="radio" id="social_service2" value="N" onclick="service()" name="social_service" class="custom-control-input" checked>
                            @elseif($c[0]->social_service == '0')
                                <input type="radio" id="social_service2" value="N" onclick="service()" name="social_service" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="social_service2" value="N" onclick="service()" name="social_service" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="social_service2">नाही</label>
                        </div>
                    </div>

                    <br>

                    @if(isset($c[0]->social_service) && $c[0]->social_service == 'Y')
                    <div id="social_service_type_div">
                    @else
                    <div id="social_service_type_div" style="display:none;">
                    @endif
                        <x-jet-label for="social_service_type[]" id="social_service_type[]" value="{{ __('असल्यास कोणते?') }}" />
                        @php
                            $i=1
                            @endphp
                        @foreach ($social_service_types as $key => $value)
                        @if(in_array($value->id, $social))
                        <li>
                            <input name="social_service_type[]" id="social_service_type_{{$i}}" class="social" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#social-errors" checked>
                            {{ $value->type_of_social_service }}
                        </li>
                        @else
                        <li>
                            <input name="social_service_type[]" id="social_service_type_{{$i}}" class="social" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#social-errors">
                            {{ $value->type_of_social_service }}
                        </li>
                        @endif
                        @php
                                $i++
                                @endphp
                        @endforeach
                        <div id="social-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="teaching_skills[]" value="{{ __('आपल्याकडे इतरांना शिकवण्यासारखे कोणते कला / गुण आहेत?') }}" />
                        @foreach ($teaching_skills as $key => $value)
                        @if(in_array($value->id, $teaching))
                            <li>
                                <input name="teaching_skills[]" id="teaching_skills[]" class="teaching" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#teaching-errors" required checked>
                                {{ $value->name_of_skill }}
                            </li>
                        @else
                        <li>
                            <input name="teaching_skills[]" id="teaching_skills[]" class="teaching" type="checkbox" value="{{ $value->id }}" data-parsley-errors-container="#teaching-errors" required>
                            {{ $value->name_of_skill }}
                        </li>
                        @endif
                        @endforeach
                        <div id="teaching-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="Hobbies[]" value="{{ __('आपल्या आवडी कोणत्या?') }}" />
                        @foreach ($hobbies as $key => $value)
                        @if(in_array($value->id, $hobby))
                            <li>
                                <input name="Hobbies[]" id="Hobbies[]" class="hobby" type="checkbox" value="{{ $value->id }}" required data-parsley-errors-container="#hobbies-errors" checked>
                                {{ $value->name_of_hobby }}
                            </li>
                        @else
                        <li>
                            <input name="Hobbies[]" id="Hobbies[]" class="hobby" type="checkbox" value="{{ $value->id }}" required data-parsley-errors-container="#hobbies-errors">
                            {{ $value->name_of_hobby }}
                        </li>
                        @endif
                        @endforeach
                        <div id="hobbies-errors"></div>
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="comments" value="{{ __('अजून काही उपाययोजना हव्या असल्यास सूचना. ') }}" />
                        @if(isset($c[0]->any_comment))
                        <textarea name="comments" id="comments" cols="" rows="" required>{{$c[0]->any_comment}}</textarea>
                        @else
                        <textarea name="comments" id="comments" cols="" rows="" required></textarea>
                        @endif
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="difficulties" value="{{ __('आपणांस अजून काही अडचणी आहेत का?') }}" />
                        @if(isset($c[0]->any_difficulties))
                        <textarea name="difficulties" id="difficulties" cols="" rows="" required>{{$c[0]->any_difficulties}}</textarea>
                        @else
                        <textarea name="difficulties" id="difficulties" cols="" rows="" required></textarea>
                        @endif
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="designated_officer_name" value="{{ __('सर्वेक्षकाचे नाव ') }}" />   
                        @if(isset($c[0]->designated_officer_name))
                        <x-jet-input id="designated_officer_name" value="$c[0]->designated_officer_name" class="block mt-1 w-full" type="text" name="designated_officer_name" :value="$c[0]->designated_officer_name" required autofocus />
                        @else
                        <x-jet-input id="designated_officer_name" value="old('designated_officer_name')" class="block mt-1 w-full" type="text" name="designated_officer_name" :value="old('designated_officer_name')" required autofocus />
                        @endif
                    </div>

                    <br>

                    <div>
                        <x-jet-label for="designated_officer_contact_no" value="{{ __('सर्वेक्षकाचे मोबाईल') }}" />   
                        @if(isset($c[0]->designated_officer_contact_no))
                        <x-jet-input id="designated_officer_contact_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="designated_officer_contact_no" :value="$c[0]->designated_officer_contact_no" required autofocus />
                        @else
                        <x-jet-input id="designated_officer_contact_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="designated_officer_contact_no" :value="old('designated_officer_contact_no')" required autofocus />
                        @endif
                    </div>


                    <br><br>
                    <x-jet-button class="ml-4">
                        {{ __('Submit') }}
                    </x-jet-button>  

                    <x-jet-button id="Previous_page" name="Previous_page" class="ml-4">
                        {{ __('Previous Page') }}
                    </x-jet-button>       

                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
    $(document).ready(function()
    { 
        $("#income_increase").focus();
    });
</script>

<script>
jQuery("#validate_form").submit(function(e)
{
    var income_increase = $("input[name='income_increase']:checked").val();
    var Work_type = [];
    $('.work').each(function()
    {
        if($(this).is(":checked"))
        {
            Work_type.push($(this).val());
        }
    });
    var Tool_type = [];
    $('.tools').each(function()
    {
        if($(this).is(":checked"))
        {
            Tool_type.push($(this).val());
        }
    });
    var tools_required  = $("input[name='tools_required']:checked").val();
   
    var medical_equipment = [];
    $('.medical').each(function()
    {
        if($(this).is(":checked"))
        {
            medical_equipment.push($(this).val());
        }
    }); 
    var social_service =  $("input[name='social_service']:checked").val();
    var social_service_type = [];
    $('.social').each(function()
    {
        if($(this).is(":checked"))
        {
            social_service_type.push($(this).val());
        }
    });
    var teaching_skills = [];
    $('.teaching').each(function()
    {
        if($(this).is(":checked"))
        {
            teaching_skills.push($(this).val());
        }
    });
    var Hobbies = [];
    $('.hobby').each(function()
    {
        if($(this).is(":checked"))
        {
            Hobbies.push($(this).val());
        }
    });
    var comments = $('#comments').val();
    var difficulties = $("#difficulties").val();
    var designated_officer_name = $("#designated_officer_name").val();
    var designated_officer_contact_no = $('#designated_officer_contact_no').val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/citizen/tab6/insert',
            data:
            {
                income_increase:income_increase, Work_type:Work_type, tools_required:tools_required, Tool_type:Tool_type,
                medical_equipment:medical_equipment, social_service:social_service, social_service_type:social_service_type,
                teaching_skills:teaching_skills, Hobbies:Hobbies, comments:comments, difficulties:difficulties, 
                designated_officer_name:designated_officer_name, designated_officer_contact_no:designated_officer_contact_no, _token: '{{csrf_token()}}',
            },
            type: 'POST',
            success:function(data)
            {
                //alert(result);
                alert("Please use this id For your reference: "+data);
                window.location = "/citizen/tab1/0";
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
            window.location = "/citizen/tab5/";
        }
    });
});
</script>

<script>
if($("input[name='income_increase']:checked").val()=='N')
{
    $("#Work_type_div").hide();
}
</script>

<script>
function tool()
{
    var i=1;
    if($("input[name='tools_required']:checked").val()=='N')
    {

        $("#Tool_type_div").hide();
            $('input[type=checkbox][name=Tool_type\\[\\]]').each(function()
			{
            $('#Tool_type_'+i).removeAttr('required');
            i++;
        });
    }
    else
    {
        $("#Tool_type_div").show();
        $('input[type=checkbox][name=Tool_type\\[\\]]').each(function()
        {
            $('#Tool_type_'+i).attr('required', 'required');
            i++;
        });
    }
}
</script>

<script>
function service()
{
    var i=1;
    if($("input[name='social_service']:checked").val()=='N')
    {

        $("#social_service_type_div").hide();
            $('input[type=checkbox][name=social_service_type\\[\\]]').each(function(){
             
            $('#social_service_type_'+i).removeAttr('required');
            i++;
        });
    }
    else
    {
        $("#social_service_type_div").show();
        $('input[type=checkbox][name=social_service_type\\[\\]]').each(function()
        {
            $('#social_service_type_'+i).attr('required', 'required');
            i++;
        });
    }
}
</script>

<script>
        
function scheme()
{
    var i=1;
    if($("input[name='income_increase']:checked").val()=='N')
    {

        $("#Work_type_div").hide();
            $('input[type=checkbox][name=Work_type\\[\\]]').each(function(){
             
            $('#Work_type_'+i).removeAttr('required');
            i++;
        });
    }
    else
    {
        $("#Work_type_div").show();
        $('input[type=checkbox][name=Work_type\\[\\]]').each(function()
        {
            $('#Work_type_'+i).attr('required', 'required');
            i++;
        });
    }
}
</script>