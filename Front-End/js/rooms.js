const API_BASE = '/Back-End/index.php';

async function apiRequest(path, method = "GET", body = null) {
  const options = { method, headers: { "Content-Type": "application/json" } };
  if (body) options.body = JSON.stringify(body);

  const res = await fetch(API_BASE + "/api" + path, options);
  if (!res.ok) throw new Error("API error");
  return res.json();
}

function safeNumber(value) {
  const n = Number(value);
  return isNaN(n) ? null : n;
}

function resetRoomForm() {
  ["roomId", "roomName", "roomCapacity", "roomType"].forEach(
    id => document.getElementById(id).value = ""
  );
}

function fillRoomForm(room) {
  document.getElementById("roomId").value = room.id ?? "";
  document.getElementById("roomName").value = room.name ?? "";
  document.getElementById("roomCapacity").value = room.capacity ?? "";
  document.getElementById("roomType").value = room.type ?? "";
}

async function loadRooms() {
  const rooms = await apiRequest("/rooms");

  document.getElementById("roomsTable").innerHTML = `
    <table border="1">
      <tr>
        <th>ID</th><th>Name</th><th>Capacity</th><th>Type</th><th>Actions</th>
      </tr>
      ${rooms.map(r => `
        <tr>
          <td>${r.id}</td>
          <td>${r.name}</td>
          <td>${r.capacity}</td>
          <td>${r.type ?? ""}</td>
          <td>
            <button onclick='fillRoomForm(${JSON.stringify(r)})'>Edit</button>
            <button onclick='deleteRoom(${r.id})'>Delete</button>
          </td>
        </tr>
      `).join("")}
    </table>
  `;
}

async function saveRoom() {
  const id = document.getElementById("roomId").value.trim();

  const payload = {
    name: document.getElementById("roomName").value.trim(),
    capacity: safeNumber(document.getElementById("roomCapacity").value),
    type: document.getElementById("roomType").value.trim() || null
  };

  if (!payload.name || !payload.capacity) return;

  if (id === "") {
    await apiRequest("/rooms", "POST", payload);
  } else {
    await apiRequest(`/rooms/${id}`, "PUT", payload);
  }

  resetRoomForm();
  loadRooms();
}

async function deleteRoom(id) {
  await apiRequest(`/rooms/${id}`, "DELETE");
  loadRooms();
}

loadRooms();