@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
               

                <div class="card-body">
                    <h1>All price tags</h1>

                
                    <a href="{{route('price_tag.create')}}" style="float: right;" class="btn btn-primary">Add Tags</a>
                    <br><br>

 

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Name</th>
                            <th>Buying Price</th> 
                            <th>Salling Price</th> 
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
     <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
     <script>
       $(document).ready(function() {
              $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                        messageTop: '{{$title}}'
                    },
                    {
                        extend: 'pdf',
                        messageTop: '{{$title}}'
                    },
                    {
                        extend: 'csv',
                        messageTop: null
                    }
                ]
            } );
        } );
    </script>

@endpush