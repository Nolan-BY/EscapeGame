// var timeRemaining;

// function startCountdown() {
//     var downloadTimer = setInterval(function () {
//         document.getElementsByClassName("countdown")[0].innerText = `${timeRemaining} secs left`;
//         timeRemaining -= 1;
    
//         if (timeRemaining <= 0) {
//             clearInterval(downloadTimer);
//             document.getElementsByClassName("countdown")[0].innerText = "Time's up!";
                
//             setTimeout(function () {
//                 window.location.href('./index.php')
//             }, 51000);
//         }
//     }, 1000);
// }

// function resetCountdown() {
//     timeRemaining = 100;
//     document.getElementsByClassName("countdown")[0].innerText = `${timeRemaining} secs left`;
// }

// function loginFirst(){
//     resetCountdown();
//     startCountdown();
// }

// <?php ?>;