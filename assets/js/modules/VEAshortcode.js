class VEAshortcode
{

    constructor() {
        this.events();
    }

    events() {
        var submitForm = document.getElementById("vea_form");
        
        if (submitForm) {
            document.getElementById("vea_vraag_aanbod").addEventListener('click', (ev, e) => this.showField(ev));
            document.getElementById("vea_form").addEventListener('submit', (ev, e) => this.formValidation(ev));
        }
        
    }

    showField(event) {

        var tegenprestatie = document.getElementById('vea_tegenprestatie');

        if (event.target && event.target.matches("input[type='radio']")) {
            if (event.target.id == 'vraag') {
                tegenprestatie.style.display = "block";
                tegenprestatie.classList.remove("vea-hidden");
            } else {
                tegenprestatie.style.display = "none";
                tegenprestatie.classList.add("vea-hidden");
            }
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

    valFileupload(fileName) {
        var allowed_extensions = ["jpg","png","JPG", "jpeg"];
        var file_extension = fileName.split('.').pop().toLowerCase();

        for(var i = 0; i < allowed_extensions.length; i++)
        {
            if(allowed_extensions[i]==file_extension)
            {
                return true;
            }
        }

        return false;
    }

    trimfield(fieldName) { 
        return fieldName.replace(/^\s+|\s+$/g,''); 
    }

    formValidation(event) {
        // Collect inputs
        var voornaam = document.getElementById("vea_vnaam").value;
        var achternaam = document.getElementById("vea_anaam").value;
        var organisatie = document.getElementById("organisatie").value;
        var email = document.getElementById("email").value;
        var telefoonnummer = document.getElementById("telefoonnummer").value;
        var title = document.getElementById("korte_zin").value;
        var beschrijving = document.getElementById("description").value;
        var tegenprestatie = document.getElementById("tegenprestatie").value;
        var tegenprestatie_container = document.getElementById("vea_tegenprestatie");
        var radioVraagAanbod = document.querySelector("#vea_vraag_aanbod input[name='vraag_aanbod']:checked");
        var radioCategorie = document.querySelector("#vea_categorie_radio input[name='vea_categorie']:checked");

        // Collect error messages
        var voornaam_error = document.querySelector(".vnaam-container .error-notif");
        var achternaam_error = document.querySelector(".anaam-container .error-notif");
        var organisatie_error = document.querySelector(".organisatie-container .error-notif");
        var email_error = document.querySelector(".email-container .error-notif");
        var phone_error = document.querySelector(".phone-container .error-notif");
        var title_error = document.querySelector(".title-container .error-notif");
        var beschrijving_error = document.querySelector(".description-container .error-notif");
        var tegenprestatie_error = document.querySelector("#vea_tegenprestatie .error-notif");
        var radioVraagAanbod_error = document.querySelector("#vea_vraag_aanbod .error-notif");
        var radioCategorie_error = document.querySelector("#vea_categorie_radio .error-notif");

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

        if (title == "") {
            title_error.innerHTML = "Dit veld is verplicht";
            event.preventDefault();
        } else {
            title_error.innerHTML = "";
        }

        if ( this.trimfield(beschrijving) == "") {
            beschrijving_error.innerHTML = "Dit veld is verplicht";
            event.preventDefault();
        } else {
            beschrijving_error.innerHTML = "";
        }

        if ( radioVraagAanbod.value == 'vraag' || radioVraagAanbod.value == 'aanbod' ) {
            radioVraagAanbod_error.innerHTML = "";
        } else if ( radioVraagAanbod == null ) {
            radioVraagAanbod_error.innerHTML = "Selecteer een optie";
            event.preventDefault();
        } else {
            radioVraagAanbod_error.innerHTML = "Selecteer een geldige optie";
            event.preventDefault();
        }

        if ( radioCategorie.value == 'handjes' || radioCategorie.value == 'kennis' || radioCategorie.value == 'diensten' || radioCategorie.value == 'producten' || radioCategorie.value == 'tickets' || radioCategorie.value == 'anders') {
            radioCategorie_error.innerHTML = "";
        } else if ( radioCategorie == null ) {
            radioCategorie_error.innerHTML = "Selecteer een optie";
            event.preventDefault();
        } else {
            radioCategorie_error.innerHTML = "Selecteer een geldige optie";
            event.preventDefault();
        }  
    }
}

export default VEAshortcode;