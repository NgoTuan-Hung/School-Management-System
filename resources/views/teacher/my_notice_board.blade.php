@extends('layouts.app')

@section('content')

 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Notice Board</h1> 
          </div>         
        </div>
      </div>
    </section>

    

       @foreach($getRecord as $notice)
        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5>{{ $notice->title }}</h5>
                <h6 style="margin-top: 10px;"> 
                  {{ date('d-m-Y', strtotime($notice->notice_date)) }} 
                </h6>
              </div>
              <div class="mailbox-read-message">
                  {!! $notice->message !!}
              </div>
            </div>
          </div>
        </div>
       @endforeach

        <div class="col-md-12">
          <!-- Pagination -->
          <div style="padding: 10px; float: right;">
            {!! $getRecord->appends(Request::except('page'))->links() !!}
          </div>
        </div>

      </div>
    </section>
 </div>

@endsection
