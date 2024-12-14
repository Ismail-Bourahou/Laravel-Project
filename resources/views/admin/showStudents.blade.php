@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/showStudents.css')}}">

<h1 class="page-title">Student's List</h1>
<div class="container">
    <div class="search-group">
        <div class="filter">
            <select id="sector-filter" class="filter-ipt">
                <option value="">Filter by Sector</option>
                @foreach($sectors as $sector)
                    <option value="{{ $sector->id }}">{{ $sector->sector_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="search">
            <input type="text" id="search-students" class="search-ipt" placeholder="Search Students">
        </div>
    </div>

    <table class="tabl">
        <thead>
            <tr class="table-line">
                <th class="column-name">Code</th>
                <th class="column-name">First Name</th>
                <th class="column-name">Last Name</th>
                <th class="column-name">Email</th>
                <th class="column-name">Sector</th>
                <th class="column-name">Actions</th>
            </tr>
        </thead>
        <tbody id="students-table-body">
            @foreach($students as $student)
                <tr class="table-line" data-id="{{ $student->id }}">
                    <td class="column-text">{{ $student->student_code }}</td>
                    <td class="column-text">{{ $student->firstname }}</td>
                    <td class="column-text">{{ $student->lastname }}</td>
                    <td class="column-text">{{ $student->email }}</td>
                    <td class="column-text">{{ $student->sector ? $student->sector->sector_name : 'N/A' }}</td>
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
    document.getElementById('search-students').addEventListener('input', fetchStudents);
    document.getElementById('sector-filter').addEventListener('change', fetchStudents);

    function fetchStudents() {
        const query = document.getElementById('search-students').value;
        const sectorId = document.getElementById('sector-filter').value;

        fetch(`/admin/students/search?search=${query}&sector_id=${sectorId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('students-table-body');
                tbody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', student.id);
                        tr.innerHTML = `
                            <td class="column-text">${student.student_code}</td>
                            <td class="column-text">${student.firstname}</td>
                            <td class="column-text">${student.lastname}</td>
                            <td class="column-text">${student.email}</td>
                            <td class="column-text">${student.sector ? student.sector.sector_name : 'N/A'}</td>
                            <td class="column-text">
                                <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                                <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="6" class="text-center" style="font-family: Raleway;">No students found</td>`;
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
    }

    function handleModify(event) {
        const tr = event.target.closest('tr');
        const id = tr.getAttribute('data-id');
        const studentCode = tr.children[0].innerText;
        const firstname = tr.children[1].innerText;
        const lastname = tr.children[2].innerText;
        const email = tr.children[3].innerText;
        const sectorName = tr.children[4].innerText;

        tr.innerHTML = `
            <td class="column-text"><input type="text" value="${studentCode}" class="edit-input" data-field="student_code"></td>
            <td class="column-text"><input type="text" value="${firstname}" class="edit-input" data-field="firstname"></td>
            <td class="column-text"><input type="text" value="${lastname}" class="edit-input" data-field="lastname"></td>
            <td class="column-text"><input type="text" value="${email}" class="edit-input" data-field="email"></td>
            <td class="column-text">
                <select class="edit-input" data-field="sector_id">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" ${sectorName === "{{ $sector->sector_name }}" ? 'selected' : ''}>{{ $sector->sector_name }}</option>
                    @endforeach
                </select>
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

        fetch(`/admin/students/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(updatedData)
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  fetchStudents();
              } else {
                  alert('Failed to update student');
              }
          });
    }

    function handleDelete(event) {
        const tr = event.target.closest('tr');
        const id = tr.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this student?')) {
            fetch(`/admin/students/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      fetchStudents();
                  } else {
                      alert('Failed to delete student');
                  }
              });
        }
    }

    attachEventListeners();
</script>

@endsection
