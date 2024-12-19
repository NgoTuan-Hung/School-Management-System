@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Attendance</h1>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Search Student Attendance</h3>
              </div>
              <form method="get" action="">
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-md-3">
                    <label>Class</label>
                    <select class="form-control" name="class_id" id="getClass" required required>
                        <option value="">Select</option>                                              
                        @foreach($getClass as $class)                                         
                          <option {{ (Request::get('class_id') == $class->class_id) ? 'selected' : '' }} value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                  </div>

                   <div class="form-group col-md-3">
                    <label>Attendance Date</label>
                    <input type="date" class="form-control" id="getAttendanceDate" value="{{ Request::get('attendance_date') }}" required name="attendance_date">
                  </div>


                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Search</button>
                    <a href="{{ url('teacher/attendance/student') }}" class="btn btn-success" style="margin-top: 30px;">Reset</a>

                  </div>

                  </div>
                </div>
              </form>
            </div>

            @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
            
                 <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Student List</h3>
                    </div>
                    
                    <div class="card-body p-0" style="overflow: auto;">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Attendance</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(!empty($getStudent) && !empty($getStudent->count()))
                             @foreach($getStudent as $value)
                              @php
                                  $attendance_type = ''; 
                                  $getAttendance = $value->getAttendance($value->id, Request::get('class_id'), Request::get('attendance_date'));

                                  if(!empty($getAttendance->attendance_type))
                                  {
                                      $attendance_type = $getAttendance->attendance_type; 
                                  }

                              @endphp
                               <tr>
                                 <td>{{ $value->id }}</td>
                                 <td>{{ $value->name }} {{ $value->last_name }}</td>
                                 <td>
                                  <label style="margin-right: 10px;">
                                    <input value="1" type="radio" {{ ($attendance_type == '1') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance" name="attendance{{ $value->id }}"> Present
                                  </label>
                                  <label style="margin-right: 10px;">
                                    <input value="2" type="radio" {{ ($attendance_type == '2') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance" name="attendance{{ $value->id }}"> Late
                                  </label>
                                  <label style="margin-right: 10px;">
                                    <input value="3" type="radio" {{ ($attendance_type == '3') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance" name="attendance{{ $value->id }}"> Absent
                                  </label>
                                  <label>
                                    <input value="4" type="radio" {{ ($attendance_type == '4') ? 'checked' : '' }} id="{{ $value->id }}" class="SaveAttendance"  name="attendance{{ $value->id }}"> Half Day
                                  </label>

                                 </td>
                               </tr>
                             @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
            @endif
          </div>
        
        </div>
        
      </div>
    </section>
  </div>

@endsection

@section('script').

<script type="text/javascript">
  $('.SaveAttendance').change(function(e) {

    var student_id = $(this).attr('id');
    var attendance_type = $(this).val();
    var class_id = $('#getClass').val();
    var attendance_date = $('#getAttendanceDate').val();
   
    
    $.ajax({
          type: "POST",
          url: "{{ url('teacher/attendance/student/save') }}",
          data : {
             "_token": "{{ csrf_token() }}",
            student_id : student_id,
            attendance_type : attendance_type,
            class_id : class_id,
            attendance_date : attendance_date,           
          },
          dataType : "json",
          success: function(data) {
              alert(data.message);
          }
      });

  });
</script>

@endsection