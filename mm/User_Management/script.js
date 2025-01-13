// Fetch and display users
async function fetchUsers() {
    const response = await fetch('fetch_users.php');
    const users = await response.json();

    const tbody = document.querySelector('#userTable tbody');
    tbody.innerHTML = '';

    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.username}</td>
            <td>${user.status}</td>
            <td>
                <button onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.status}')">Edit</button>
                <button onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Open edit modal
function editUser(id, name, email, status) {
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editStatus').value = status;
    document.getElementById('editModal').style.display = 'block';
}

// Close modal
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Save changes
document.getElementById('editForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const id = document.getElementById('editId').value;
    const name = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const status = document.getElementById('editStatus').value;

    const response = await fetch('update_user.php', {
        method: 'POST',
        body: JSON.stringify({ id, name, email, status }),
        headers: { 'Content-Type': 'application/json' }
    });

    const result = await response.text();
    alert(result);
    closeModal();
    fetchUsers();
});

// Delete user
async function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        const response = await fetch('delete_user.php', {
            method: 'POST',
            body: JSON.stringify({ id }),
            headers: { 'Content-Type': 'application/json' }
        });

        const result = await response.text();
        alert(result);
        fetchUsers();
    }
}

// Initial fetch
fetchUsers();
