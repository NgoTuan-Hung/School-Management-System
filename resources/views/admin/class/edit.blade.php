@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Class</h1>
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
            <div class="card card-primary">
              <form method="post" action=""  enctype="multipart/form-data">
                 {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Class Name</label>
                    <input type="text" class="form-control" value="{{ $getRecord->name }}" name="name" required placeholder="Class Name">
                  </div>

                  <div class="form-group">
                    <label>Amount ($)</label>
                    <input type="number" class="form-control" name="amount" value="{{ $getRecord->amount }}" required placeholder="Amount">
                  </div>

                  <div class="form-group">
                    <label>Class Pic <span style="color: red;"></span></label>
                    <input type="file" class="form-control" name="profile_pic" >
                    <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                    @if(!empty($getRecord->getProfile()))
                    <img src="{{  $getRecord->getProfile() }}" style="width: auto;height: 50px;"> 
                    @endif
                </div> 

                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" name="status">
                      <option value="0">Active</option>
                      <option value="1">Inactive</option>
                  </select>
                  
                </div>

              
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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