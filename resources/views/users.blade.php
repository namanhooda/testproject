<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .alignment{
            text-align: center;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="container" style="margin-top:25px;;">
    <h3 class="alignment">User Create Operations</h3>
  <div class="row">
    <div class="col-sm">

    <h2>User Form</h2>
    <form id="userForm" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email"
                    required></div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputEmail1" name="phone"
                    placeholder="Phone (10 digits)" required></div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" id="exampleInputEmail1" name="description"
                    placeholder="Description" required></textarea></div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm-10">
                <select class="form-control" id="exampleFormControlSelect1" name="role_id" required>
                    <option value="">Select Role</option>
                    
                </select></div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Profile Image</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="exampleInputEmail1" name="profile_image" required></div>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary mb-2">Submit</button></div>
        </div>
    </form>

    </div>
    <div class="col-sm">
    <h2>User List</h2>


    <table class="table" id="userTable">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Description</th>
                <th scope="col">Role</th>
                <th scope="col">Profile Image</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    </div>
  </div>
</div>

    <script>
        $(document).ready(function () {
           
            $.get('/api/roles', function (roles) {
                roles.forEach(function (role) {
                    $('select[name="role_id"]').append(new Option(role.name, role.id));
                });
            });

            
            function loadUsers() {
                $.get('/api/users', function (users) {
                    $('#userTable tbody').empty();
                    users.forEach(function (user) {
                        $('#userTable tbody').append(`
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.phone}</td>
                                <td>${user.description}</td>
                                <td>${user.role.name}</td>
                                <td><img src="${user.profile_image}" width="50"></td>
                            </tr>
                        `);
                    });
                });
            }

            loadUsers(); 

            
            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '/api/users',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (user) {
                        alert('User created successfully!');
                        loadUsers(); 
                        $('#userForm')[0].reset(); 
                    },
                    error: function (xhr) {
                        alert(JSON.stringify(xhr.responseJSON.errors));
                    }
                });
            });
        });

    </script>
</body>

</html>
