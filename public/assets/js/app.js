var RegisterPage = (function () {

    var settings = {
        //-- form element:
        form: document.getElementById("form"),
        //-- submit button element:
        submit_btn: document.getElementById("submit_btn"),
        //-- password element:
        pass_field: document.getElementById("password"),
        //-- password element:
        pass_confirm_field: document.getElementById("confirm_password"),
        //-- password strong element:
        pass_strong_field: document.getElementById("pass_strong"),
        //-- email element:
        email_field: document.getElementById("email"),
        //-- email confirm element:
        email_confirm_field: document.getElementById("confirm_email"),
        //-- on blur/keyup flag:
        form_validation_status: false
    };

    var init = function () {
        bindUIActions();
    };

    var bindUIActions = function () {

        //---------------------------------------
        //-- add pure js listeners to submit button:
        if (settings.form.addEventListener) {

            //-- for modern browsers:
            settings.submit_btn.addEventListener("click", isValid, false);

        } else if (settings.form.attachEvent) {

            //-- for old f*** IE:
            settings.submit_btn.attachEvent('click', isValid);
        }

        //---------------------------------------
        //-- add pure js listeners to password fields:
        if (settings.form.addEventListener) {

            //-- for modern browsers:
            settings.pass_field.addEventListener("keyup", chkPasswordStrength, false);
            settings.pass_field.addEventListener("blur", VerifyDataIsIdentical, false);
            settings.pass_confirm_field.addEventListener("blur", VerifyDataIsIdentical, false);

        } else if (settings.form.attachEvent) {

            //-- for old IE:
            settings.pass_field.attachEvent('keyup', chkPasswordStrength);
            settings.pass_field.addEventListener("blur", VerifyDataIsIdentical, false);
            settings.pass_confirm_field.addEventListener("blur", VerifyDataIsIdentical, false);
        }

        //---------------------------------------
        //-- add pure js listeners to email fields:
        if (settings.form.addEventListener) {

            //-- for modern browsers:
            settings.email_field.addEventListener("blur", VerifyDataIsIdentical, false);
            settings.email_confirm_field.addEventListener("blur", VerifyDataIsIdentical, false);

        } else if (settings.form.attachEvent) {

            //-- for old IE:
            settings.email_field.attachEvent('blur', VerifyDataIsIdentical);
            settings.email_confirm_field.addEventListener("blur", VerifyDataIsIdentical, false);
        }
    };

    /* client side validations */
    var isValid = function () {

        var is_valid = true;

        //-- check live form validations:
        if (settings.form_validation_status === false) {
            is_valid = false;
        }

        //-- check email address:

        removeValidationMsg("confirm_email");
        var a = document.forms["form"]["user[email]"].value;
        if (a == null || a == "")
        {
            is_valid = false;
            createValidationMsg("confirm_email", "* Email obrigatório.");

        } else {

            //-- check email structure:

            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(a)) {

                is_valid = false;
                createValidationMsg("password", "* Email inválido.");
            }
        }

        //-- check confirm_email:

        removeValidationMsg("password");
        var b = document.forms["form"]["user[confirm_email]"].value;
        if (b == null || b == "")
        {
            is_valid = false;
            createValidationMsg("password", "* Confirma&ccedil;&atilde;o de email obrigatório.");

        }

        //-- check password and confirm_password:

        removeValidationMsg("first_name");
        var c = document.forms["form"]["user[password]"].value;
        var cc = document.forms["form"]["user[confirm_password]"].value;
        if (c == null || c == "" || cc == null || cc == "")
        {
            is_valid = false;
            createValidationMsg("first_name", "* Campo obrigatório.");

        } else {

            //-- check password length
            if (c.length < 6) {

                is_valid = false;
                createValidationMsg("first_name", "* Mínimo 6 caracteres.");
            }
        }

        //-- check first_name and last_name:

        removeValidationMsg("address");
        var d = document.forms["form"]["user[first_name]"].value;
        var e = document.forms["form"]["user[last_name]"].value;
        if (d == null || d == "" || e == null || e == "")
        {
            is_valid = false;
            createValidationMsg("address", "* Campos obrigatórios.");

        } else {

            //-- check first_name / last_name max length:
            if (d.length > 20 || e.length > 20) {

                is_valid = false;
                createValidationMsg("address", "* Máximo 20 caracteres por campo.");
            }

        }

        //-- check address:

        removeValidationMsg("zipcode");
        var e = document.forms["form"]["user[address]"].value;
        if (e != null && e != "")
        {
            //-- check address length
            if (e.length > 80) {

                is_valid = false;
                createValidationMsg("zipcode", "* Máximo 80 caracteres.");
            }

        }

        //-- check zipcode:

        removeValidationMsg("country");
        var f = document.forms["form"]["user[zipcode]"].value;
        if (f != null && f != "")
        {
            //-- check zipcode structure:
            var re = /^\d{4}(-\d{3})?$/;
            if (!re.test(f)) {

                is_valid = false;
                createValidationMsg("country", "* Formato C.Postal inválido.");
            }

        }

        //-- check vat:

        removeValidationMsg("vat");
        var g = document.forms["form"]["user[vat]"].value;
        if (g != null && g != "")
        {
            //-- check vat structure:
            var re = /^[0-9]{9}$/;
            if (!re.test(g)) {

                is_valid = false;
                createValidationMsg("phone", "* Formato inválido.");
            }

        }

        removeValidationMsg("submit_btn");
        var h = document.forms["form"]["user[phone]"].value;
        if (h != null && h != "")
        {
            //-- check country
            var country = document.forms["form"]["user[country]"].value;

            //-- check if is Portugal.
            if (country === "PT") {

                //-- case Portugal, allow only nine digits
                var re = /^[0-9]{9}$/;
                if (!re.test(h)) {

                    is_valid = false;
                    createValidationMsg("submit_btn", "* N. Telefone inv&aacute;lido. M&aacute;ximo 9 digitos sem espa&ccedil;os.");
                }

            }

        }

        //-- if all ok, submit form:
        if (is_valid === true) {
            doSubmit();
        } else {
            return false;
        }
    };

    var doSubmit = function () {
        settings.form.submit();
    };

    var chkPasswordStrength = function ()
    {
        var txtpass = this.value;

        var desc = new Array();
        desc[0] = "Muito insegura";
        desc[1] = "Insegura";
        desc[2] = "Pouco segura";
        desc[3] = "Normal";
        desc[4] = "Segura";
        desc[5] = "Muito segura";

        var score = 0;

        //if txtpass bigger than 6 give 1 point
        if (txtpass.length >= 6)
            score++;

        //if txtpass has both lower and uppercase characters give 1 point
        if ((txtpass.match(/[a-z]/)) && (txtpass.match(/[A-Z]/)))
            score++;

        //if txtpass has at least one number give 1 point
        if (txtpass.match(/\d+/))
            score++;

        //if txtpass has at least one special caracther give 1 point
        if (txtpass.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))
            score++;

        //if txtpass bigger than 12 give another 1 point
        if (txtpass.length >= 10)
            score++;

        settings.pass_strong_field.value = desc[score];
        settings.pass_strong_field.className = "strength" + score;

        if (txtpass.length == 0)
        {
            settings.pass_strong_field.value = "";
            settings.pass_strong_field.className = "form_span";
        }
    };

    var VerifyDataIsIdentical = function () {

        var d1pastval = new String();
        var d2pastval = new String();

        var d1val, d2val, error_area;

        switch (this.id) {
            case "email":
                d1val = getElemValueById(this.id);
                d2val = getElemValueById("confirm_email");
                error_area = "password";
                break;
            case "confirm_email":
                d1val = getElemValueById(this.id);
                d2val = getElemValueById("email");
                error_area = "password";
                break;
            case "password":
                d1val = getElemValueById(this.id);
                d2val = getElemValueById("confirm_password");
                error_area = "first_name";
                break;
            case "confirm_password":
                d1val = getElemValueById(this.id);
                d2val = getElemValueById("password");
                error_area = "first_name";
                break;
        }

        //-- remove (if exists) current validation messages:
        removeValidationMsg(error_area);

        if (d1val.length && d2val.length && (d1val != d2val)
                && ((d1val != d1pastval) || (d2val != d2pastval))) {

            //-- grab an element:
            var elem = document.getElementById(error_area).parentNode,
                    //-- make a new div:
                    new_elem = document.createElement('div');

            new_elem.setAttribute("class", "form_validation_msg");

            //-- create message: 
            new_elem.innerHTML = '<span class="' + error_area + '">* Dados não correspondem.</span>';

            //-- jug it into the parent element:
            elem.insertBefore(new_elem, elem.firstChild);

            settings.form_validation_status = false;

            return false;
        }

        settings.form_validation_status = true;

        return true;
    };

    var getElemValueById = function (id) {
        return document.getElementById(id).value;
    };

    var removeValidationMsg = function (class_name) {

        //-- get all elements with the same class name
        var elements = document.getElementsByClassName(class_name);

        //-- remove all:
        while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
        }

    };

    var createValidationMsg = function (id, msg) {

        var elem = document.getElementById(id).parentNode,
                new_elem = document.createElement('div');

        new_elem.setAttribute("class", "form_validation_msg");
        new_elem.innerHTML = '<span class="confirm_email">' + msg + '</span>';

        elem.insertBefore(new_elem, elem.firstChild);
    };

    return {
        init: init
    };

})();

