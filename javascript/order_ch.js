var ch1 = document.getElementById("ord_ch1");
var ch2 = document.getElementById("ord_ch2");
var content1 = document.getElementById("ch_content1");
var content2 = document.getElementById("ch_content2");

ch1.addEventListener("click", function () {
  content2.style.display = "none";
  content1.style.display = "block";
});
ch2.addEventListener("click", function () {
  content1.style.display = "none";
  content2.style.display = "block";
});
