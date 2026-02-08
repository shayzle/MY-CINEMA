const API_BASE = '/Back-End/index.php';

async function apiRequest(path, method = "GET", body = null) {
  const options = { method, headers: { "Content-Type": "application/json" } };
  if (body) options.body = JSON.stringify(body);

  const res = await fetch(API_BASE + "/api" + path, options);
  if (!res.ok) throw new Error("API error");
  return res.json();
}

function resetScreeningForm() {
  ["screeningId", "screeningMovie", "screeningRoom", "screeningTime"]
    .forEach(id => document.getElementById(id).value = "");
}

function fillScreeningForm(s) {
  document.getElementById("screeningId").value = s.id ?? "";
  document.getElementById("screeningMovie").value = s.movie_id ?? "";
  document.getElementById("screeningRoom").value = s.room_id ?? "";
  document.getElementById("screeningTime").value = s.start_time?.replace(" ", "T") ?? "";
}

async function loadScreenings() {
  const screenings = await apiRequest("/screenings");

  document.getElementById("screeningsTable").innerHTML = `
    <table border="1">
      <tr>
        <th>ID</th><th>Movie</th><th>Room</th><th>Start time</th><th>Actions</th>
      </tr>
      ${screenings.map(s => `
        <tr>
          <td>${s.id}</td>
          <td>${s.movie_id}</td>
          <td>${s.room_id}</td>
          <td>${s.start_time}</td>
          <td>
            <button onclick='fillScreeningForm(${JSON.stringify(s)})'>Edit</button>
            <button onclick='deleteScreening(${s.id})'>Delete</button>
          </td>
        </tr>
      `).join("")}
    </table>
  `;
}

async function saveScreening() {
  const id = document.getElementById("screeningId").value.trim();

  const payload = {
    movie_id: Number(document.getElementById("screeningMovie").value),
    room_id: Number(document.getElementById("screeningRoom").value),
    start_time: document.getElementById("screeningTime").value.replace("T", " ")
  };

  if (!payload.movie_id || !payload.room_id || !payload.start_time) return;

  if (id === "") {
    await apiRequest("/screenings", "POST", payload);
  } else {
    await apiRequest(`/screenings/${id}`, "PUT", payload);
  }

  resetScreeningForm();
  loadScreenings();
}

async function deleteScreening(id) {
  await apiRequest(`/screenings/${id}`, "DELETE");
  loadScreenings();
}

loadScreenings();