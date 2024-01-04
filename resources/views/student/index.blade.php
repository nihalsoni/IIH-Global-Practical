<!-- index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="toast-container" style="position: fixed; top: 0; right: 0; margin: 15px; z-index: 1050;"></div>
    <button id="addStudent" class="btn btn-primary">Add Student</button>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Skills</th>
                <th>State</th>
                <th>City</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="studentsTableBody">
            <!-- Table rows here -->
        </tbody>
    </table>

    <!-- Add/Edit Student Modal -->
    {{-- <div class="modal" id="studentModal" tabindex="-1" role="dialog"> --}}
    <div class="modal" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- Modal content here -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Student</h5>
                    <button type="button" class="close close-model" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form id="studentForm">
                        <!-- Form fields here -->
                        <input type="hidden" id="student_id" name="student_id">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Gender</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="male" checked>Male
                                <label class="form-check-label" for="radio1"></label>
                              </div>
                              <div class="form-check">
                                <input type="radio" class="form-check-input" id="gender" name="gender" value="female">Female
                                <label class="form-check-label" for="radio2"></label>
                              </div>
                        </div>
                        <div class="form-group">
                            <label for="dob">Skills</label>
                            <select class="form-select" id="skills" name="skills[]" multiple aria-label="Select Skills" required>
                                {{-- <option selected>Open this select menu</option> --}}

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-select" id="state" name="state" aria-label="Select State">
                                {{-- <option selected>Open this select menu</option> --}}

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <select class="form-select" id="city" name="city" aria-label="Select City">
                                {{-- <option selected>Open this select menu</option> --}}

                            </select>
                        </div>
                        <!-- Add other form fields here -->

                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-OLeU65nHv8iSHtWVEd/Z0CpIjx6e1ssO7uYhCyDYjzA=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-rZyo1BRqGi5WXjNl50ElZJTKpCF3/9zQd3UMWuX6ZlEEJ2HyjE+0Bp5C2tL5kNt" crossorigin="anonymous"></script> --}}
<script src="{{ asset('js/student.js') }}"></script>

@endsection
