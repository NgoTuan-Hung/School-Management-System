@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Students - List</h1>
          </div>
        </div>
      </div>
    </section>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student Records</h3>
              </div>
              <div class="card-body p-0" style="overflow: auto;">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Profile Pic</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Admission #</th>
                      <th>Roll #</th>
                      <th>Class</th>
                      <th>Gender</th>
                      <th>Date of Birth</th>
                      <th>Caste</th>
                      <th>Religion</th>
                      <th>Phone</th>
                      <th>Admission Date</th>
                      <th>Blood Group</th>
                      <th>Height</th>
                      <th>Weight</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($getRecord as $record)
                      <tr>
                        <td>{{ $record->id }}</td>
                        <td>
                          @if($record->getProfile())
                            <img src="{{ $record->getProfile() }}" style="height: 45px; width:45px; border-radius: 50%;"/>
                          @else
                            <img src="/default-profile.jpg" style="height: 45px; width:45px; border-radius: 50%;"/>
                          @endif
                        </td>
                        <td>{{ $record->name }} {{ $record->last_name }}</td>
                        <td>{{ $record->email }}</td>
                        <td>{{ $record->admission_number }}</td>
                        <td>{{ $record->roll_number }}</td>
                        <td>{{ $record->class_name }}</td>
                        <td>{{ $record->gender }}</td>
                        <td>
                          @if($record->date_of_birth)
                            {{ date('d-m-Y', strtotime($record->date_of_birth)) }}
                          @else
                            N/A
                          @endif
                        </td>
                        <td>{{ $record->caste }}</td>
                        <td>{{ $record->religion }}</td>
                        <td>{{ $record->mobile_number }}</td>
                        <td>
                          @if($record->admission_date)
                            {{ date('d-m-Y', strtotime($record->admission_date)) }}
                          @else
                            N/A
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

                <div style="padding: 10px; float: right;">
                  {!! $getRecord->appends(Request::except('page'))->links() !!}
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
