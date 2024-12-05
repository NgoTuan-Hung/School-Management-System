@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Profile</h1>
          </div>
    
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">

               @include('_messages')  
            <div class="card card-primary">
              <form method="post" action="" enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>First Name <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('name', $getRecord->first_name) }}" name="first_name" required placeholder="First Name">
                      <div style="color:red">{{ $errors->first('first_name') }}</div>  
                    </div>  

                    <div class="form-group col-md-6">
                      <label>Last Name <span style="color: red;">*</span></label>
                      <input type="text" class="form-control" value="{{ old('surname', $getRecord->last_name) }}" name="last_name" required placeholder="Last Name">
                      <div style="color:red">{{ $errors->first('surname') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>Gender <span style="color: red;">*</span></label>
                      <select class="form-control" required name="gender_id">
                          <option value="">Select Gender</option>
                          <option {{ (old('gender_id', $getRecord->gender_id) == 'Male') ? 'selected' : '' }} value="Male">Male</option>  
                          <option {{ (old('gender_id', $getRecord->gender_id) == 'Female') ? 'selected' : '' }} value="Female">Female</option>  
                          <option {{ (old('gender_id', $getRecord->gender_id) == 'Other') ? 'selected' : '' }} value="Other">Other</option>  
                      </select>
                      <div style="color:red">{{ $errors->first('gender_id') }}</div> 
                    </div>  

                    <div class="form-group col-md-6">
                      <label>Date of Birth <span style="color: red;">*</span></label>
                      <input type="date" class="form-control" required value="{{ old('dob', $getRecord->date_of_birth) }}" name="dob" >
                      <div style="color:red">{{ $errors->first('dob') }}</div>
                    </div>  

                    <div class="form-group col-md-6">
                      <label>Mobile Number <span style="color: red;"></span></label>
                      <input type="tel" class="form-control" value="{{ old('phone_number', $getRecord->mobile_number) }}" name="phone_number"  placeholder="Mobile Number"> 
                      <div style="color:red">{{ $errors->first('phone_number') }}</div> 
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Marital Status  <span style="color: red;"></span></label>
                      <input type="text" class="form-control" value="{{ old('marital_status', $getRecord->marital_status) }}" name="marital_status"  placeholder="Marital Status">
                      <div style="color:red">{{ $errors->first('marital_status') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Profile Picture  <span style="color: red;"></span></label>
                      <input type="file" class="form-control" name="profile_picture" >  
                      <div style="color:red">{{ $errors->first('profile_picture') }}</div>  
                        @if(!empty($getRecord->getProfileImage()))
                        <img src="{{  $getRecord->getProfileImage() }}" style="width: auto;height: 60px;">  
                      @endif
                    </div> 

                     <div class="form-group col-md-6">
                      <label>Current Address  <span style="color: red;">*</span></label>
                      <textarea class="form-control" name="current_address" required>{{ old('current_address', $getRecord->address) }}</textarea>  
                      <div style="color:red">{{ $errors->first('current_address') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Permanent Address  <span style="color: red;"></span></label>
                      <textarea class="form-control" name="permanent_address" >{{ old('permanent_address', $getRecord->permanent_address) }}</textarea>
                      <div style="color:red">{{ $errors->first('permanent_address') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Qualification  <span style="color: red;"></span></label>
                      <textarea class="form-control" name="qualification" >{{ old('qualification', $getRecord->qualification) }}</textarea>
                      <div style="color:red">{{ $errors->first('qualification') }}</div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label>Work Experience  <span style="color: red;"></span></label>
                      <textarea class="form-control" name="work_experience" >{{ old('work_experience', $getRecord->work_experience) }}</textarea>
                      <div style="color:red">{{ $errors->first('work_experience') }}</div>
                    </div> 

                  </div>

                  <hr />


                  <div class="form-group">
                    <label>Email <span style="color: red;">*</span></label>
                    <input type="email" class="form-control" name="user_email" value="{{ old('email', $getRecord->email) }}" required placeholder="Email">
                    <div style="color:red">{{ $errors->first('user_email') }}</div>  
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save Changes</button> 
                </div>
              </form>
            </div>
         

          </div>
          <!--/.col (left) -->
          <!-- right column -->
       
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
