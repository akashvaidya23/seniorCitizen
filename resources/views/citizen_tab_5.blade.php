<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('योजनांचा लाभ घेत असल्यास माहिती') }}
        </h2>
    </x-slot>

    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->

    <div class="py-12">
        <div class="wrapper">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form id="validate_form" data-parsley-validate action="/citizen/tab5/insert/" method="POST">
                        @csrf
                        
                        <div>
                            
                            <x-jet-label for="Govt_schemes" value="{{ __('आपण शासनाच्या योजनेचा लाभ घेतला आहे का?') }}" />
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->Govt_schemes) && $c[0]->Govt_schemes == 'Y' )
                                    <input type="radio" id="Govt_schemes" onclick="scheme()" value="Y" name="Govt_schemes" class="custom-control-input" checked required>
                                @else
                                    <input type="radio" id="Govt_schemes" onclick="scheme()" value="Y" name="Govt_schemes" class="custom-control-input" required>
                                @endif
                                    <label class="custom-control-label" for="Govt_schemes">होय</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                @if(isset($c[0]->Govt_schemes) && $c[0]->Govt_schemes == 'N' )
                                    <input type="radio" id="Govt_schemes2" value="N" onclick="scheme()" name="Govt_schemes" class="custom-control-input" required checked>
                                @elseif($c[0]->Govt_schemes == '0')
                                    <input type="radio" id="Govt_schemes2" value="N" onclick="scheme()" name="Govt_schemes" class="custom-control-input" checked>
                                @else
                                    <input type="radio" id="Govt_schemes2" value="N" onclick="scheme()" name="Govt_schemes" class="custom-control-input" required>
                                @endif
                                    <label class="custom-control-label" for="Govt_schemes2">नाही</label>
                            </div>
                        </div>
                        
                        <br>
                        
                        @if(isset($c[0]->Govt_schemes) && $c[0]->Govt_schemes == 'Y')
                        <div id="Govt_scheme_name_div">
                        @else
                        <div id="Govt_scheme_name_div" style="display:none;">
                        @endif
                            <x-jet-label for="Govt_scheme_name[]" value="{{ __('असल्यास कोणत्या?') }}" />
                            @php
                                $i=1
                            @endphp
                            @foreach ($govt_scheme_type as $key => $val)
                                @if(in_array($val->id, $citizen_schemes))
                                    <li>
                                        <input id="Govt_scheme_name_{{$i}}" class="scheme" name="Govt_scheme_name[]" class="form-check-input me-1" type="checkbox" value="{{ $val->id }}" checked>
                                        {{ $val->type_of_govt_scheme }}
                                    </li>
                                @else
                                    <li>
                                        <input id="Govt_scheme_name_{{$i}}" class="scheme" name="Govt_scheme_name[]" class="form-check-input me-1" type="checkbox" value="{{ $val->id }}">
                                        {{ $val->type_of_govt_scheme }}
                                    </li>
                                @endif
                                @php
                                    $i++
                                @endphp
                            @endforeach
                        </div>

                        <br>
                        <br>
                        <x-jet-button class="ml-4">
                            {{ __('Next Page') }}
                        </x-jet-button>  

                        <x-jet-button class="ml-4">
                            {{ __('Previous Page') }}
                        </x-jet-button>       
                                  
                    </form>        
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>

<script>
jQuery("#validate_form").submit(function(e)
{
    var Govt_schemes = $("input[name='Govt_schemes']:checked").val();
    var Govt_scheme_name = [];
    $('.scheme').each(function()
    {
        if($(this).is(":checked"))
        {
            Govt_scheme_name.push($(this).val());
        }
    });
    //alert(Govt_scheme_name);
    e.preventDefault();
    if($('#validate_form').parsley().isValid())
    {
        jQuery.ajax({
            url: '/citizen/tab5/insert',
            type: 'POST',
            data:
            {
                Govt_schemes:Govt_schemes, Govt_scheme_name:Govt_scheme_name, _token: '{{csrf_token()}}',
            },
            success:function(result)
            {
                alert("Data Saved Successfully");
                window.location = "/citizen/tab6/";
            }
        });
    }
});
</script>

<script>
if($("input[name='Govt_schemes']:checked").val()=='N')
{
    $("#Govt_scheme_name_div").hide();
}
</script>

<script>
jQuery("#Previous_page").click(function(e)
{
    jQuery.ajax({
        success:function(result)
        {
            window.location = "/citizen/tab4/";
        }
    });
});
</script>

<script>
    
function scheme()
{
    var i=1;
    if($("input[name='Govt_schemes']:checked").val()=='N')
    {

        $("#Govt_scheme_name_div").hide();
            $('input[type=checkbox][name=Govt_scheme_name\\[\\]]').each(function(){
             
            $('#Govt_scheme_name_'+i).removeAttr('required');
            i++;
        });
    }
    else
    {
        $("#Govt_scheme_name_div").show();
        $('input[type=checkbox][name=Govt_scheme_name\\[\\]]').each(function()
        {
            $('#Govt_scheme_name_'+i).attr('required', 'required');
            i++;
        });
    }
}
</script>
