<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report of Incomplete Entries') }}
        </h2>
    </x-slot>

    <style>
        .dropdown-btn 
        {
            display: inline-block;
            *display: inline;
            padding: 20px 20px 20px;
            margin: 10px 0; 
        }
        .table-bordered td, .table-bordered th{border: 1px solid black;}
    </style>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div id="List_Dashboard">
                    @php
                        $count = 0;
                    @endphp
                    @foreach($Incomplete_Entries as $item)  
                        @php
                            $count = $count + $item->total;
                        @endphp
                    @endforeach
                
                    @php
                        $i=1;
                    @endphp
                    <table class="table table-bordered border-dark text-center">
                        <tr style="background-color:#0d3d54;color:white">
                            <td class="fw-bolder">Sr.No</td>
                            <td class="fw-bolder">Taluka Name</td>
                            <td class="fw-bolder">UserName</td>
                            <td class="fw-bolder">No of Records</td>
                        </tr>
                        <tr style="background-color:#d9d9d9;">
                            <td  class="fw-bolder" scope="row">-</td>
                            <td  class="fw-bolder">Total</td>
                            <td  class="fw-bolder"></td>
                            <td  class="fw-bolder">{{$count}}</td>
                        </tr> 
                        @foreach($Incomplete_Entries as $item)
                            <tr style="background-color:white;">
                                <td scope="row">{{$i}}</td>
                                <td>{{ $item->Name }}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->total}}</td>
                            </tr> 
                            @php
                                $i++
                            @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>