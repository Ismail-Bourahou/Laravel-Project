@extends('header')

@section('content')

<link rel="stylesheet" href="{{asset('css/admin/sectors.css')}}">

<div class="container">
    <div class="links-container">
        <a class="link-button" href="{{ route('admin.home') }}">Users</a>
        <a class="link-button" href="{{ route('admin.subjects') }}">Subjects</a>
        <a class="link-button" href="{{ route('admin.sectors') }}">Sectors</a>
    </div>
    <div class="search-group">
        <div class="filter">
            <input type="text" id="search-sectors" class="search-ipt" placeholder="Search Sectors">
        </div>
    </div>

    <table class="tabl">
        <thead>
            <tr class="table-line">
                <th class="column-name">Sector Name</th>
                <th class="column-name">Actions</th>
            </tr>
        </thead>
        <tbody id="sectors-table-body">
            @foreach($sectors as $sector)
                <tr class="table-line" data-id="{{ $sector->id }}">
                    <td class="column-text">{{ $sector->sector_name }}</td>
                    <td class="column-text">
                        <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                        <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="create" href="#" id="add-sector-button">+</a>
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
    document.getElementById('search-sectors').addEventListener('input', fetchSectors);
    document.getElementById('add-sector-button').addEventListener('click', addNewSectorRow);

    function fetchSectors() {
        const query = document.getElementById('search-sectors').value;

        fetch(`/admin/sectors/search?search=${query}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('sectors-table-body');
                tbody.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(sector => {
                        const tr = document.createElement('tr');
                        tr.setAttribute('data-id', sector.id);
                        tr.innerHTML = `
                            <td class="column-text">${sector.sector_name}</td>
                            <td class="column-text">
                                <img class="column-image modify-image" src="{{ asset('modify.png') }}" alt="Modify">
                                <img class="column-image delete-image" src="{{ asset('delet.png') }}" alt="Delete">
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td colspan="2" class="text-center" style="font-family: Raleway;">No sectors found</td>`;
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
        const sectorName = tr.children[0].innerText;

        tr.innerHTML = `
            <td class="column-text"><input type="text" value="${sectorName}" class="edit-input" data-field="sector_name"></td>
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

        fetch(`/admin/sectors/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(updatedData)
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchSectors();
                } else {
                    alert('Failed to update sector');
                }
            });
    }

    function handleDelete(event) {
        const tr = event.target.closest('tr');
        const id = tr.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this sector?')) {
            fetch(`/admin/sectors/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchSectors();
                    } else {
                        alert('Failed to delete sector');
                    }
                });
        }
    }

    function addNewSectorRow() {
        const tbody = document.getElementById('sectors-table-body');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="column-text"><input type="text" class="edit-input" data-field="sector_name"></td>
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

        fetch('{{ route('admin.add-sector') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(newData)
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchSectors();
                } else {
                    alert('Failed to add sector');
                }
            });
    }

    attachEventListeners();

</script>

@endsection
