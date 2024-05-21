class VEAsingle
{

  constructor() {
    this.events();
  }

  events() {
    if (document.body.classList.contains('single-vraag-en-aanbod')) {
        var reactie_knop = document.getElementById("vea_reactie_btn");
        var reactie_form = document.getElementById("new_vea_response");

        if ( reactie_knop ) {
            reactie_knop.addEventListener('click', (ev, e) => { this.showResponseForm(ev) });
        }

        if ( reactie_form ) {
          reactie_form.addEventListener("submit", (ev, e) => { this.validateResponseForm(ev) });
        } 
    }
  }

  showResponseForm(event) {
    event.preventDefault();
    var form = document.querySelector('.vea_respond');
    var btn = event.target;
    
    if ( !form.classList.contains('visible') ) {
      form.classList.add('visible');
      form.style.display = "block";
      btn.disabled = true;
    } 
    
  } 

  valEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }

  valTel(telefoonnummer) {
    var telPattern = /^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;
    return telPattern.test(telefoonnummer);
  }

  trimfield(fieldName) { 
    return fieldName.replace(/^\s+|\s+$/g,''); 
  }

  validateResponseForm(event) {
    // Collect inputs
    var voornaam = document.getElementById("vea_response_vnaam").value;
    var achternaam = document.getElementById("vea_response_anaam").value;
    var organisatie = document.getElementById("vea_response_bedrijf").value;
    var email = document.getElementById("vea_response_email").value;
    var telefoonnummer = document.getElementById("vea_response_telefoonnummer").value;
    var bericht = document.getElementById("vea_response_reactie").value;

    // Collect errors
    var voornaam_error = document.querySelector(".vea_response_vnaam_container .error-notif");
    var achternaam_error = document.querySelector(".vea_response_anaam_container .error-notif");
    var organisatie_error = document.querySelector(".vea_response_bedrijf_container .error-notif");
    var email_error = document.querySelector(".vea_response_email_container .error-notif");
    var phone_error = document.querySelector(".vea_response_telefoonnummer_container .error-notif");
    var bericht_error = document.querySelector(".vea_response_bericht_container .error-notif");

    // Validate inputs
    if (voornaam == "") {
      voornaam_error.innerHTML = "Dit veld is verplicht";
      event.preventDefault();
    } else {
        voornaam_error.innerHTML = "";
    }

    if (achternaam == "") {
        achternaam_error.innerHTML = "Dit veld is verplicht";
        event.preventDefault();
    } else {
        achternaam_error.innerHTML = "";
    }

    if (organisatie == "") {
        organisatie_error.innerHTML = "Dit veld is verplicht";
        event.preventDefault();
    } else {
        organisatie_error.innerHTML = "";
    }

    if ( !this.valEmail(email) || email == "") {
        email_error.innerHTML = "Voer een geldig e-mailadres in";
        event.preventDefault();
    } else {
        email_error.innerHTML = "";
    }

    if ( !this.valTel(telefoonnummer) || telefoonnummer == "" ) {
        phone_error.innerHTML = "Voer een geldig telefoonnummer in";
        event.preventDefault();
    } else {
        phone_error.innerHTML = "";
    }
  
    if ( this.trimfield(bericht) == "") {
      bericht_error.innerHTML = "Dit veld is verplicht";
      event.preventDefault();
    } else {
        bericht_error.innerHTML = "";
    }
  }

}

export default VEAsingle;