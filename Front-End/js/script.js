

// JavaScript code to fetch data from the "shanisya" API endpoint --> to make sure it's safe and working
const API = "shanisya";

async function shanisyaFetch() {
    const response = await fetch(API); // fetch data from the API endpoint
    const name = await response.json(); // parse the JSON response 
}