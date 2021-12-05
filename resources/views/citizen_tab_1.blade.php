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
                <div id="log"></div>
                <form id="validate_form" data-parsley-validate method="POST" action="/citizen/tab1/insert/">
                    @csrf

                    <!-- Akash -->
                    <div class="col-6"> 
                        <x-jet-label for="Full_name" value="{{ __('संपूर्ण नाव') }}" />
                        @if(isset($c[0]->Full_name) && $c[0]->Full_name!='')
                        <x-jet-input id="Full_name" class="block mt-1 w-full" type="text" name="Full_name" :value="$c[0]->Full_name" required autofocus />
                        @else
                        <x-jet-input id="Full_name" class="block mt-1 w-full" type="text" name="Full_name" :value="old('Full_name')" required autofocus />
                        @endif
                    </div>
                    
                
                    <div class="col-6">
                        <x-jet-label for="date_of_birth" value="{{ __('माहित असल्यास जन्मतारीख') }}" />
                        @if(isset($c[0]->date_of_birth) && $c[0]->date_of_birth!='')
                        <x-jet-input id="date_of_birth" onchange="ageCal()" type="date" name="date_of_birth" :value="$c[0]->date_of_birth" required autofocus />
                        @else
                        <x-jet-input id="date_of_birth" onchange="ageCal()" type="date" name="date_of_birth" :value="old('date_of_birth')" required autofocus />
                        @endif
                    </div>

                    
                    <div class="col-6">
                        <x-jet-label for="age" value="{{ __('वय:') }}" />
                        @if(isset($c[0]->age) && $c[0]->age!='')
                            <x-jet-input id="age" onchange="getDOB()" class="block mt-1" type="number" name="age" :value="$c[0]->age" required autofocus/>
                        @else
                            <x-jet-input id="age" onchange="getDOB()" class="block mt-1" type="number" name="age" :value="0" required autofocus/>
                        @endif
                    </div>
                    

                    <div class="col-6">
                        <x-jet-label for="Education" value="{{ __('शिक्षण') }}" />
                        <select name="Education" id="Education" class="block mt-1 w-full border-gray-300
                            focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">शिक्षण</option>
                                @foreach ($education as $key => $value)
                                    @if(isset($c[0]->Education) && $c[0]->Education!='' && $c[0]->Education == $value->id ) 
                                        <option value="{{$value->id}}" selected>{{ $value->name_of_degree }}</option>
                                    @else
                                        <option value="{{$value->id}}" >{{ $value->name_of_degree }}</option>
                                    @endif
                                @endforeach
                        </select>
                    </div>
                

                    <div class="col-6">
                        <x-jet-label for="Complete_address" value="{{ __('संपूर्ण पत्ता') }}" />
                        @if(isset($c[0]->Complete_address) && $c[0]->Complete_address != '')
                        <x-jet-input id="Complete_address" class="block mt-1 w-full" type="text" name="Complete_address" :value="$c[0]->Complete_address" required autofocus />
                        @else
                        <x-jet-input id="Complete_address" class="block mt-1 w-full" type="text" name="Complete_address" :value="old('Complete_address')" required autofocus />
                        @endif
                    </div>
                

                    <div class="col-6">
                        <x-jet-label for="district " value="{{ __('जिल्हा') }}" />
                        <select name="district" id="district" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>   
                                    @foreach ($district as $key => $value)
                                        @if(isset($c[0]->District) && $c[0]->District!='' && $c[0]->District == $key ) 
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                        </select>
                    </div>
                
                    <div class="col-6">
                        <x-jet-label for="taluka" value="{{ __('तालुका') }}" />
                        <select name="taluka" id="taluka" class="block mt-1 w-full border-gray-300
                                        focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                        focus:ring-opacity-50 rounded-md shadow-sm" required>
                            @if(isset($t) && $t!='')
                                @foreach($t as $key=>$value)
                                    @if(isset($c[0]->Taluka) && $c[0]->Taluka!='' && $c[0]->Taluka == $key)                            
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>       
                    </div>


                    <div class="col-6">
                        <x-jet-label for="village" value="{{ __('गाव') }}" />
                        <select name="village" id="village" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">--- Select village ---</option>
                                    @if(isset($v) && $v!='')
                            @foreach($v as $key=>$value)
                            @if(isset($c[0]->Village) && $c[0]->Village == $key)
                            <option value="{{$key}}" selected>{{$value}}</option>
                            @else
                            <option value="{{$key}}">{{$value}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                

                    <div class="col-6">
                        <x-jet-label for="Mobile_no" value="{{ __('मोबाईल नंबर') }}" />
                        @if(isset($c[0]->Mobile_no) && $c[0]->Mobile_no != '')
                        <x-jet-input id="Mobile_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="Mobile_no" :value="$c[0]->Mobile_no" required autofocus />
                        @else
                        <x-jet-input id="Mobile_no" class="block mt-1 w-full" minlength="10" maxlength="10" type="number" name="Mobile_no" :value="old('Mobile_no')" required autofocus />
                        @endif
                    </div>
                

                    <div class="col-6">
                        <x-jet-label for="Income_source" value="{{ __('आपल्या मिळकतीचे साधन काय आहे?') }}" />
                        <select name="Income_source" id="Income_source" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select Income Source</option>
                                @foreach ($income_source as $key => $value)
                                @if(isset($c[0]->Income_source) && $c[0]->Income_source !='' && $c[0]->Income_source == $value->id ) 
                                <option value="{{ $value->id }}"selected>{{ $value->type_of_income_source }}</option>
                                @else
                                <option value="{{ $value->id }}">{{ $value->type_of_income_source }}</option>
                                @endif
                                @endforeach
                        </select>
                    </div>

                    <br>

                    <div  class="col-6">                           
                        <x-jet-label for="Own_house" value="{{ __('आपल्या मालकीचे घर आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Own_house) && $c[0]->Own_house == 'Y' )
                        <input type="radio" id="Own_house" value="Y" onclick="house()" checked name="Own_house" class="custom-control-input" required>
                        @else
                        <input type="radio" id="Own_house" value="Y" onclick="house()" name="Own_house" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Own_house">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Own_house) && $c[0]->Own_house != '' && $c[0]->Own_house == 'N' )
                        <input type="radio" id="Own_house2" value="N" onclick="house()" checked name="Own_house" class="custom-control-input" >
                        @elseif(isset($id) && $id==0 )
                        <input type="radio" id="Own_house2" value="N" checked onclick="house()" name="Own_house" class="custom-control-input" >
                        @else
                        <input type="radio" id="Own_house2" value="N" onclick="house()" name="Own_house" class="custom-control-input">
                        @endif
                            <label  class="custom-control-label" for="Own_house2">नाही</label>
                        </div>
                    </div>

                    <br>

                    <div id="home_type_div" class="col-6">
                        <x-jet-label for="home_type" value="{{ __('घराचा प्रकार' ) }}" />
                        <select name="home_type" id="home_type" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="">Select home type</option>
                                @foreach ($home_type as $key => $value)
                                @if(isset($c[0]->home_type) && $c[0]->home_type !='' && $c[0]->home_type == $value->id ) 
                                    <option value="{{ $value->id }}" selected>{{ $value->type_of_home }}</option>
                                @else
                                    <option value="{{ $value->id }}">{{ $value->type_of_home }}</option>
                                @endif
                                @endforeach
                        </select>
                    </div>


                    <div class="col-6">
                        <x-jet-label for="Water_closet" value="{{ __('शौचालय आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Water_closet) && $c[0]->Water_closet != '' && $c[0]->Water_closet == 'Y' )
                            <input type="radio" id="Water_closet" value="Y" checked name="Water_closet" class="custom-control-input" required>
                        @else
                            <input type="radio" id="Water_closet" value="Y" name="Water_closet" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Water_closet">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline"> 
                        @if(isset($c[0]->Water_closet) && $c[0]->Water_closet !='' && $c[0]->Water_closet == 'N' )
                            <input type="radio" id="Water_closet2" value="N" checked name="Water_closet" class="custom-control-input" >
                        @elseif(isset($id) && $id==0 )
                            <input type="radio" id="Water_closet2" value="N" checked name="Water_closet" class="custom-control-input" >
                        @else
                            <input type="radio" id="Water_closet2" value="N" name="Water_closet" class="custom-control-input">
                        @endif
                            <label class="custom-control-label" for="Water_closet2">नाही</label>
                        </div>
                    </div>


                    <div class="col-6">
                        <x-jet-label for="Bathroom" value="{{ __('न्हाणी घर आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Bathroom) && $c[0]->Bathroom!='' && $c[0]->Bathroom == 'Y' )
                        <input type="radio" checked id="Bathroom" value="Y" name="Bathroom" class="custom-control-input" required>
                        @else

                        <input type="radio" id="Bathroom" value="Y" name="Bathroom" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Bathroom">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Bathroom) && $c[0]->Bathroom!='' && $c[0]->Bathroom == 'N' )
                            <input type="radio" checked id="Bathroom2" value="N" name="Bathroom" class="custom-control-input">
                        @elseif(isset($id) && $id==0 )
                            <input type="radio" checked id="Bathroom2" value="N" name="Bathroom" class="custom-control-input">
                        @else
                            <input type="radio" id="Bathroom2" value="N" name="Bathroom" class="custom-control-input">
                        @endif
                            <label class="custom-control-label" for="Bathroom2">नाही</label>
                        </div>
                    </div>


                    <div class="col-6">
                        <x-jet-label for="stove_type" value="{{ __('आपण स्वयंपाकासाठी काय वापरता?') }}" />
                        <select name="stove_type" id="stove_type" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                        <option value="">Select stove type</option>
                                        @foreach ($stove_type as $key => $value)
                                        @if(isset($c[0]->stove_type) && $c[0]->stove_type !='' && $c[0]->stove_type == $value->id ) 
                                            <option value="{{ $value->id }}"selected>{{ $value->type_of_stove }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->type_of_stove }}</option>
                                        @endif
                                        @endforeach
                        </select>
                    </div>


                    <div class="col-6">
                        <x-jet-label for="Land_ownership" value="{{ __('आपली जमीन / मालमत्ता आपल्या नावावर आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Land_ownership) && $c[0]->Land_ownership != '' && $c[0]->Land_ownership == 'Y' )
                            <input type="radio" id="Land_ownership" value="Y" checked name="Land_ownership" class="custom-control-input" required>
                        @else
                        <input type="radio" id="Land_ownership" value="Y" name="Land_ownership" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Land_ownership">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Land_ownership) && $c[0]->Land_ownership != '' && $c[0]->Land_ownership == 'N' )
                            <input checked type="radio" id="Land_ownership2" value="N" name="Land_ownership" class="custom-control-input">
                        @elseif(isset($id) && $id==0 )
                            <input checked type="radio" id="Land_ownership2" value="N" name="Land_ownership" class="custom-control-input">
                        @else
                            <input type="radio" id="Land_ownership2" value="N" name="Land_ownership" class="custom-control-input" >
                        @endif
                            <label class="custom-control-label" for="Land_ownership2">नाही</label>
                        </div>
                    </div>

                    
                    <div class="col-6">
                        <x-jet-label for="Land_dispute" value="{{ __('जमीन / मालमत्ते संदर्भात शासकीय कार्यालयाकडे कज्जे / वाद सुरु आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Land_dispute) && $c[0]->Land_dispute !='' && $c[0]->Land_dispute == 'Y' )
                            <input type="radio" id="Land_dispute" value="Y" checked name="Land_dispute" class="custom-control-input" required>
                        @else
                            <input type="radio" id="Land_dispute" value="Y" name="Land_dispute" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Land_dispute">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Land_dispute) && $c[0]->Land_dispute !='' && $c[0]->Land_dispute == 'N' )
                            <input type="radio" id="Land_dispute2" value="N" name="Land_dispute" class="custom-control-input" checked>
                        @elseif(isset($id) && $id==0 )
                            <input type="radio" id="Land_dispute2" value="N" name="Land_dispute" class="custom-control-input" checked>
                        @else
                            <input type="radio" id="Land_dispute2" value="N" name="Land_dispute" class="custom-control-input">
                        @endif
                            <label class="custom-control-label" for="Land_dispute2">नाही</label>
                        </div>
                    </div>

                   
                    <div class="col-6">
                        <x-jet-label for="Bank_account" value="{{ __('आपले बँकेत खाते आहे का?') }}" />
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Bank_account) && $c[0]->Bank_account !='' && $c[0]->Bank_account == 'Y' )
                            <input type="radio" id="Bank_account" value="Y" onclick="Bank()" name="Bank_account" class="custom-control-input" checked required>
                        @else
                            <input type="radio" id="Bank_account" value="Y" onclick="Bank()" name="Bank_account" class="custom-control-input" required>
                        @endif
                            <label class="custom-control-label" for="Bank_account">होय</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        @if(isset($c[0]->Bank_account) && $c[0]->Bank_account !='' && $c[0]->Bank_account == 'N' )
                            <input type="radio" id="Bank_account2" value="N" onclick="Bank()" checked name="Bank_account" class="custom-control-input" required>
                        @elseif(isset($id) && $id==0 )
                            <input type="radio" id="Bank_account2" value="N" onclick="Bank()" checked name="Bank_account" class="custom-control-input" required>
                        @else
                            <input type="radio" id="Bank_account2" value="N" onclick="Bank()" name="Bank_account" class="custom-control-input">
                        @endif
                            <label class="custom-control-label" for="Bank_account2">नाही</label>
                        </div>
                    </div>
                
                   
                    <div class="col-6" id="Bank_type_div">                        
                        <x-jet-label for="Bank_type" value="{{ __('कोणत्या प्रकारच्या बँकेत खाते आहे?') }}" />
                        <select name="Bank_type" id="Bank_type" class="block mt-1 w-full border-gray-300
                                focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select bank type</option>
                                    @foreach ($bank_type as $key => $value)
                                    @if(isset($c[0]->Bank_type) && $c[0]->Bank_type!='' && $c[0]->Bank_type == $value->id ) 
                                        <option value="{{ $value->id }}"selected>{{ $value->type_of_bank }}</option>
                                    @else
                                        <option value="{{ $value->id }}" >{{ $value->type_of_bank }}</option>
                                    @endif
                                    @endforeach
                        </select>
                    </div>


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
            url: '/citizen/tab1/insert',
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
                    alert("Please use this id For your reference: "+data);
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
                        $('select[name="taluka"]').append('<option value="">Select</option>'); 
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
</script>

<script>
if($("input[name='Own_house']:checked").val()=='N')
{
    $("#home_type_div").hide();
    $('#home_type').removeAttr('required');
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
$("#district").trigger("change");
</script>

<script>
if($("input[name='Bank_account']:checked").val()=='N')
{
    $("#Bank_type_div").hide();
    $('#Bank_type').removeAttr('required');
}
</script>

<script>
function Bank()
{
    //salert($("input[name='Own_house']:checked").val());
    if($("input[name='Bank_account']:checked").val()=='N')
    {
        $("#Bank_type_div").hide();
        $('#Bank_type').removeAttr('required');
    }
    else
    {
        $("#Bank_type_div").show();
        $('#Bank_type').attr('required', 'required');
    }
}
$("#district").trigger("change");
</script>

<script>
    function ageCal() 
    {
        var dateString = $("#date_of_birth").val();
        var now = new Date();
        var today = new Date(now.getFullYear(),now.getMonth(),now.getDate());

        var yearNow = now.getFullYear();
        var monthNow = now.getMonth()+1;
        var dateNow = now.getDate();

        var dob = new Date(
            dateString.substring(6,10),
            dateString.substring(0,2),                   
            dateString.substring(3,5)                  
        );
        var dob = new Date(dateString);
        var yearDob = dateString.substring(0,4);
        var monthDob = dateString.substring(5,7);
        var dateDob = dateString.substring(8,10);
        var age = {};
        var ageString = "";
        var yearString = "";
        var monthString = "";
        var dayString = "";
        yearAge = yearNow - yearDob;
        if(monthNow-monthDob == 0 && dateNow-dateDob <= 0)
        {
            yearAge = yearAge;
        }
        if(monthNow-monthDob < 0)
        {
            yearAge = yearAge-1;
        }
        if(monthNow-monthDob > 0)
        {
            yearAge = yearAge;
        }
        if(monthNow-monthDob == 0)
        {
        
            if(dateNow-dateDob > 0)
            {
                yearAge = yearAge-1;
            }
        }
        if(yearAge < 0) 
        {
            yearAge = 0;
        }
$('#age').val(yearAge);
}
if($("#date_of_birth").val() != '')
{
    ageCal();
}

</script>
<script>   
function getDOB()
{
    var age = $("#age").val();
    var year = new Date().getFullYear();
    var difference = function (year, age)
    {
        return Math.abs(year - age);
    }
    //alert(difference);"01-Jan-"+difference(year,age)
    $('#date_of_birth').val(difference(year,age)+"-01-01");// var db = document.write("01-Jan-"+difference(year,age));
}
</script>

<script type="text/javascript">
    $(function() 
    {
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date_of_birth")[0].setAttribute('max', today);
    });
</script>