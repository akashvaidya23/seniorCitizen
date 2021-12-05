<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('आरोग्य विषयक माहिती') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" method="POST" data-parsley-validate action="/citizen/tab3/insert">
                    @csrf
                        <div type=hidden>
                            Last inserted id is {{session('id')}}.
                        </div>
                        
                        <div class="col-6">
                            <div>
                                <x-jet-label for="any_disease" value="{{ __('आपणास काही आजार आहेत का?') }}" />
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="any_disease" onclick="disease()" value="Y" name="any_disease" class="custom-control-input" required>
                                    <label class="custom-control-label" for="customRadio1Inline1">होय</label >
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="any_disease" value="N" onclick="disease()" name="any_disease" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="customRadio1Inline1">नाही</label>
                                </div>
                            </div>
                        </div>
                    
                        <br>

                        <div id="which_diseases_div" class="col-6">
                            <x-jet-label for="which_diseases[]" value="{{ __('आजार, असल्यास  कधीपासून आहे?') }}" />
                            <div class="list-group">
                                <table>
                                    @php
                                    $i = 1
                                    @endphp
                                    @foreach ($diseases as $key => $value)
                                        <tr>
                                            <td>
                                                <input name="which_diseases[]" id="which_diseases_{{$i}}" class="disease" type="checkbox" value="{{ $value->id }}" data-parsley-multiple>
                                                {{ $value->name_of_disease }}
                                            </td>
                                            <td>
                                                <x-jet-input placeholder="" id="Disease_start_date[]" id="Disease_start_date_{{$i}}" type="date" name="Disease_start_date[]" :value="old('Disease_start_date')" data-parsley-multiple />
                                            </td>
                                        </tr>
                                    @php
                                        $i++
                                    @endphp
                                    @endforeach

                                </table>
                            </div>    
                        </div>   

                    <br>

                    <div class="col-6">
                        <div>
                            <x-jet-label for="Regular_check_up" value="{{ __('आपण वेळोवेळी आरोग्य तपासणी करता का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="Regular_check_up" value="Y" name="Regular_check_up" class="custom-control-input"required>
                                <label class="custom-control-label" for="customRadio1Inline1">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="Regular_check_up" value="N" name="Regular_check_up" class="custom-control-input" checked>
                                <label class="custom-control-label" for="customRadio1Inline1">नाही</label>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="col-6">
                        <div>
                            <x-jet-label for="Hospital_type" value="{{ __('आपण उपचार कोठे घेता?') }}" />
                            <select name="Hospital_type" id="Hospital_type" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">Select type of hospital</option>
                                        @foreach ($hospital_type as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->type_of_hospital }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="col-6">
                        <div>
                            <x-jet-label for="are_you_handicapped" value="{{ __('आपण दिव्यांग आहात का? (अपंगत्व आहे का?)') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="are_you_handicapped"  onclick="handicap()"  value="Y" name="are_you_handicapped" class="custom-control-input" required>
                                <label class="custom-control-label" for="customRadio1Inline1">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="are_you_handicapped" value="N"  onclick="handicap()"  name="are_you_handicapped" class="custom-control-input" checked>
                                <label class="custom-control-label" for="customRadio1Inline1">नाही</label>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div id="Handicap_id_div" class="col-6">
                        <div>
                            <x-jet-label for="Handicap_id" value="{{ __('असल्यास प्रकार') }}" />
                            <select name="Handicap_id" id="Handicap_id" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option value="">Select type of disabilities</option>
                                        @foreach ($handicap_type as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->type_of_disability }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div id="Handicap_percentage_div" class="col-6">
                        <div>
                            <x-jet-label for="Handicap_percentage" value="{{ __('असल्यास किती टक्के अपंगत्व आहे?') }}" />
                            <x-jet-input id="Handicap_percentage" class="block mt-1 w-full" type="number" name="Handicap_percentage" :value="old('Handicap_percentage')" />
                        </div>
                    </div>

                    <br>                            

                    <div class="col-6">
                        <div>
                            <x-jet-label for="daily_chores" value="{{ __('आपण रोजची कामे (दैनंदिन) कशी पार पाडता?') }}" />
                            <select name="daily_chores" id="daily_chores" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">Select type of chores help</option>
                                        @foreach ($help_type as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->type_of_help }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <x-jet-button id="Previous_page" name="Previous_page" class="ml-4">
                        {{ __('Previous Page') }}
                    </x-jet-button>       

                    <x-jet-button id="Next_Page" class="ml-4">
                        {{ __('Next Page') }}
                    </x-jet-button>            
                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script language="javascript" type="text/javascript">
jQuery("#Next_Page").click(function(e)
{
    var any_disease = $("#any_disease").val();
    var which_diseases = [];
    $('.disease').each(function()
    {
        if($(this).is(":checked"))
        {
            which_diseases.push($(this).val());
        }
    });
    var Regular_check_up = $("input[name='Regular_check_up']:checked").val();
    var Hospital_type = $("#Hospital_type").val();
    var are_you_handicapped = $("input[name='are_you_handicapped']:checked").val();
    var Handicap_id = $("#Handicap_id").val();
    var Handicap_percentage = $("Handicap_percentage").val();
    var daily_chores = $("daily_chores").val();
    //alert(which_diseases);
    e.preventDefault();
    alert($('#validate_form').parsley().isValid());

    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
        url: '/citizen/tab3/insert/',
        data:
        {
            any_disease:any_disease, which_diseases:which_diseases, Regular_check_up:Regular_check_up,
            Hospital_type:Hospital_type, are_you_handicapped:are_you_handicapped, Handicap_id:Handicap_id,
            Handicap_percentage:Handicap_percentage, daily_chores:daily_chores, _token: '{{csrf_token()}}',
        },
        type: 'POST',
        success:function(result)
        {
            window.location = "/citizen/tab4/";
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
            window.location = "/citizen/tab2/";
        }
    });
});
</script>

<script>
if($("input[name='are_you_handicapped']:checked").val()=='N')
{
    $("#Handicap_id_div").hide();
    $("#Handicap_percentage_div").hide();
}
</script>

<script>
function handicap()
{
    if($("input[name='are_you_handicapped']:checked").val()=='N')
    {
        $("#Handicap_id_div").hide();
        $('#Handicap_id_div').removeAttr('required');
        $("#Handicap_percentage_div").hide();
        $('#Handicap_percentage_div').removeAttr('required');
    }
    else
    {
        $("#Handicap_id_div").show();
        $('#Handicap_id_div').attr('required', 'required');
        $("#Handicap_percentage_div").show();
        $('#Handicap_percentage_div').attr('required', 'required');
    }
}
</script>






<script>
if($("input[name='any_disease']:checked").val()=='N')
{
    $("#which_diseases_div").hide();
}
</script>

<script>
$("#any_disease").on('change',function()
{
    $("#which_diseases_div").show();
});
</script>

<script>
    
function disease()
{
    alert($("input[name='any_disease']:checked").val());
    if($("input[name='any_disease']:checked").val()=='N')
    {
        $("#which_diseases_div").hide();
    }
    else
    {
        $("#which_diseases_div").show();
    }
//    which_diseases[]
}
</script>




