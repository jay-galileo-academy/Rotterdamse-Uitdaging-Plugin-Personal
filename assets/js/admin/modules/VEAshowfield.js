class VEAshowfield
{

  constructor() {
    this.events();
  }

  events() {
    var radioBtns = document.querySelectorAll("#vea_status input[name='vea_status']");

    radioBtns.forEach(element => {
        element.addEventListener('click', this.showField);
    });

  }

  showField() {

    var field = document.getElementById("vea_match_company");
    var radioBtn = document.querySelector("#vea_status input[name='vea_status']:checked");

    if ( field && radioBtn.value == 'match' ) {
        field.parentNode.style.display = "block";
    } else if ( radioBtn.value != 'match' ) {
        field.parentNode.style.display = "none";
    }

  }



}

export default VEAshowfield;