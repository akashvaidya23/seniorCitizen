<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ज्येष्ठांकडे असलेली कागदपत्रे') }}
        </h2>
    </x-slot>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>

    <div class="py-12">    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form id="validate_form" data-parsley-validate action="/citizen/tab4/insert/" method="POST">
                    @csrf
                        <div>
                            <x-jet-label for="aadhar_card" value="{{ __('आपल्याकडे आधारकार्ड आहे का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                            @if( isset($c[0]->aadhar_card) && $c[0]->aadhar_card == 'Y' )
                                <input type="radio" id="aadhar_card" onclick="aadhar()" value="Y" name="aadhar_card" checked class="custom-control-input" required>
                            @else
                                <input type="radio" id="aadhar_card" onclick="aadhar()" value="Y" name="aadhar_card" class="custom-control-input" required>
                            @endif
                                <label class="custom-control-label" for="aadhar_card">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            
                            @if(isset($c[0]->aadhar_card) && $c[0]->aadhar_card == 'N' )
                                <input type="radio" id="aadhar_card2" value="N" onclick="aadhar()" name="aadhar_card" class="custom-control-input" checked>
                            @elseif($c[0]->aadhar_card == '0')
                                <input type="radio" id="aadhar_card2" value="N" onclick="aadhar()" name="aadhar_card" class="custom-control-input" checked>
                            @else
                                <input type="radio" id="aadhar_card2" value="N" onclick="aadhar()" name="aadhar_card" class="custom-control-input">
                            @endif
                                <label class="custom-control-label" for="aadhar_card2">नाही</label>
                            </div>
                        </div>
                    
                        <br>

                        <div id="aadhar_discrepancy" class="col-6">
                            <x-jet-label for="aadhar_discrepancy" value="{{ __('आधारकार्ड मध्ये काही दुरुस्ती करावयाची आहे का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                
                                @if(isset($c[0]->aadhar_discrepancy) && $c[0]->aadhar_discrepancy == 'Y' && $c[0]->aadhar_card == 'Y' )
                                    <input type="radio" id="aadhar_discrepancy_Y" value="Y" name="aadhar_discrepancy" class="custom-control-input" checked >
                                @else
                                    <input type="radio" id="aadhar_discrepancy_Y" value="Y" name="aadhar_discrepancy" class="custom-control-input" >
                                @endif
                                    <label class="custom-control-label" for="aadhar_discrepancy_Y">होय</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                               
                                @if(isset($c[0]->aadhar_discrepancy) && ($c[0]->aadhar_discrepancy == 'N' || $c[0]->aadhar_discrepancy == '') )    
                                    <input type="radio" id="aadhar_discrepancy_N" value="N" name="aadhar_discrepancy" class="custom-control-input" checked>
                                @elseif($c[0]->aadhar_discrepancy == '0')
                                    <input type="radio" id="aadhar_discrepancy_N" value="N" name="aadhar_discrepancy" class="custom-control-input" checked>
                                @else
                                    <input type="radio" id="aadhar_discrepancy_N" value="N" name="aadhar_discrepancy" class="custom-control-input">
                                @endif
                                    <label class="custom-control-label" for="aadhar_discrepancy_N">नाही</label>
                                </div>
                        </div>

                        <br>

                        <div>
                            <x-jet-label for="Voter_id" value="{{ __('आपल्याकडे मतदार ओळखपत्र आहे का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->Voter_id) && $c[0]->Voter_id == 'Y' )
                                    <input type="radio" checked id="Voter_id" value="Y" name="Voter_id" class="custom-control-input" required>
                                @else
                                    <input type="radio" id="Voter_id" value="Y" name="Voter_id" class="custom-control-input" required>
                                @endif
                                    <label class="custom-control-label" for="Voter_id">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->Voter_id) && $c[0]->Voter_id == 'N' )    
                                    <input type="radio" id="Voter_id2" value="N" name="Voter_id" class="custom-control-input" checked>
                                @elseif($c[0]->Voter_id == '0')
                                    <input type="radio" id="Voter_id2" value="N" name="Voter_id" class="custom-control-input" checked>
                                @else
                                    <input type="radio" id="Voter_id2" value="N" name="Voter_id" class="custom-control-input">
                                @endif
                                    <label class="custom-control-label" for="Voter_id2">नाही</label>
                            </div>
                        </div>

                        <br>

                        <div>
                            <x-jet-label for="Ration_card" value="{{ __('आपल्याकडे शिधापत्रिका (रेशनकार्ड) आहे का? असल्यास कोणती?') }}" />
                            <select name="Ration_card" id="Ration_card" class="block mt-1 border-gray-300
                                    focus:border-indigo-300 focus:ring focus:ring-indigo-300
                                    focus:ring-opacity-50 rounded-md shadow-sm" required>
                                    <option value="">Select type of ration card</option>
                                            @foreach ($ration_card_type as $key => $value)
                                            @if($c[0]->Ration_card == $value->id)
                                                <option value="{{ $value->id }}" selected>{{ $value->type_of_ration_card }}</option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->type_of_ration_card }}</option>
                                            @endif
                                            @endforeach
                            </select>
                        </div>

                        <br>
                        
                        <div>
                            <x-jet-label for="ST_pass" value="{{ __('आपल्याकडे राज्य परिवहन महामंडळाचे (एस.टी.) ज्येष्ठ नागरिक पास आहे का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->ST_pass) && $c[0]->ST_pass == 'Y' )    
                                    <input checked type="radio" id="ST_pass" value="Y" name="ST_pass" class="custom-control-input"required>
                                @else
                                    <input type="radio" id="ST_pass" value="Y" name="ST_pass" class="custom-control-input"required>
                                @endif
                                    <label class="custom-control-label" for="ST_pass">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->ST_pass) && $c[0]->ST_pass == 'N' )        
                                    <input type="radio" id="ST_pass2" value="N" name="ST_pass" class="custom-control-input" checked>
                                @elseif($c[0]->ST_pass == '0')
                                    <input type="radio" id="ST_pass2" value="N" name="ST_pass" class="custom-control-input" checked>
                                @else
                                    <input type="radio" id="ST_pass2" value="N" name="ST_pass" class="custom-control-input">
                                @endif
                                    <label class="custom-control-label" for="ST_pass2">नाही</label>
                            </div>
                        </div>

                        <br><br>

                        <x-jet-button class="ml-4">
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

<script>
jQuery("#validate_form").submit(function(e)
{
    var aadhar_card = $("input[name='aadhar_card']:checked").val();
    var aadhar_discrepancy = $("input[name='aadhar_discrepancy']:checked").val();
    var Voter_id = $("input[name='Voter_id']:checked").val();
    var Ration_card = $("#Ration_card").val();
    var ST_pass = $("input[name='ST_pass']:checked").val();
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/citizen/tab4/insert',
            type: 'POST',
            data:
            {
                aadhar_card:aadhar_card, aadhar_discrepancy:aadhar_discrepancy, Voter_id:Voter_id,
                Ration_card:Ration_card, ST_pass:ST_pass, _token: '{{csrf_token()}}',
            },
            success:function(result)
            {
                //alert(result);
                alert("Data Saved Successfully");
                window.location = "/citizen/tab5/";
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
            window.location = "/citizen/tab3/";
        }
    });
});
</script>

<script>
if($("input[name='aadhar_card']:checked").val()=='N')
{
    //alert("Already Hidden");
    $("#aadhar_discrepancy").hide();
}
</script>

<script>
function aadhar()
{
    //alert($("input[name='Bank_account']:checked").val());
    if($("input[name='aadhar_card']:checked").val()=='N')
    {
        //alert("Hide");
        $("#aadhar_discrepancy").hide();
        $('#aadhar_discrepancy').removeAttr('required');
    }
    else
    {
        //alert("Show");
        $("#aadhar_discrepancy").show();
        $('#aadhar_discrepancy').attr('required', 'required');
    }
}
</script>