<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('सर्वसाधारण माहिती') }}
        </h2>
        <script src="http://parsleyjs.org/dist/parsley.js"></script>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" data-parsley-validate method="POST" action="/citizen/tab1/insert/">
                    @csrf

                    <div class="col-6">
                        <x-jet-label for="Full_name" value="{{ __('संपूर्ण नाव') }}" />
                        <x-jet-input id="Full_name" class="block mt-1 w-full" type="text" name="Full_name" :value="{{$details_of_citizens['Full_name']}}" required autofocus />
                    </div>
                
                    <br>
                
                    <div class="col-6">
                        <x-jet-label for="date_of_birth" value="{{ __('माहित असल्यास जन्मतारीख') }}" />
                        <x-jet-input id="date_of_birth" class="block mt-1" type="date" name="date_of_birth" :value="{{$details_of_citizens['date_of_birth']}}" required autofocus />
                    </div>

                    <br>
                
                    <div class="col-6">
                        <x-jet-label for="Education" value="{{ __('शिक्षण') }}" />
                        <select name="Education" id="Education" class="block mt-1 w-full border-gray-300
                            focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">शिक्षण</option>
                                @foreach ($education as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name_of_degree }}</option>
                                @endforeach
                        </select>
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="Complete_address" value="{{ __('संपूर्ण पत्ता') }}" />
                        <x-jet-input id="Complete_address" class="block mt-1 w-full" type="text" name="Complete_address" :value="{{$details_of_citizens['Complete_address']}}" required autofocus />
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="district " value="{{ __('जिल्हा') }}" />
                        <select name="district" id="district" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">--- Select district ---</option>
                                        @foreach ($district as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                        </select>
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="taluka" value="{{ __('तालुका') }}" />
                        <select name="taluka" id="taluka" class="block mt-1 w-full border-gray-300
                                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                        focus:ring-opacity-50 rounded-md shadow-sm" required>
                            <option value="">--- Select taluka ---</option>
                        </select>       
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="village" value="{{ __('गाव') }}" />
                        <select name="village" id="village" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">--- Select village ---</option>
                        </select>
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="Mobile_no" value="{{ __('मोबाईल नंबर') }}" />
                        <x-jet-input id="Mobile_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="Mobile_no" :value="{{$details_of_citizens['Mobile_no']}}" required autofocus />
                    </div>
                
                    <br>

                    <div class="col-6">
                        <x-jet-label for="Income_source" value="{{ __('आपल्या मिळकतीचे साधन काय आहे?') }}" />
                        <select name="Income_source" id="Income_source" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select Income Source</option>
                                @foreach ($income_source as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->type_of_income_source }}</option>
                                @endforeach
                        </select>
                    </div>

                    <br>

                    <div  class="col-6">                           
                        <x-jet-label for="Own_house" value="{{ __('आपल्या मालकीचे घर आहे का?') }}" />
                            <input type=radio name="Own_house" value="Y" {{ $details_of_citizens->Own_house == 'Y' ? 'checked' : ''}}>होय</option><br>
                            <input type=radio name="Own_house" value="N" {{ $details_of_citizens->Own_house == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>

                    <div id="home_type_div" class="col-6">
                        <x-jet-label for="home_type" value="{{ __('घराचा प्रकार' ) }}" />
                        <select name="home_type" id="home_type" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">Select home type</option>
                                @foreach ($home_type as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->type_of_home }}</option>
                                @endforeach
                        </select>
                    </div>

                    <br>

                    <div class="col-6">
                        <x-jet-label for="Water_closet" value="{{ __('शौचालय आहे का?') }}" />
                            <input type=radio name="Water_closet" value="Y" {{ $details_of_citizens->Water_closet == 'Y' ? 'checked' : ''}}>होय</option><br>
                            <input type=radio name="Water_closet" value="N" {{ $details_of_citizens->Water_closet == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>

                    <div class="col-6">
                        <x-jet-label for="Bathroom" value="{{ __('न्हाणी घर आहे का?') }}" />
                            <input type=radio name="Bathroom" value="Y" {{ $details_of_citizens->Bathroom == 'Y' ? 'checked' : ''}}>होय</option><br>
                            <input type=radio name="Bathroom" value="N" {{ $details_of_citizens->Bathroom == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>

                    <div class="col-6">
                        <x-jet-label for="stove_type" value="{{ __('आपण स्वयंपाकासाठी काय वापरता?') }}" />
                        <select name="stove_type" id="stove_type" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                        <option value="">Select stove type</option>
                                        @foreach ($stove_type as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->type_of_stove }}</option>
                                        @endforeach
                        </select>
                    </div>

                    <br>

                    <div class="col-6">
                        <x-jet-label for="Land_ownership" value="{{ __('आपली जमीन / मालमत्ता आपल्या नावावर आहे का?') }}" />
                            <input type=radio name="Land_ownership" value="Y" {{ $details_of_citizens->Land_ownership == 'Y' ? 'checked' : ''}}>होय</option><br>
                            <input type=radio name="Land_ownership" value="N" {{ $details_of_citizens->Land_ownership == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>
                    
                    <div class="col-6">
                        <x-jet-label for="Land_dispute" value="{{ __('जमीन / मालमत्ते संदर्भात शासकीय कार्यालयाकडे कज्जे / वाद सुरु आहे का?') }}" />
                            <input type=radio name="Land_dispute" value="Y" {{ $details_of_citizens->Land_dispute == 'Y' ? 'checked' : ''}}>होय</option><br>
                            <input type=radio name="Land_dispute" value="N" {{ $details_of_citizens->Land_dispute == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>

                    <div class="col-6">
                    <x-jet-label for="Bank_account" value="{{ __('आपले बँकेत खाते आहे का?') }}" />
                        <input type=radio name="Bank_account" value="Y" {{ $details_of_citizens->Bank_account == 'Y' ? 'checked' : ''}}>होय</option><br>
                        <input type=radio name="Bank_account" value="N" {{ $details_of_citizens->Bank_account == 'N' ? 'checked' : ''}}>नाही</option> 
                    </div>

                    <br>

                    <div class="col-6">                        
                        <x-jet-label for="Bank_type" value="{{ __('कोणत्या प्रकारच्या बँकेत खाते आहे?') }}" />
                        <select name="Bank_type" id="Bank_type" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select bank type</option>
                                    @foreach ($bank_type as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->type_of_bank }}</option>
                                    @endforeach
                        </select>
                    </div>

                    <br>

                    <x-jet-button class="ml-4">
                        {{ __('Submit') }}
                    </x-jet-button>
                
                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var Full_name = $("#Full_name").val();
    var date_of_birth = $("#date_of_birth").val();
    var Education = $("#Education").val();
    var Complete_address = $("#Complete_address").val();
    var district = $("#district").val();
    var taluka = $("#taluka").val();
    var village = $("#village").val();
    var Mobile_no = $('#Mobile_no').val();
    var Income_source = $('#Income_source').val();
    var Own_house = $("input[name='Own_house']:checked").val();
    var home_type = $('#home_type').val();
    var Water_closet = $("input[name='Water_closet']:checked").val();
    var Bathroom = $("input[name='Bathroom']:checked").val();
    var stove_type = $('#stove_type').val();
    var Land_ownership = $("input[name='Land_ownership']:checked").val();
    var Land_dispute =$("input[name='Land_dispute']:checked").val();
    var Bank_account = $("input[name='Bank_account']:checked").val();
    var Bank_type = $('#Bank_type').val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/citizen/tab1/insert/',
            data:
            {
                Full_name:Full_name, date_of_birth:date_of_birth, Education:Education, Complete_address:Complete_address, 
                district:district, taluka:taluka, Mobile_no:Mobile_no, Income_source:Income_source, village:village,
                Own_house:Own_house, home_type:home_type, Water_closet:Water_closet, Bathroom:Bathroom, stove_type:stove_type,
                Land_ownership:Land_ownership, Land_dispute:Land_dispute, Bank_account:Bank_account, Bank_type:Bank_type, _token: '{{csrf_token()}}',
            },
            type: 'POST',
            success:function(data)
            {
                window.location = "/citizen/tab2/";
            }
        });
    }
});
</script>

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
</script>

<script>
$(document).ready(function() 
    {
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
</script>

<script>
if($("input[name='Own_house']:checked").val()=='N')
{
    $("#home_type_div").hide();
}
</script>

<script>
function house()
{
    if($("input[name='Own_house']:checked").val()=='N')
    {
        $("#home_type_div").hide();
        $('#home_type').removeAttr('required');
    }
    else
    {
        $("#home_type_div").show();
        $('#home_type').attr('required', 'required');
    }
}
</script>

<script>
    $("#district" ).trigger("change");
    $('#column_value').val("{{$Form->Column_value}}");
</script>
