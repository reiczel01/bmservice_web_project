var today = new Date();
var tomorrow = new Date(today);
tomorrow.setDate(tomorrow.getDate() + 1);

var dd = tomorrow.getDate();
var mm = tomorrow.getMonth() + 1;
var yyyy = tomorrow.getFullYear();

if (dd < 10) {
    dd = '0' + dd;
}
if (mm < 10) {
    mm = '0' + mm;
}

var tomorrowFormatted = yyyy + '-' + mm + '-' + dd;
document.getElementById("start").setAttribute("min", tomorrowFormatted);

var maxDate = new Date();
maxDate.setMonth(maxDate.getMonth() + 6);

var maxDD = maxDate.getDate();
var maxMM = maxDate.getMonth() + 1;
var maxYYYY = maxDate.getFullYear();

if (maxDD < 10) {
    maxDD = '0' + maxDD;
}
if (maxMM < 10) {
    maxMM = '0' + maxMM;
}

var maxDateFormatted = maxYYYY + '-' + maxMM + '-' + maxDD;
document.getElementById("start").setAttribute("max", maxDateFormatted);