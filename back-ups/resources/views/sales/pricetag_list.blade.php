@extends('layouts.main')

@section('content')
            <h1>All price tags</h1>
 
            <div class="card-box">
               

                <div class="card-body">
        

                
                    <a href="{{route('price_tag.create')}}" style="float: right;" class="btn btn-primary">Add Tags</a>
                    <br><br>

 

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Name</th>
                            <th>Buying Price</th> 
                            <th>Selling Price</th> 
                            <th>Action</th>                            
                        </thead>

                        <tbody>                         
                            @foreach($price_tags as $pricetags)
                              <tr>
                                  <td>{{$pricetags->stock->category->name}} ({{$pricetags->stock->name}})</td>
                                  <td>{{number_format($pricetags->buying_price)}}</td>
                                  <td>{{number_format($pricetags->salling_price)}}</td>
                                  <td>
                                    <a href="{{route('price_tag.edit',$pricetags->id)}}">Edit</a>
                                  </td>
                              </tr> 
                            @endforeach

                          
                        </tbody>
                    </table>
                                           
                        
 
                </div>
            </div>

   
@endsection

 