@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2>My Classes & Subjects</h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Classes & Subjects</li>
            </ol>
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
            
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">My Class & Subject</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Class</th>
                      <th>Subject Name</th>
                      <th>Subject Type</th>
                      <th>Timetable</th>
                      <th>Created At</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($getRecords as $value)
                        <tr>
                          <td>{{ $value->class_name }}</td>
                          <td>{{ $value->subject_name }}</td>
                          <td>{{ $value->subject_type }}</td>
                          <td>
                            @php
                            $ClassSubject = $value->getMyTimeTable($value->class_id, $value->subject_id);
                            @endphp
                            @if($ClassSubject)
                              {{ date('h:i A', strtotime($ClassSubject->start_time)) }} to {{ date('h:i A', strtotime($ClassSubject->end_time)) }}
                              <br />
                              Room No: {{ $ClassSubject->room_number }}
                            @else
                              Not scheduled
                            @endif
                          </td>                                                  
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>    
                          <td>
                            <a href="{{ url('teacher/my_class_subject/class_timetable/'.$value->class_id.'/'.$value->subject_id) }}" class="btn btn-primary">View Timetable</a>
                          </td>    
                        </tr>
                      @endforeach
                      @if(count($getRecords) == 0)
                        <tr>
                          <td colspan="6" class="text-center">No records found</td>
                        </tr>
                      @endif
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
