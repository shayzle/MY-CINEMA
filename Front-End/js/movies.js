const API_BASE = '/My_Cinema_Webacademie/Back-End/index.php';

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

function setStatus(msg, error = false) {
  const el = document.getElementById("status");
  el.textContent = msg;
  el.style.color = error ? "red" : "green";
}

/* FORM HELPERS */

function resetMovieForm() {
  ["movieId","movieTitle","movieDescription","movieDuration","movieYear","movieGenre","movieDirector"]
    .forEach(id => document.getElementById(id).value = "");
}

function fillMovieForm(movie) {
  document.getElementById("movieId").value = movie.id ?? "";
  document.getElementById("movieTitle").value = movie.title ?? "";
  document.getElementById("movieDescription").value = movie.description ?? "";
  document.getElementById("movieDuration").value = movie.duration ?? "";
  document.getElementById("movieYear").value = movie.release_year ?? "";
  document.getElementById("movieGenre").value = movie.genre ?? "";
  document.getElementById("movieDirector").value = movie.director ?? "";
}

/* LOAD MOVIES */

async function loadMovies() {
  try {
    const movies = await apiRequest("/movies");

    document.getElementById("badgeMovies").textContent = movies.length;

    document.getElementById("moviesTable").innerHTML = `
      <table border="1">
        <tr>
          <th>ID</th><th>Title</th><th>Duration</th><th>Year</th><th>Genre</th><th>Actions</th>
        </tr>
        ${movies.map(m => `
          <tr>
            <td>${m.id}</td>
            <td>${m.title}</td>
            <td>${m.duration}</td>
            <td>${m.release_year}</td>
            <td>${m.genre ?? ""}</td>
            <td>
              <button onclick='fillMovieForm(${JSON.stringify(m)})'>Edit</button>
              <button onclick='deleteMovie(${m.id})'>Delete</button>
            </td>
          </tr>
        `).join("")}
      </table>
    `;

    setStatus("Movies loaded");
  } catch (e) {
    setStatus(e.message, true);
  }
}

/* CRUD */

async function deleteMovie(id) {
  await apiRequest(`/movies/${id}`, "DELETE");
  loadMovies();
}

async function saveMovie() {
  const id = document.getElementById("movieId").value.trim();

  const payload = {
    title: document.getElementById("movieTitle").value.trim(),
    description: document.getElementById("movieDescription").value.trim() || null,
    duration: safeNumber(document.getElementById("movieDuration").value),
    release_year: safeNumber(document.getElementById("movieYear").value),
    genre: document.getElementById("movieGenre").value.trim() || null,
    director: document.getElementById("movieDirector").value.trim() || null
  };

  if (!payload.title || !payload.duration) {
    setStatus("Title & duration required", true);
    return;
  }

  if (id === "") {
    await apiRequest("/movies", "POST", payload);
  } else {
    await apiRequest(`/movies/${id}`, "PUT", payload);
  }

  resetMovieForm();
  loadMovies();
}

loadMovies();