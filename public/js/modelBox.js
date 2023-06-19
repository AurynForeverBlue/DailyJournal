document.addEventListener("DOMContentLoaded", function() {
    // Get the modal elements
    var modal1 = document.getElementById("modal_update_email");
    var modal2 = document.getElementById("modal_update_username");
    var modal3 = document.getElementById("modal_update_password");
    var modal4 = document.getElementById("modal_update_pfphoto");
    var modal5 = document.getElementById("modal_update_banner");

    // Get the buttons
    var btnModal1 = document.getElementById("btnModal1");
    var btnModal2 = document.getElementById("btnModal2");
    var btnModal3 = document.getElementById("btnModal3");
    var btnModal4 = document.getElementById("btnModal4");
    var btnModal5 = document.getElementById("btnModal5");

    // Get the close buttons
    var closeButtons = document.getElementsByClassName("close");

    // Function to show the modal
    function showModal(modal) {
        modal.style.display = "block";
    }

    // Function to hide the modal
    function hideModal(modal) {
        modal.style.display = "none";
    }

    // Event listeners for button clicks
    btnModal1.addEventListener("click", function() {
        showModal(modal1);
    });

    btnModal2.addEventListener("click", function() {
        showModal(modal2);
    });

    btnModal3.addEventListener("click", function() {
        showModal(modal3);
    });

    btnModal4.addEventListener("click", function() {
        showModal(modal4);
    });
    
    btnModal5.addEventListener("click", function() {
        showModal(modal5);
    });

    // Event listeners for close button clicks
    for (var i = 0; i < closeButtons.length; i++) {
        closeButtons[i].addEventListener("click", function() {
            var modal = this.parentElement.parentElement;
            hideModal(modal);
        });
    }
});