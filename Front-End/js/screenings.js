const API_BASE = '/My_Cinema_Webacademie/Back-End/index.php';
const SCREENING_API = `${API_BASE}/api/screenings`;

const screeningList = document.getElementById('list_screenings');
const screeningForm = document.getElementById('form_screenings');

async function loadScreenings() {
    const res = await fetch(SCREENING_API);
    const screenings = await res.json();

    screeningList.innerHTML = '';

    screenings.forEach(s => {
        const li = document.createElement('li');
        li.textContent = `${s.id} — Movie ${s.movie_id}, Room ${s.room_id}, ${s.start_time}`;

        const btn = document.createElement('button');
        btn.textContent = 'Delete';
        btn.className = 'delete-btn';
        btn.onclick = () => deleteScreening(s.id);

        li.appendChild(btn);
        screeningList.appendChild(li);
    });
}

screeningForm.addEventListener('submit', async e => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(screeningForm));

    await fetch(SCREENING_API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    screeningForm.reset();
    loadScreenings();
});

async function deleteScreening(id) {
    await fetch(`${SCREENING_API}/${id}`, {
        method: 'DELETE'
    });

    loadScreenings();
}

loadScreenings();