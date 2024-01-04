$(document).ready(function () {
    // Fetch students and populate the table
    fetchStudents();
    fetchSkills();
    fetchStates();
    // Initialize jQuery Validation Plugin for the studentForm
    $('#studentForm').validate({
        errorClass: 'error-text-red',
        validClass: 'valid-text-green',
        rules: {
            firstname: {
                required: true,
                maxlength: 255
            },
            lastname: {
                required: true,
                maxlength: 255
            },
            dob: {
                required: true,
                date: true
            },
            gender: {
                required: true
            },
            skills: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            }
        },
        messages: {
            firstname: {
                required: "Please enter your first name",
                maxlength: "First name cannot exceed 255 characters"
            },
            lastname: {
                required: "Please enter your last name",
                maxlength: "Last name cannot exceed 255 characters"
            },
            dob: {
                required: "Please enter your date of birth",
                date: "Please enter a valid date"
            },
            gender: {
                required: "Please select your gender"
            },
            skills: {
                required: "Please select at least one skill"
            },
            state: {
                required: "Please select your state"
            },
            city: {
                required: "Please select your city"
            }
        },
        submitHandler: function (form) {
            saveStudent();
        }
    });

    // Open the modal for adding a new student
    $('#addStudent').on('click', function () {
        $('#studentForm')[0].reset();
        $('#modalTitle').text('Add Student');
        $('#studentModal').modal('show');
    });

    // Handle form submission for adding/editing student
    // Note: This line is removed because the submit handler is now defined in the validation plugin.
    // $('#studentForm').on('submit', function (e) {
    //     e.preventDefault();
    //     saveStudent();
    // });
    $('#state').on('change', function () {
        var stateId = $(this).val();
        if (stateId) {
            fetchCities(stateId);
        } else {
            // Clear city dropdown if no state is selected
            $('#city').empty();
        }
    });

    $('.close-model').click(function(){
        $('#studentModal').modal('hide');
    });
    $('.close_toast').on('click', function () {
        // $('.toast').toast('hide');
        alert('test');
        // toastr.clear();
    });

});

function fetchStates() {
    $.ajax({
        url: '/states',
        method: 'GET',
        success: function (states) {
            var stateSelect = $('#state');
            stateSelect.empty(); // Clear existing options

            // Add default option
            stateSelect.append($('<option>', {
                value: '',
                text: 'Select State'
            }));

            // Populate states
            $.each(states, function (index, state) {
                stateSelect.append($('<option>', {
                    value: state.id,
                    text: state.name
                }));
            });
        },
        error: function (error) {
            console.error('Error fetching states:', error);
        }
    });
}

// Function to fetch and populate cities based on state
function fetchCities(stateId) {
    $.ajax({
        url: '/city/' + stateId,
        method: 'GET',
        success: function (cities) {
            var citySelect = $('#city');
            citySelect.empty(); // Clear existing options

            // Add default option
            citySelect.append($('<option>', {
                value: '',
                text: 'Select City'
            }));

            // Populate cities
            $.each(cities, function (index, city) {
                citySelect.append($('<option>', {
                    value: city.id,
                    text: city.name
                }));
            });
        },
        error: function (error) {
            console.error('Error fetching cities:', error);
        }
    });
}
function fetchStudents() {
    $.ajax({
        url: '/getstudents', // Replace with your Laravel route for fetching students
        method: 'GET',
        success: function (data) {
            displayStudents(data);
        },
        error: function (error) {
            console.error('Error fetching students:', error);
        }
    });
}

function displayStudents(students) {
    $('#studentsTableBody').empty();
    students.forEach(function (student) {
        $('#studentsTableBody').append(`
            <tr>
                <td>${student.id}</td>
                <td>${student.first_name}</td>
                <td>${student.last_name}</td>
                <td>${student.dob}</td>
                <td>${student.gender}</td>
                <td>${JSON.parse(student.skills).join(', ')}</td>
                <td>${student.state.name}</td>
                <td>${student.city.name}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editStudent(${student.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteStudent(${student.id})">Delete</button>
                </td>
            </tr>
        `);
    });
}

function saveStudent() {
    var formData = $('#studentForm').serialize();
    var method = ($('#modalTitle').text() === 'Add Student') ? 'POST' : 'PUT'; // Use PUT for update

    var url = ($('#modalTitle').text() === 'Add Student') ? '/students' : '/students/' + $('#student_id').val();

    console.log(formData);

    $.ajax({
        url: url,
        method: method, // Use PUT for update
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        success: function (data) {
            $('#studentModal').modal('hide');
            fetchStudents(); // Refresh the table after adding/editing a student
            showAlert('success', data.success);
        },
        error: function (error) {
            console.error('Error saving student:', error);
        }
    });
}

function editStudent(id) {
    fetchSkills();
    $.ajax({
        url: '/students/' + id+'/edit', // Replace with your Laravel route for fetching a single student
        method: 'GET',
        success: function (data) {
            console.log(data);
            // Populate the form fields with the student data
            $('#student_id').val(data.id);
            $('#firstname').val(data.first_name);
            $('#lastname').val(data.last_name);
            $('#dob').val(data.dob);

            // Handle radio buttons
            $('input[name="gender"][value="' + data.gender + '"]').prop('checked', true);

            // Handle multiple select options (skills)
            var skillsArray = JSON.parse(data.skills);
            $('#skills').val([]);

            // Set the values in the skills dropdown
            $.each(skillsArray, function (index, skill) {
                $('#skills option').filter(function() {
                    return $(this).text() === skill;
                }).prop('selected', true);
            });

            // Trigger a change event to update the display of the selected options
            $('#skills').trigger('change');

            // Handle select dropdowns (state and city)
            $('#state').val(data.state);
            // Trigger a change event to update the display of the selected option
            $('#state').trigger('change');

            // Wait for a short time before setting the city value to ensure it's updated after the state
            setTimeout(function () {
                $('#city').val(data.city);
                // Trigger a change event to update the display of the selected option
                $('#city').trigger('change');
            }, 100);

            $('#modalTitle').text('Edit Student');
            $('#studentModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching student for editing:', error);
        }
    });
}

function deleteStudent(id) {
    if (confirm('Are you sure you want to delete this student?')) {
        $.ajax({
            url: '/students/' + id, // Replace with your Laravel route for deleting a student
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                fetchStudents(); // Refresh the table after deleting a student
                showAlert('success', data.success);
            },
            error: function (error) {
                console.error('Error deleting student:', error);
            }
        });
    }
}
function fetchSkills() {
    // Make an AJAX request to fetch skills from the API
    $.ajax({
        url: '/skills', // Replace with your actual API endpoint for fetching skills
        method: 'GET',
        success: function (data) {
            // Clear existing options in the skills dropdown
            $('#skills').empty();

            // Append fetched skills to the skills dropdown
            $.each(data, function (index, skill) {
                $('#skills').append(`<option value="${skill.name}">${skill.name}</option>`);
            });
        },
        error: function (error) {
            console.error('Error fetching skills:', error);
        }
    });
}
function showAlert(type, message) {
    // You can customize the toast appearance based on the 'type'
    var toastClass = (type === 'success') ? 'bg-success' : 'bg-danger';
    $('.toast-container').empty();
    // Create a toast element
    var toastElement = $('<div class="toast ' + toastClass + '" role="alert" aria-live="assertive" aria-atomic="true">' +
                            '<div class="toast-header">' +
                                '<strong class="mr-auto">Notification</strong>' +
                                '<button type="button" class="ml-2 mb-1 close close_toast" data-dismiss="toast" aria-label="Close">' +
                                    '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                            '</div>' +
                            '<div class="toast-body">' +
                                message +
                            '</div>' +
                        '</div>');

    // Append the toast to the body or a specific container
    toastElement.appendTo('.toast-container'); // Change '.toast-container' to a specific container selector

    // Show the toast
    $('.toast').toast({ delay: 700 }); // You can adjust the delay as needed
    $('.toast').toast('show');
}
