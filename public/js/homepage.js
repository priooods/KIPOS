setInterval(() => {
    document.getElementById("times").innerHTML = moment().format(
        "DD-MM-YYYY / HH:mm:ss"
    );
}, 1000);
