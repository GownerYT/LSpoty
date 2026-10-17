let trackListItems = Array.from(document.querySelectorAll('.track-list li'));
let tracksData = trackListItems.map(li => ({ url: li.dataset.url, element: li }));
let player = document.getElementById('audioPlayer');
let playPauseBtn = document.getElementById('playPauseBtn');
let progressBarContainer = document.querySelector('.progress-bar-container');
let progressBar = document.getElementById('progressBar');
let repeatBtn = document.getElementById('repeatBtn');
let currentTimeDisplay = document.getElementById('currentTime');
let durationDisplay = document.getElementById('duration');
let currentIndex = 0;
let isPlaying = false;
let isRepeat = false;

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
    return `${minutes}:${remainingSeconds}`;
}

function loadTrack(index) {
    if (index < 0 || index >= tracksData.length || !tracksData[index].url) {
        player.src = '';
        isPlaying = false;
        playPauseBtn.textContent = '▶️';
        progressBar.style.width = '0%';
        currentTimeDisplay.textContent = '0:00';
        durationDisplay.textContent = '0:00';
        return;
    }
    currentIndex = index;
    player.src = tracksData[index].url;
    trackListItems.forEach(item => item.classList.remove('active'));
    tracksData[index].element.classList.add('active');
    player.addEventListener('loadedmetadata', () => {
        durationDisplay.textContent = formatTime(player.duration);
    });
    if (isPlaying) {
        player.play();
        playPauseBtn.textContent = '⏸️';
    } else {
        playPauseBtn.textContent = '▶️';
    }
}

function playNewTrack(index) {
    loadTrack(index);
    player.play();
    isPlaying = true;
    playPauseBtn.textContent = '⏸️';
}

playPauseBtn.addEventListener('click', () => {
    if (player.paused) {
        player.play();
        isPlaying = true;
        playPauseBtn.textContent = '⏸️';
    } else {
        player.pause();
        isPlaying = false;
        playPauseBtn.textContent = '▶️';
    }
});

player.addEventListener('ended', () => {
    if (isRepeat) {
        player.play();
    } else if (currentIndex + 1 < tracksData.length) {
        loadTrack(currentIndex + 1);
        player.play();
        isPlaying = true;
        playPauseBtn.textContent = '⏸️';
    } else {
        isPlaying = false;
        playPauseBtn.textContent = '▶️';
        progressBar.style.width = '0%';
        currentTimeDisplay.textContent = '0:00';
    }
});

player.addEventListener('timeupdate', () => {
    if (player.duration) {
        const progress = (player.currentTime / player.duration) * 100;
        progressBar.style.width = `${progress}%`;
        currentTimeDisplay.textContent = formatTime(player.currentTime);
    }
});

progressBarContainer.addEventListener('click', (e) => {
    const width = progressBarContainer.offsetWidth;
    const clickX = e.offsetX;
    const duration = player.duration;
    player.currentTime = (clickX / width) * duration;
});

repeatBtn.addEventListener('click', () => {
    isRepeat = !isRepeat;
    repeatBtn.classList.toggle('active', isRepeat);
    alert(repeatBtn.dataset.langRepeat + ' ' + (isRepeat ? repeatBtn.dataset.langEnabled : repeatBtn.dataset.langDisabled));
});

if (tracksData.length > 0) {
    loadTrack(0);
}
