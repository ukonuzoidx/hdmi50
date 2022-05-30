// get the country data from the plugin
var countryData = window.intlTelInputGlobals.getCountryData(),
    input = document.querySelector("#phone"),
    addressDropdown = document.querySelector("#address-country");
errorMsg = document.querySelector("#error-msg");
validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = [
    "Invalid number",
    "Invalid country code",
    "Too short",
    "Too long",
    "Invalid number",
];

// init plugin
var iti = window.intlTelInput(input, {
    initialCountry: "ng",
    hiddenInput: "full_phone",
    utilsScript: "../assets/plugins/intl/js/utils.js",
});

var reset = function () {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

// populate the country dropdown
for (var i = 0; i < countryData.length; i++) {
    var country = countryData[i];
    var optionNode = country.iso2;
    var textNode = document.createTextNode(country.name);
    addressDropdown.appendChild(textNode);
    // alert(country.name);
}

// on blur: validate
input.addEventListener("blur", function () {
    reset();
    if (input.value.trim()) {
        if (iti.isValidNumber()) {
            validMsg.classList.remove("hide");
        } else {
            input.classList.add("error");
            var errorCode = iti.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
        }
    }
});

// on keyup / change flag: reset
input.addEventListener("change", reset);
input.addEventListener("keyup", reset);

// set it's initial value
addressDropdown.value = iti.getSelectedCountryData().name;

// listen to the telephone input for changes
input.addEventListener("countrychange", function (e) {
    addressDropdown.value = iti.getSelectedCountryData().name;
});

// listen to the address dropdown for changes
addressDropdown.addEventListener("change", function () {
    iti.setCountry(this.value);
});
