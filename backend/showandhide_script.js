
function fetchData(limit, element, selector){
    var rowb = document.querySelectorAll("."+selector+".rowb"); // Selects elements with both classes
        if (Boolean(limit)) {
            rowb.forEach(rowb => rowb.classList.remove("hide"));
        } else {
            rowb.forEach(rowb => rowb.classList.add("hide"));
        }

    // Check if element is defined
if (element) {
    // Remove 'hide' class from all links
    console.log(selector);
const links = document.querySelectorAll("."+selector+" .hideshow");
links.forEach(link => link.classList.remove("hide"));
    // add 'hide' class to clicked element
element.classList.add("hide");
}
}