<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
        
        <style>
            <style>
        .box
        {
        width:100%;
        max-width:600px;
        background-color:#f9f9f9;
        border:1px solid #ccc;
        border-radius:5px;
        padding:16px;
        margin:0 auto;
        }
        input.parsley-success,
        select.parsley-success,
        textarea.parsley-success 
        {
            color: #468847;
            background-color: #DFF0D8;
            border: 1px solid #D6E9C6;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error 
        {
            color: #B94A48;
            background-color: #F2DEDE;
            border: 1px solid #EED3D7;
        }

        .parsley-errors-list
        {
            margin: 2px 0 3px;
            padding: 0;
            list-style-type: none;
            font-size: 0.9em;
            line-height: 0.9em;
            opacity: 0;

            transition: all .3s ease-in;
            -o-transition: all .3s ease-in;
            -moz-transition: all .3s ease-in;
            -webkit-transition: all .3s ease-in;
        }

        .parsley-errors-list.filled 
        {
            opacity: 1;
        }
        
        .parsley-type, .parsley-required, .parsley-equalto, .parsley-pattern, .parsley-length{
        color:#ff0000;
        }
        </style>

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />
            
        <div id="side-menu" class="side-nav">
            <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>

                <x-jet-nav-link href="{{ route('Divisional_Dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Reports') }}
                </x-jet-nav-link>
                
                @if(Auth::user()->role_id == 4)
                    <x-jet-nav-link href="/all/Incomplete/0" :active="request()->routeIs('dashboard')">
                        {{ __('Incomplete entries') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href='/citizen/tab1/0' :active="request()->routeIs('dashboard')">
                        {{ __('सर्वसाधारण माहिती') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('tab2') }}" :active="request()->routeIs('dashboard')">
                        {{ __('आपल्या कुटुंबातील सदस्य व त्यांचे व्यवसाय') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('tab3') }}" :active="request()->routeIs('dashboard')">
                        {{ __('आरोग्य विषयक माहिती') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('tab4') }}" :active="request()->routeIs('dashboard')">
                        {{ __('ज्येष्ठांकडे असलेली कागदपत्रे') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('tab5') }}" :active="request()->routeIs('dashboard')">
                        {{ __('योजनांचा लाभ घेत असल्यास माहिती') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('tab6') }}" :active="request()->routeIs('dashboard')">
                        {{ __('इतर माहिती') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('List') }}" :active="request()->routeIs('dashboard')">
                        {{ __('List') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab1') }}" :active="request()->routeIs('dashboard')">
                        {{ __('सर्वसाधारण माहिती चे Reports') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab2') }}" :active="request()->routeIs('dashboard')">
                        {{ __('आपल्या कुटुंबातील सदस्य व त्यांचे व्यवसाय चे Reports') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab3') }}" :active="request()->routeIs('dashboard')">
                        {{ __('आरोग्य विषयक माहिती चे Reports') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab4') }}" :active="request()->routeIs('dashboard')">
                        {{ __('ज्येष्ठांकडे असलेल्या कागदपत्रांचे Reports') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab5') }}" :active="request()->routeIs('dashboard')">
                        {{ __('योजनांचा लाभ घेत असल्यास माहिती चे Reports') }}
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('ReportsTab6') }}" :active="request()->routeIs('dashboard')">
                        {{ __('इतर माहिती चे Reports') }}
                    </x-jet-nav-link>

                    
                @endif
            @if(Auth::user()->role_id != 4)
                <x-jet-nav-link href="{{ route('CreateUser') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Create new user') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('ListUser') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage users') }}
                </x-jet-nav-link>
            @endif
            @if( Auth::user()->role_id == 2)
                <x-jet-nav-link href="{{ route('Incomplete_Entries') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Incomplete Entries') }}
                </x-jet-nav-link>
            @endif
            @if(Auth::user()->role_id == 1)
                <x-jet-nav-link href="{{ route('dashboardAccess') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Create new access') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateAction') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Action') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateDisease') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage disease') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateBank') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage bank types') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateDegree') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage degree') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateScheme') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Govt. Scheme') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateHandicapType') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage type of handicaps') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateHelpType') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage type of help') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateHobby') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage hobbies') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('Createhome') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage types of home') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateHospital') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage types of hospital') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateIncome') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage types of income source') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateEquipment') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage medical equipments') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreatePage') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Pages') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateRelation') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Relations') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateRole') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Roles') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateSocial') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage Social Services') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateStove') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage type of stove') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateTeaching') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage teaching skill') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateTool') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage tools') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateWork') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage types of work') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateRation') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage type of ration Card') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateDistrict') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage districts') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('CreateTaluka') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage talukas') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('ListVillage') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Manage villages') }}
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('Incomplete_Entries') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Incomplete Entries') }}
                </x-jet-nav-link>
            @endif
        </div>

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
              
            <!-- Page Content -->
            <main style="background-color:#ffffff">
                {{ $slot }}
            </main>

        </div>

        @stack('modals')
    </body>

</html>
<script>
    function openSlideMenu()
    {
        document.getElementById('side-menu').style.width= '250px';
        document.getElementById('main').style.marginLeft= '250px';
    }

    function closeSlideMenu()
    {
        document.getElementById('side-menu').style.width= '0';
        document.getElementById('main').style.marginLeft= '0';
    }
</script>

<style>
.navbar
{
    background-color: #8D9FAE;
    overflow: hidden;
    height: 60px;
}

.navbar a
{
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    opacity: 1;
}

.navbar ul
{
    margin:8px 0 0 0;
    list-style: none;
}

.navbar a:hover
{
    background-color: #ddd;
    color: #000;
}

.side-nav
{
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    opacity: 0.9;
    overflow-x: hidden;
    padding-top: 60px;
    transition: 0.5s;
}

.side-nav a
{
    padding: 10px 10px 10px 30px;
    text-decoration: none;
    font-size: 22px;
    color: #ccc;
    display: block;
    transition: 0.3s;
}

.side-nav a:hover
{
    color: #fff;
}

.side-nav .btn-close
{
    position:absolute;
    top: 0;
    right: 22px;
    font-size: 36px;
    margin-left: 50px;
}

#main
{
    padding: 20px;
    overflow: hidden;
    width: 100%;
}

#header
{
    padding: 20px;
    overflow: hidden;
    width: 100%;
}

@media(max-width:568px)
{
    .navbar-nav{display:none}
}
</style>