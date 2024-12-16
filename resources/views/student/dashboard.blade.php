<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6icR4t/Q5cUnLai5WmP/WLAQ1PJYxcywCwpcc2NmUYADkBh0WNK0U0zIPxp4hK+hTKDvJ5R4R+cBG4LeJe+Yv4" crossorigin="anonymous"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      margin-bottom: 20px;
    }
    .card img {
      width: 100%;
      height: auto;
      max-height: 100px;
      object-fit: contain;
      border-radius: 4px;
    }
    .welcome-message {
      margin-bottom: 20px;
    }
    .more-details {
      display: none; /* Hide additional details initially */
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="welcome-message text-center">
      <h1>Welcome, {{ auth()->user()->name }}!</h1>
    </div>
    
    <h2 class="text-center mb-4">Available Teachers</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="search-form mb-4">
      <form action="{{ route('student.teachers.search') }}" method="GET" class="form-inline justify-content-center">
        <input type="text" name="name" class="form-control mr-2" placeholder="Search by name" value="{{ request('name') }}">
        <input type="text" name="qualifications" class="form-control mr-2" placeholder="Search by qualifications" value="{{ request('qualifications') }}">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
    </div>

    <div class="row">
      @foreach($teachers as $teacher)
        <div class="col-12">
          <div class="card">
            <div class="row no-gutters">
              <div class="col-md-4 d-flex align-items-center justify-content-center">
                @if($teacher->image)
                  <img src="{{ asset('storage/' . $teacher->image) }}" class="card-img" alt="{{ $teacher->user->name }}'s Profile Image">
                @endif
              </div>
              <div class="col-md-8">
                <h5 class="card-title">{{ $teacher->user->name }}</h5>
                <p class="card-text"><strong>Qualifications:</strong> {{ $teacher->qualifications }}</p>
                <div class="more-details" id="teacherDetails{{ $teacher->id }}">
                  <p class="card-text"><strong>Description:</strong> {{ $teacher->description }}</p>
                  <p class="card-text">
                    <strong>Availability:</strong> 
                    {{ $teacher->schedule_availability_start }} to {{ $teacher->schedule_availability_end }}
                    <a href class="btn btn-primary btn-sm ml-2">Book Now</a>
                  </p>
                </div>
                <button class="btn btn-primary toggle-details" aria-expanded="false">
                  <i class="fa fa-chevron-down"></i> View More
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-4">
      <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.toggle-details').click(function() {
        var button = $(this);
        var icon = button.find('i');
        var moreDetails = button.closest('.card').find('.more-details');

        moreDetails.toggle(); // Toggle visibility of more details

        // Update icon and button text based on visibility
        if (moreDetails.is(':visible')) {
          icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
          button.text('View Less');
          button.attr('aria-expanded', 'true');
        } else {
          icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
          button.text('View More');
          button.attr('aria-expanded', 'false');
        }
      });
    });
  </script>
</body>
</html>