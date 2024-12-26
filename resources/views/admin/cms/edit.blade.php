@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Content</h1>
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
                    <label>Title</label>
                    <input type="text" class="form-control" value="{{ $getRecord->title }}" name="title" required placeholder="">
                  </div>
                    <div class="form-group">
                      <label>Small Title</label>
                      <input type="text" class="form-control" value="{{ $getRecord->small_title }}" name="small_title" required placeholder="">
                    </div>

                  <div class="form-group">
                    <label>School Pic <span style="color: red;"></span></label>
                    <input type="file" class="form-control" name="profile_pic" >
                    <div style="color:red">{{ $errors->first('profile_pic') }}</div>
                    @if(!empty($getRecord->getProfileDirect()))
                    <img src="{{  $getRecord->getProfileDirect() }}" style="width: auto;height: 50px;"> 
                    @endif
                </div>
                
                
                <div class="form-group">
                  <label>About Us Pic <span style="color: red;"></span></label>
                  <input type="file" class="form-control" name="about_us_pic" >
                  <div style="color:red">{{ $errors->first('about_us_pic') }}</div>
                  @if(!empty($getRecord->getProfileDirectUs()))
                  <img src="{{  $getRecord->getProfileDirectUs() }}" style="width: auto;height: 50px;"> 
                  @endif
              </div>


                <div class="form-group">
                  <label>About us</label>
                  <textarea id="compose-textarea" name="about_us" class="form-control" style="height: 300px">{{ $getRecord->about_us}}</textarea>
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

@section('script')

	<script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>


	<script type="text/javascript">	
	
		  $(function () {

		  	$('#compose-textarea').summernote({
			  height: 200
			});
		    
		  
		  });

	</script>
@endsection