 let like = document.getElementById("like");
 let liketotal = document.getElementById("liketotal");

 let count = 0;

 like.addEventListener("click", function() {
    
     let randomLike = Math.floor(Math.random() * 1) + 1;

     count += randomLike;
     
     liketotal.textContent = count;
 });





