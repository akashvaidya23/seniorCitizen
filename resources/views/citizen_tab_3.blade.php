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
                <form id="validate_form" method="POST" data-parsley-validate action="#">
                    @csrf
                        <div class="col-6">
                            <div>
                                <x-jet-label for="any_disease" value="{{ __('आपणास काही आजार आहेत का?') }}" />
                                <div class="custom-control custom-radio custom-control-inline">
                                    
                                    @if(isset($c[0]->any_disease) && $c[0]->any_disease == 'Y' )    
                                        <input type="radio" id="any_disease" onclick="disease()" value="Y" name="any_disease" class="custom-control-input" checked required>
                                    @else
                                        <input type="radio" id="any_disease" onclick="disease()" value="Y" name="any_disease" class="custom-control-input" required>
                                    @endif
                                        <label class="custom-control-label" for="any_disease">होय</label >
                                </div>
                                
                                <div class="custom-control custom-radio custom-control-inline">
                                    @if(isset($c[0]->any_disease) && $c[0]->any_disease == 'N' )    
                                        <input type="radio" id="any_disease2" value="N" onclick="disease()" name="any_disease" class="custom-control-input" checked>
                                    @elseif($c[0]->any_disease == '0')
                                        <input type="radio" id="any_disease2" value="N" onclick="disease()" name="any_disease" class="custom-control-input" checked>
                                    @else    
                                        <input type="radio" id="any_disease2" value="N" onclick="disease()" name="any_disease" class="custom-control-input">
                                    @endif
                                        <label class="custom-control-label" for="any_disease2">नाही</label>
                                </div>
                            </div>
                        </div>
                   
                        <br>

                        @if(isset($c[0]->any_disease) && $c[0]->any_disease!='' && $c[0]->any_disease == 'Y' )    
                            <div id="which_diseases_div" class="col-6">
                        @else
                            <div id="which_diseases_div" class="col-6" style="display:none;">
                        @endif
                            <x-jet-label for="which_diseases[]" value="{{ __('आजार, असल्यास  कधीपासून आहे?') }}" />
                            <div class="list-group">
                                <table>
                                    @php
                                    $i = 1;
                                    $date_key = -1;
                                    @endphp

                                    @foreach ($diseases as $key => $value)
                                        @foreach($citizen_diseases as $key1 => $value1)
                                            @if($value->id == $value1)
                                                @php
                                                    $date_key = $key1;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if(in_array($value->id, $citizen_diseases))
                                                <tr>
                                                <td>
                                                    <input name="which_diseases[]" id="which_diseases_{{$i}}"checked class="disease" type="checkbox" value="{{ $value->id }}" Onclick="daterequired(this)">
                                                    {{ $value->name_of_disease }}
                                                </td>
                                                <td>
                                                    <input name="Disease_start_date[]" id="Disease_start_date_{{$i}}" class="disease" type="date" value="{{$disease_start_date[$date_key]}}">
                                                </td>
                                                </tr>
                                                @else
                                                <tr>
                                                <td>
                                                    <input name="which_diseases[]" id="which_diseases_{{$i}}" class="disease" type="checkbox" value="{{ $value->id }}" Onclick="daterequired(this)">
                                                {{ $value->name_of_disease }}
                                                </td>
                                                <td>
                                                    <input name="Disease_start_date[]" id="Disease_start_date_{{$i}}" class="disease" type="date" value="">
                                                </td>
                                                </tr>
                                                @endif         
                                                @php
                                                    $i++;
                                                    $date_key = -1;
                                                @endphp
                                        @endforeach
                                </table>
                            </div>    
                        </div>   

                    <br>

                   
                    <div class="col-6">

                            <x-jet-label for="Regular_check_up" value="{{ __('आपण वेळोवेळी आरोग्य तपासणी करता का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->Regular_check_up) && $c[0]->Regular_check_up == 'Y' )
                                <input type="radio" checked id="Regular_check_up" value="Y" name="Regular_check_up" class="custom-control-input"required>
                            @else
                            <input type="radio" id="Regular_check_up" value="Y" name="Regular_check_up" class="custom-control-input"required>
                            @endif
                                <label class="custom-control-label" for="Regular_check_up">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->Regular_check_up) && $c[0]->Regular_check_up == 'N' )
                                <input type="radio" id="Regular_check_up2" value="N" name="Regular_check_up" class="custom-control-input" checked>
                            @elseif($c[0]->any_disease == '0')
                                <input type="radio" id="Regular_check_up2" value="N" name="Regular_check_up" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="Regular_check_up2" value="N" name="Regular_check_up" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="Regular_check_up2">नाही</label>
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
                                            @if(isset($c[0]->Hospital_type) && $c[0]->Hospital_type != '' && $c[0]->Hospital_type == $value->id)
                                            <option value="{{ $value->id }}" selected>{{ $value->type_of_hospital }}</option>
                                            @else
                                            <option value="{{ $value->id }}">{{ $value->type_of_hospital }}</option>
                                            @endif
                                        @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="col-6">
                        <div>
                            <x-jet-label for="are_you_handicapped" value="{{ __('आपण दिव्यांग आहात का? (अपंगत्व आहे का?)') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->are_you_handicapped) && $c[0]->are_you_handicapped == 'Y')
                                <input type="radio" id="are_you_handicapped"  onclick="handicap()"  value="Y" name="are_you_handicapped" class="custom-control-input" checked required>
                            @else                                
                            <input type="radio" id="are_you_handicapped"  onclick="handicap()"  value="Y" name="are_you_handicapped" class="custom-control-input" required>
                            @endif
                                <label class="custom-control-label" for="are_you_handicapped">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            @if(isset($c[0]->are_you_handicapped) && $c[0]->are_you_handicapped == 'N')
                                <input type="radio" id="are_you_handicapped2" value="N"  onclick="handicap()"  name="are_you_handicapped" class="custom-control-input" checked>
                            @elseif($c[0]->any_disease == '0')
                                <input type="radio" id="are_you_handicapped2" value="N"  onclick="handicap()"  name="are_you_handicapped" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="are_you_handicapped2" value="N"  onclick="handicap()"  name="are_you_handicapped" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="are_you_handicapped2">नाही</label>
                            </div>
                        </div>
                    </div>

                    <br>
                    @if(isset($c[0]->are_you_handicapped) && $c[0]->are_you_handicapped!='' && $c[0]->are_you_handicapped == 'Y')
                    <div id="Handicap_id_div" class="col-6">
                        @else
                        <div id="Handicap_id_div" class="col-6" style="display:none;">
                        @endif
                            <x-jet-label for="Handicap_id" value="{{ __('असल्यास प्रकार') }}" />
                            <select name="Handicap_id" id="Handicap_id" class="block mt-1 w-full border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option value="">Select type of disabilities</option>
                                        @foreach ($handicap_type as $key => $value)
                                        @if(isset($h[0]->Handicap_id) && $h[0]->Handicap_id!='' && $h[0]->Handicap_id == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->type_of_disability }}</option>
                                        @else
                                        <option value="{{ $value->id }}">{{ $value->type_of_disability }}</option>
                                        @endif
                                        @endforeach
                            </select>
                    </div>

                    <br>
                    @if(isset($c[0]->are_you_handicapped) && $c[0]->are_you_handicapped!='' && $c[0]->are_you_handicapped == 'Y')
                    <div id="Handicap_percentage_div" class="col-6">
                        @else
                        <div id="Handicap_percentage_div" class="col-6" style="display:none;">
                        @endif
                        <div>
                            <x-jet-label for="Handicap_percentage" value="{{ __('असल्यास किती टक्के अपंगत्व आहे?') }}" />
                            @if(isset($h[0]->Handicap_percentage))
                            <x-jet-input id="Handicap_percentage" class="block mt-1 w-full" min="1" max="100" type="number" name="Handicap_percentage" :value="$h[0]->Handicap_percentage" />
                            @else
                            <x-jet-input id="Handicap_percentage" class="block mt-1 w-full" min="1" max="100" type="number" name="Handicap_percentage" :value="old('Handicap_percentage')" />
                            @endif
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
                                        @if(isset($c[0]->daily_chores) && $c[0]->daily_chores !='' && $c[0]->daily_chores == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->type_of_help }}</option>
                                        @else
                                        <option value="{{ $value->id }}">{{ $value->type_of_help }}</option>
                                        @endif
                                        @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <x-jet-button id="Next_Page" class="ml-4">
                        {{ __('Next Page') }}
                    </x-jet-button>            

                    <x-jet-button id="Previous_page" name="Previous_page" class="ml-4">
                        {{ __('Previous Page') }}
                    </x-jet-button>       
                </form>        
            </div>
        </div>
    </div>    
</x-app-layout>

<script language="javascript" type="text/javascript">
jQuery("#validate_form").submit(function(e)
{
    var any_disease = $("input[name='any_disease']:checked").val();
    var which_diseases = [];
    var Disease_start_date = [];
    var id;
    $('.disease').each(function()
    {
        if($(this).is(":checked"))
        {
            which_diseases.push($(this).val());
            id = this.id;
            i = id.split("_");
            Disease_start_date.push($('#Disease_start_date_'+i[2]).val());
        }
    });
    //alert(which_diseases);
    var Regular_check_up = $("input[name='Regular_check_up']:checked").val();
    //alert(Regular_check_up);
    var Hospital_type = $("#Hospital_type").val();
    //alert(Hospital_type);
    var are_you_handicapped = $("input[name='are_you_handicapped']:checked").val();
    //alert(are_you_handicapped);
    var Handicap_id = $("#Handicap_id").val();
    //alert(Handicap_id);
    var Handicap_percentage = $("#Handicap_percentage").val();
//    alert(Handicap_percentage);
    var daily_chores = $("#daily_chores").val();
  //  alert(daily_chore);
    e.preventDefault();
    // alert($('#validate_form').parsley().isValid());

    if($('#validate_form').parsley().isValid())
    {
        //alert("ABCD");
        jQuery.ajax({
        url: '/citizen/tab3/insert',
        data:
        {
            any_disease:any_disease, which_diseases:which_diseases, Regular_check_up:Regular_check_up, Disease_start_date:Disease_start_date,
            Hospital_type:Hospital_type, are_you_handicapped:are_you_handicapped, Handicap_id:Handicap_id,
            Handicap_percentage:Handicap_percentage, daily_chores:daily_chores, _token: '{{csrf_token()}}',
        },
        type: 'POST',
        success:function(result)
        {
            alert("Data Saved Successfully");
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
function handicap()
{
    if($("input[name='are_you_handicapped']:checked").val()=='N')
    {
        $("#Handicap_id_div").hide();
        $('#Handicap_id').removeAttr('required');
        $("#Handicap_percentage_div").hide();
        $('#Handicap_percentage').removeAttr('required');
    }
    else
    {
        $("#Handicap_id_div").show();
        $('#Handicap_id').attr('required', 'required');
        $("#Handicap_percentage_div").show();
        $('#Handicap_percentage').attr('required', 'required');
    }
}
</script>

<!-- <script>
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
</script> -->

<script>
    
function disease()
{
    var i = 1;
    if($("input[name='any_disease']:checked").val()=='N')
    {
        
        $("#which_diseases_div").hide();
            $('input[type=checkbox][name=which_diseases\\[\\]]').each(function(){
            $('#which_diseases_'+i).removeAttr('required');
            i++;
        });
    }
    else
    {
        $("#which_diseases_div").show();
        $('input[type=checkbox][name=which_diseases\\[\\]]').each(function()
        {
            $('#which_diseases_'+i).attr('required', 'required');
            i++;
        });
    }
}
</script>


<script>
    function daterequired(e)
    {
        var id = e.id;
        var i = id.split("_");
        if(e.checked == true)
        {
            $('#Disease_start_date_'+i[2]).attr('required', 'required');
        }
        else
        {
            $('#Disease_start_date_'+i[2]).removeAttr('required');

        }
    }
    </script>



