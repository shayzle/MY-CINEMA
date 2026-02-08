const API_BASE = '/My_Cinema_Webacademie/Back-End/index.php';
const ROOM_API = `${API_BASE}/api/rooms`;

const roomList = document.getElementById('room-list');
const roomForm = document.getElementById('room-form');

async function loadRooms() {
    const res = await fetch(ROOM_API);
    const rooms = await res.json();

    roomList.innerHTML = '';

    rooms.forEach(room => {
        const li = document.createElement('li');
        li.textContent = `${room.id} — ${room.name} (${room.capacity})`;

        const btn = document.createElement('button');
        btn.textContent = 'Delete';
        btn.className = 'delete-btn';
        btn.onclick = () => deleteRoom(room.id);

        li.appendChild(btn);
        roomList.appendChild(li);
    });
}

roomForm.addEventListener('submit', async e => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(roomForm));

    await fetch(ROOM_API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    roomForm.reset();
    loadRooms();
});

async function deleteRoom(id) {
    await fetch(`${ROOM_API}/${id}`, {
        method: 'DELETE'
    });

    loadRooms();
}

loadRooms();