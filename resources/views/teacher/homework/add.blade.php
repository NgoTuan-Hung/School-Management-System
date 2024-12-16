@extends('layouts.base')
@section('custom-style')
<style>
  .form-section {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
  .form-header {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 15px;
  }
  .form-control {
    border-radius: 4px;
    border: 1px solid #ddd;
  }
</style>
@endsection
@section('main-content')
<div class="wrapper">
  <header class="page-header">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="form-header">Add Homework Details</h1>
        </div>
      </div>
    </div>
  </header>

  <main class="page-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          @include('alerts.message')
          <div class="form-section">
            <form method="POST" action="{{ route('homework.create') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="classDropdown">Class <span class="text-danger">*</span></label>
                <select class="form-select" id="classDropdown" name="class_id" required>
                  <option value="">-- Select Class --</option>
                  @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="subjectDropdown">Subject <span class="text-danger">*</span></label>
                <select class="form-select" id="subjectDropdown" name="subject_id" required>
                  <option value="">-- Choose Subject --</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="homeworkDate">Homework Date <span class="text-danger">*</span></label>
                <input type="date" id="homeworkDate" class="form-control" name="homework_date" required>
              </div>

              <div class="mb-3">
                <label for="dueDate">Submission Date <span class="text-danger">*</span></label>
                <input type="date" id="dueDate" class="form-control" name="submission_date" required>
              </div>

              <div class="mb-3">
                <label for="documentInput">Attach Document</label>
                <input type="file" id="documentInput" class="form-control" name="document">
              </div>

              <div class="mb-3">
                <label for="descriptionEditor">Homework Description <span class="text-danger">*</span></label>
                <textarea id="descriptionEditor" name="description" class="form-control" rows="6"></textarea>
              </div>

              <div class="mb-3">
                <label for="tags">Homework Tags</label>
                <input type="text" id="tags" class="form-control" name="tags" placeholder="e.g. Math, Algebra, Grade 7">
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Submit Homework</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
@endsection

@section('custom-scripts')
<script src="{{ asset('assets/js/summernote-lite.min.js') }}"></script>
<script>
$(document).ready(function() {
  $('#descriptionEditor').summernote({
    placeholder: 'Enter homework details...',
    tabsize: 2,
    height: 250
  });

  $('#classDropdown').on('change', function() {
    const selectedClass = $(this).val();
    if (selectedClass) {
      $.ajax({
        url: "{{ route('ajax.fetchSubjects') }}",
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          class_id: selectedClass
        },
        success: function(data) {
          $('#subjectDropdown').html(data);
        },
        error: function() {
          alert('Failed to fetch subjects.');
        }
      });
    } else {
      $('#subjectDropdown').html('<option value="">-- Choose Subject --</option>');
    }
  });

  $('#tags').on('blur', function() {
    const tags = $(this).val();
    if (tags) {
      const tagList = tags.split(',').map(tag => tag.trim());
      console.log('Tags:', tagList);
    }
  });
});
</script>
@endsection
