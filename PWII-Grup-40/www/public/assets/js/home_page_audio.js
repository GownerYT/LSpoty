document.addEventListener('DOMContentLoaded', function () {
    const playButtons = document.querySelectorAll('.play-button');
    const stopButtons = document.querySelectorAll('.stop-button');
    const audioPlayers = document.querySelectorAll('.audio-player');

    playButtons.forEach((playButton, index) => {
        const stopButton = stopButtons[index];
        const audioPlayer = audioPlayers[index];

        playButton.addEventListener('click', function () {
            audioPlayers.forEach(player => {
                player.pause();
                player.currentTime = 0;
            });
            audioPlayer.play();

            playButton.style.display = 'none';
            stopButton.style.display = 'inline-block';
        });
    });

    stopButtons.forEach((stopButton, index) => {
        stopButton.addEventListener('click', function () {
            const audioPlayer = audioPlayers[index];

            audioPlayer.pause();
            audioPlayer.currentTime = 0;

            stopButton.style.display = 'none';
            playButtons[index].style.display = 'inline-block';
        });
    });
});
