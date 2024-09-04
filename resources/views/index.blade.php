<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dharinder To-Do List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Your CSS code */
        * {  
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        } 

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .todo-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100vh;
            overflow-x: hidden;
        }

        .todo-container h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: #6a91bc;
            margin-top: 30px;
            position: relative;
        }

        .todo-container h2::after {
            content: "";
            display: block;
            width: 100%;
            height: 1px;
            background-color: #dcdfe3;
            margin-top: 10px;
        }

        .input-container {
            display: flex;
            margin-bottom: 20px;
            width: 40%;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }

        .todo-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
        }

        .add-btn {
            background-color: #6a91bc;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 10px;
            font-size: 16px;
        }

        .add-btn:hover {
            background-color: #1867bb;
        }

        .show-all-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .show-all-btn:hover {
            background-color: #0056b3;
        }

        .todo-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
            table-layout: fixed; /* Fixed column widths */
        }

        .todo-table th,
        .todo-table td {
            padding: 10px;
            text-align: left;
            white-space: nowrap;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .todo-table thead::after {
            content: "";
            display: block;
            width: 100%;
            height: 1px;
            background-color: #dcdfe3;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .todo-table tbody tr {
            border-bottom: 1px solid #ccc;
        }

        .todo-table td button {
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-btn {
            background-color: #28a745;
            color: #fff;
            margin-right: 10px;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .completed {
            display: none;
        }

        @media screen and (max-width: 788px) {
            .input-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="todo-container">
        <h2>Dharinder Simple To Do List App</h2>
        <div class="input-container">
            <input type="text" id="taskInput" placeholder="Add Task" class="todo-input">
            <button class="add-btn" id="addTaskBtn">Add Task</button>
        </div>
        <button class="show-all-btn" id="showAllBtn">Show All Tasks</button>
        <div class="table-wrapper">
            <table class="todo-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="taskTableBody">
                    @foreach($todos as $todo)
                    <tr id="taskRow_{{ $todo->id }}" class="{{ $todo->status ? 'completed' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td id="taskTitle_{{ $todo->id }}">{{ $todo->task }}</td>
                        <td>{{ $todo->status ? 'Done' : 'Pending' }}</td>
                        <td>
                            <input type="checkbox" class="mark-done" data-id="{{ $todo->id }}" {{ $todo->status ? 'checked' : '' }}>
                            <button class="edit-btn" onclick="editTask({{ $todo->id }}, '{{ $todo->task }}')"><i class="fas fa-edit"></i></button>
                            <button class="delete-btn" onclick="deleteTask({{ $todo->id }})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add Task
        $('#addTaskBtn').on('click', function() {
            var task = $('#taskInput').val().trim();
            if (task === '') return;

            $.ajax({
                url: '/todos',
                method: 'POST',
                data: {
                    task: task
                },
                success: function(response) {
                    if (response.success) {
                        $('#taskTableBody').append(`
                            <tr id="taskRow_${response.todo.id}">
                                <td>${response.todo.id}</td>
                                <td id="taskTitle_${response.todo.id}">${response.todo.task}</td>
                                <td>Pending</td>
                                <td>
                                    <input type="checkbox" class="mark-done" data-id="${response.todo.id}">
                                    <button class="edit-btn" onclick="editTask(${response.todo.id}, '${response.todo.task}')"><i class="fas fa-edit"></i></button>
                                    <button class="delete-btn" onclick="deleteTask(${response.todo.id})"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        `);
                        $('#taskInput').val('');
                    }
                }
            });
        });

        // Edit Task
        function editTask(id, task) {
            var newTitle = prompt('Edit Task', task);
            if (newTitle && newTitle !== task) {
                $.ajax({
                    url: `/todos/${id}`,
                    method: 'PUT',
                    data: {
                        task: newTitle
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`#taskTitle_${id}`).text(newTitle);
                        }
                    }
                });
            }
        }

        // Delete Task
        function deleteTask(id) {
            if (confirm('Are you sure to delete this task?')) {
                $.ajax({
                    url: `/todos/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            $(`#taskRow_${id}`).remove();
                        }
                    }
                });
            }
        }

        // Mark Task as Done


        
        $(document).on('change', '.mark-done', function() {
            var taskId = $(this).data('id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: `/todos/${taskId}/update-status`,
                method: 'PATCH',
                data: {
                    status: isChecked ? 1 : 0,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $(`#taskRow_${taskId}`).toggleClass('completed', isChecked);
                    } else {
                        alert('Failed to update task status.');
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        });

        // Show All Tasks
        $('#showAllBtn').on('click', function() {
            $('.completed').show(); // Show completed tasks
            
            // Adjust the table layout if needed
            setTimeout(function() {
                // Force reflow to ensure the table adjusts correctly
                $('.todo-table').css('display', 'none').offset(); 
                $('.todo-table').css('display', 'table');
            }, 0);
        });
    </script>
</body>
</html>
