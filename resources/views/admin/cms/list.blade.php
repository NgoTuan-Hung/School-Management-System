@extends('layouts.app')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Content List</h1>
          </div>
      

         
          
        </div>
      </div><!-- /.container-fluid -->
    </section>




    <!-- Main content -->
    <section class="content">


      <div class="container-fluid">
        <div class="row">
       
          <!-- /.col -->
          <div class="col-md-12">

             @include('_message')
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Home Content</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Small Title</th>
                        <th>School Pic</th>
                        <th>About Us Pic</th>
                        <th>Created Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($getContent as $value)
                        <tr>
                        <td>{{$value->title}}</td>
                        <td>{{$value->small_title}}</td>
                        <td>
                          @if(!empty($value->getProfileDirect()))
                              <img src="{{ $value->getProfileDirect() }}" style="height: 50px; width:50px; border-radius: 50px;">
                          @else
                              <img src="{{ asset('public/assets/img/default-school-pic.jpg') }}" style="height: 50px; width:50px; border-radius: 50px;">
                          @endif
                      </td>
                      
                      <td>
                          @if(!empty($value->getProfileDirectUs()))
                              <img src="{{ $value->getProfileDirectUs() }}" style="height: 50px; width:50px; border-radius: 50px;">
                          @else
                              <img src="{{ asset('public/assets/img/default-about-us-pic.jpg') }}" style="height: 50px; width:50px; border-radius: 50px;">
                          @endif
                      </td>
                      
                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                        <td>
                          <a href="{{ url('admin/cms/edit/'.$value->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                      </tr>
                          
                        @endforeach
                        
                    </tbody>
                  </table>

                  </div>
                </div>
              </form>

               
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Search Class Timetable</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                    <a href="{{ url('admin/class_timetable/list') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>
                  </div>
                  </div>
                </div>
            </div>

              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
   
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection


@section('script')

<script type="text/javascript">
    $('.getClass').change(function() {
        var class_id = $(this).val();
        $.ajax({
          url: "{{ url('admin/class_timetable/get_subject') }}",
          type: "POST",
          data:{
            "_token": "{{ csrf_token() }}",
            class_id:class_id,
           },
           dataType:"json",
           success:function(response){
              $('.getSubject').html(response.html);
           },
      });

    });
</script>

@endsection