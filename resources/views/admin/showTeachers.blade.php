@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/showTeachers.css')}}">

<h1 class="page-title">Teacher's List</h1>
<div class="container">
    <div class="search">
        <input type="text" id="search-teachers" class="search-ipt" placeholder="Search for a Teacher">
    </div>
    <table class="tabl">
        <thead>
            <tr class="table-line">
                <th class="column-name">Code</th>
                <th class="column-name">First Name</th>
                <th class="column-name">Last Name</th>
                <th class="column-name">Email</th>
                <th class="column-name">Exams</th>
                <th class="column-name">Actions</th>
            </tr>
        </thead>
        <tbody id="teachers-table-body">
            @foreach($teachers as $teacher)
                <tr class="table-line" data-id="{{ $teacher->id }}">
                    <td class="column-text">{{ $teacher->teacher_code }}</td>
                    <td class="column-text">{{ $teacher->firstname }}</td>
                    <td class="column-text">{{ $teacher->lastname }}</td>
                    <td class="column-text">{{ $teacher->email }}</td>
                    <td class="column-text">
                        <button class="exam-btn" data-id="{{ $teacher->id }}">
                            View
                        </button>
                    </td>
                    <td class="column-text">
                        <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                        <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
    document.getElementById('search-teachers').addEventListener('input', fetchTeachers);

    function fetchTeachers() {
        const query = document.getElementById('search-teachers').value;

        fetch(`/admin/teachers/search?search=${query}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('teachers-table-body');
                tbody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(teacher => {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', teacher.id);
                        tr.innerHTML = `
                        <td class="column-text">${teacher.teacher_code}</td>
                        <td class="column-text">${teacher.firstname}</td>
                        <td class="column-text">${teacher.lastname}</td>
                        <td class="column-text">${teacher.email}</td>
                        <td class="column-text">
                            <button class="exam-btn" data-id="${teacher.id}">
                                View
                            </button>
                        </td>
                        <td class="column-text">
                            <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                            <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                        </td>
                    `;
                        tbody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="6" class="text-center" style="font-family: Raleway;">No teachers found</td>`;
                    tbody.appendChild(tr);
                }
                attachEventListeners();
            });
    }

    function attachEventListeners() {
        document.querySelectorAll('.modify-image').forEach(img => {
            img.addEventListener('click', handleModify);
        });
        document.querySelectorAll('.delete-image').forEach(img => {
            img.addEventListener('click', handleDelete);
        });
        document.querySelectorAll('.exam-btn').forEach(button => {
            button.addEventListener('click', handleShowExams);
        });
    }

    function handleModify(event) {
        const tr = event.target.closest('tr');
        const id = tr.getAttribute('data-id');
        const teacherCode = tr.children[0].innerText;
        const firstname = tr.children[1].innerText;
        const lastname = tr.children[2].innerText;
        const email = tr.children[3].innerText;

        tr.innerHTML = `
            <td class="column-text"><input type="text" value="${teacherCode}" class="edit-input" data-field="teacher_code"></td>
            <td class="column-text"><input type="text" value="${firstname}" class="edit-input" data-field="firstname"></td>
            <td class="column-text"><input type="text" value="${lastname}" class="edit-input" data-field="lastname"></td>
            <td class="column-text"><input type="text" value="${email}" class="edit-input" data-field="email"></td>
            <td class="column-text">

            </td>
            <td class="column-text">
                <button class="approve-btn">Approve</button>
            </td>
        `;

        tr.querySelector('.approve-btn').addEventListener('click', () => handleApprove(id, tr));
    }

    function handleApprove(id, tr) {
        const updatedData = {};
        tr.querySelectorAll('.edit-input').forEach(input => {
            updatedData[input.getAttribute('data-field')] = input.value;
        });

        fetch(`/admin/teachers/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(updatedData)
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTeachers();
                } else {
                    alert('Failed to update teacher');
                }
            });
    }

    function handleDelete(event) {
    const tr = event.target.closest('tr');
    const id = tr.getAttribute('data-id');

    if (confirm('Are you sure you want to delete this teacher?')) {
        console.log(`Attempting to delete teacher with id: ${id}`);

        fetch(`/admin/teachers/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            console.log('Delete response data:', data);
            if (data.success) {
                fetchTeachers();
            } else {
                alert('Failed to delete teacher');
            }
        }).catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to delete teacher');
        });
    }
}



    function handleShowExams(event) {
        const id = event.target.getAttribute('data-id');
        window.location.href = `/admin/teachers/${id}/exams`;
    }

    attachEventListeners();
</script>
@endsection
