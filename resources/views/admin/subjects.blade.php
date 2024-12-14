@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/subjects.css')}}">

<div class="container">
    <div class="links-container">
        <a class="link-button" href="{{ route('admin.home') }}">Users</a>
        <a class="link-button" href="{{ route('admin.subjects') }}">Subjects</a>
        <a class="link-button" href="{{ route('admin.sectors') }}">Sectors</a>
    </div>
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
            <input type="text" id="search-subjects" class="search-ipt" placeholder="Search Subjects">
        </div>
    </div>

    <table class="tabl">
        <thead>
            <tr class="table-line">
                <th class="column-name">Subject Name</th>
                <th class="column-name">Sector Name</th>
                <th class="column-name">Teacher Name</th>
                <th class="column-name">Actions</th>
            </tr>
        </thead>
        <tbody id="subjects-table-body">
            @foreach($subjects as $subject)
                <tr class="table-line" data-id="{{ $subject->id }}">
                    <td class="column-text">{{ $subject->subject_name }}</td>
                    <td class="column-text">{{ $subject->sector->sector_name }}</td>
                    <td class="column-text">{{ $subject->teacher->firstname ?? '' }} {{ $subject->teacher->lastname ?? '' }}</td>
                    <td class="column-text">
                        <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                        <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="create" href="#" id="add-subject-button">+</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentLocation = window.location.href;
        const links = document.querySelectorAll('.link-button');

        links.forEach(link => {
            if (link.href === currentLocation) {
                link.classList.add('active');
            }
        });
    });
</script>

<script>
    document.getElementById('search-subjects').addEventListener('input', fetchSubjects);
    document.getElementById('sector-filter').addEventListener('change', fetchSubjects);
    document.getElementById('add-subject-button').addEventListener('click', addNewSubjectRow);

    function fetchSubjects() {
        const query = document.getElementById('search-subjects').value;
        const sectorId = document.getElementById('sector-filter').value;

        fetch(`/admin/subjects/search?search=${query}&sector_id=${sectorId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('subjects-table-body');
                tbody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(subject => {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', subject.id);
                        tr.innerHTML = `
                            <td class="column-text">${subject.subject_name}</td>
                            <td class="column-text">${subject.sector.sector_name}</td>
                            <td class="column-text">${subject.teacher.firstname} ${subject.teacher.lastname}</td>
                            <td class="column-text">
                                <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                                <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="4" class="text-center" style="font-family: Raleway;">No subjects found</td>`;
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
        const subjectName = tr.children[0].innerText;
        const sectorName = tr.children[1].innerText;
        const teacherName = tr.children[2].innerText;

        tr.innerHTML = `
            <td class="column-text"><input type="text" value="${subjectName}" class="edit-input" data-field="subject_name"></td>
            <td class="column-text">
                <select class="edit-input" data-field="sector_id">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}" ${sectorName === "{{ $sector->sector_name }}" ? 'selected' : ''}>{{ $sector->sector_name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="column-text">
                <select class="edit-input" data-field="teacher_id">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" ${teacherName === "{{ $teacher->firstname }} {{ $teacher->lastname }}" ? 'selected' : ''}>{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
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

        fetch(`/admin/subjects/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(updatedData)
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchSubjects();
                } else {
                    alert('Failed to update subject');
                }
            });
    }

    function handleDelete(event) {
        const tr = event.target.closest('tr');
        const id = tr.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this subject?')) {
            fetch(`/admin/subjects/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchSubjects();
                    } else {
                        alert('Failed to delete subject');
                    }
                });
        }
    }

    function addNewSubjectRow() {
        const tbody = document.getElementById('subjects-table-body');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="column-text"><input type="text" class="edit-input" data-field="subject_name"></td>
            <td class="column-text">
                <select class="edit-input" data-field="sector_id">
                    @foreach($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->sector_name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="column-text">
                <select class="edit-input" data-field="teacher_id">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                    @endforeach
                </select>
            </td>
            <td class="column-text">
                <button class="approve-new-btn">Approve</button>
            </td>
        `;
        tbody.appendChild(tr);

        tr.querySelector('.approve-new-btn').addEventListener('click', () => handleNewApprove(tr));
    }

    function handleNewApprove(tr) {
        const newData = {};
        tr.querySelectorAll('.edit-input').forEach(input => {
            newData[input.getAttribute('data-field')] = input.value;
        });

        fetch('{{ route('admin.add-subject') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(newData)
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchSubjects();
                } else {
                    alert('Failed to add subject');
                }
            });
    }

    attachEventListeners();

</script>

@endsection
