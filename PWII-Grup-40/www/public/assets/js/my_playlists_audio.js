let currentPlaylist = [];
let currentTrackIndex = 0;
const audioPlayer = document.getElementById('audio-player');
const playerContainer = document.getElementById('player-container');

function playPlaylist(playlistId) {
    currentPlaylist = playlists[playlistId];
    currentTrackIndex = 0;

    if (!currentPlaylist || currentPlaylist.length === 0) {
        alert("No tracks in this playlist.");
        return;
    }

    playTrack(currentTrackIndex);

    playerContainer.style.display = 'block';
}

function playTrack(index) {
    const track = currentPlaylist[index];
    if (!track) return;

    audioPlayer.src = track.url;
    audioPlayer.play().catch(error => {
        console.error("Error playing track:", error);
    });
}

audioPlayer.addEventListener('ended', () => {
    currentTrackIndex++;
    if (currentTrackIndex < currentPlaylist.length) {
        playTrack(currentTrackIndex);
    } else {
        console.log("Playlist finished.");
        playerContainer.style.display = 'none';
    }
});
