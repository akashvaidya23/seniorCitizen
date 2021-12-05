                    @php
                        $count = 0;
                        $countI = 0;
                    @endphp
                    
                    @foreach($taluka_count as $item)    
                        @php
                            $count = $count + $item->total;
                        @endphp
                    @endforeach

                    @foreach($Incomplete_Entries as $I)
                        @php
                            $countI = $countI + $I->total;
                        @endphp
                    @endforeach
                    
                    @php
                        $i=1;
                    @endphp
                    
                    <table class="table table-bordered border-dark text-center">
                        <tr style="background-color:#0d3d54;color:white">
                            <td class="fw-bolder">Sr.No</td>
                            <td class="fw-bolder">Name</td>
                            <td class="fw-bolder">No of Records</td>
                            <td class="fw-bolder">No of Incomplete Records</td>
                        </tr>
                        <tr style="background-color:#d9d9d9">
                                <td  class="fw-bolder" scope="row">-</td>
                                <td  class="fw-bolder">Total</td>
                                <td  class="fw-bolder">{{$count}}</td>
                                <td  class="fw-bolder">{{$countI}}</td>
                        </tr> 
                        @php
                            $j=1
                        @endphp

                        @foreach($taluka_count as $item)
                            <tr style="background-color:white;">
                                <td scope="row">{{$j}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->total}}</td>
                                @php
                                    $Flag = False;
                                @endphp
                                @foreach($Incomplete_Entries as $I)
                                    @if($item->VID == $I->id)
                                        @php
                                            $Flag = True;
                                        @endphp
                                        <td>{{$I->total}}</td>
                                    @endif
                                @endforeach
                                    @if($Flag == False)
                                        <td>0</td>                                        
                                    @endif
                            </tr>    
                                @php
                                    $j++;
                                @endphp
                        @endforeach