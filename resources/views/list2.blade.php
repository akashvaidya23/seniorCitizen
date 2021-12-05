<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="https://fonts.googleapis.com/css2?family=Hind&display=swap" rel="stylesheet">

List of the citizens

    <style>
        .table-bordered td, .table-bordered th{border: 1px solid black;}
        .table-bordered td, .table-bordered th{border: 1px solid black;}
        #citizen{
            border-collapse: collapse;
            width: 100%;
        }
        #citizen td, #citizen th{
            border: 1px solid black;
            padding: 8px;
        }
        body 
        {
            font-size:13px;
            font-family: 'Hind', serif;
        }
        #header 
        { 
            position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; text-align: center; 
        }
        .page-break 
        {
            page-break-after: always;
        }
    </style>

    @php
        $i=1;
    @endphp
    <div>
        <table class="table table-striped table-bordered border-dark text-center">
            <tr id="header">
                <td class="fw-bolder">Sr.No</td>
                <td class="fw-bolder">Reference No</td>
                <td class="fw-bolder">संपूर्ण नाव</td>
                <td class="fw-bolder">जन्मतारीख</td>
                <td class="fw-bolder">मोबाईल नंबर</td>
            </tr>
        
            @foreach($details_of_citizens as $item)
                <tr id="{{$item->id}}">
                    <td scope="row">{{ $i }}</td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->Full_name}}</td>
                    <td>{{date('d-M-Y', strtotime($item->date_of_birth))}}</td>
                    <td>{{$item->Mobile_no}}</td>
                </tr>
                @if($i % 20 == 0)
                    <div class="page-break"></div>
                @endif
                @php
                    $i++;
                @endphp
            @endforeach
        </table>
    </div>