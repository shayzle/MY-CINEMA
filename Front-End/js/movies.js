const API_BASE = '/My_Cinema_Webacademie/Back-End/index.php';
const MOVIE_API = `${API_BASE}/api/movies`;

const movieList = document.getElementById('list_movies');
const movieForm = document.getElementById('form_movies');

async function loadMovies() {
    const res = await fetch(MOVIE_API);
    const movies = await res.json();

    movieList.innerHTML = '';

    movies.forEach(movie => {
        const li = document.createElement('li');
        li.textContent = `${movie.id} — ${movie.title} (${movie.release_year})`;

        const btn = document.createElement('button');
        btn.textContent = 'Delete';
        btn.className = 'delete-btn';
        btn.onclick = () => deleteMovie(movie.id);

        li.appendChild(btn);
        movieList.appendChild(li);
    });
}

movieForm.addEventListener('submit', async e => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(movieForm));

    await fetch(MOVIE_API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    movieForm.reset();
    loadMovies();
});

async function deleteMovie(id) {
    await fetch(`${MOVIE_API}/${id}`, { method: 'DELETE' });
    loadMovies();
}

loadMovies();