<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jam Realtime PHP/Javascript</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Roboto+Mono:wght@300&display=swap"
        rel="stylesheet">
    <style>
    #clock {
        display: inline-flex;
        /* padding: 10px; */

        border-radius: 10px;
        text-align: center;
        position: relative;
        width: 80vw;
    }

    #time {
        display: flex;
    }

    #time div {
        position: relative;
        margin: 0 5px;

    }

    #time div span {
        width: 50px;
        height: 30px;
        background: white;
        color: black;
        font-weight: 500;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        font-family: 'Orbitron', sans-serif;


    }

    #cal {
        position: relative;
        /* margin: 10px; */
        display: inline;
        margin-left: 50%;

    }

    #cal span {
        background: white;
        color: black;
        font-weight: 300;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        font-family: 'Orbitron', sans-serif;

    }
    </style>
</head>

<body>
    <div id="clock">

        <div id="time">
            <div>
                <span id="hours">00</span>
            </div>
            <div>
                <span id="minutes">00</span>
            </div>
            <div>
                <span id="seconds">00</span>
            </div>
            <div>
                <span id="amOrpm">AM</span>
            </div>
        </div>

        <div id="cal">
            <span id="fullyear">25 Januari 2021</span>
        </div>

    </div>
</body>
<script type="text/javascript">
function SettingCurrentTime() {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
    var amOrPm = hours < 12 ? "AM" : "PM";

    hours = hours === 0 ? 12 : hours > 12 ? hours - 12 : hours;
    hours = addZero(hours);
    minutes = addZero(minutes);
    seconds = addZero(seconds);

    var currentDate = currentTime.getDate();
    var currentMonth = ConvertMonth(currentTime.getMonth());
    var currentYear = currentTime.getFullYear();
    var fullDateDisplay = `${currentDate} ${currentMonth} ${currentYear}`;

    document.getElementById("hours").innerText = hours;
    document.getElementById("minutes").innerText = minutes;
    document.getElementById("seconds").innerText = seconds;
    document.getElementById("amOrpm").innerText = amOrPm;
    document.getElementById("fullyear").innerText = fullDateDisplay;

    var timer = setTimeout(SettingCurrentTime, 1000);
}

function addZero(component) {
    return component < 10 ? "0" + component : component;
}

function ConvertMonth(component) {
    month_array = new Array('Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember');
    return month_array[component];
}

SettingCurrentTime();
</script>

</html>