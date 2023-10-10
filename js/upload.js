let choix = document.getElementById("choix");
let uploadimage = document.getElementById("uploadimage");
let imglast = document.getElementById("imglast");

uploadimage.addEventListener("click", function() {
    if (choix.files.length > 0) {
        let select = choix.files[0];
        let reader = new FileReader();

        reader.onload = function(e) {
            imglast.src = e.target.result;
            imglast.style.display = "block";
        };

        reader.readAsDataURL(select);
    } else {
        alert("Veuillez sélectionner une image.");
    }
});
