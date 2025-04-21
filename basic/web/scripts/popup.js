
// When the "openModalBtn" button is clicked, display the modal
document.getElementById("openModalBtn").onclick = function () {
    document.getElementById("customerModal").style.display = "block";
};

// When the "closeModalBtn" button is clicked, hide the modal
document.getElementById("closeModalBtn").onclick = function () {
    document.getElementById("customerModal").style.display = "none";
};

// When clicking anywhere outside the modal, hide the modal
window.onclick = function (event) {
    if (event.target === document.getElementById("customerModal")) {
        document.getElementById("customerModal").style.display = "none";
    }
};
