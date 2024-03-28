import AirDatepicker from "../../../air-datepicker.min"
import "../../../../../css/packages/air-datepicker.min.css"
import { createPopper } from "../../../popper.min"
import localeEn from "../../../air-datepicker/en"

let searchBar
let arrivalDateInput
let arrivalDay
let datePickerInstance
let bookingType = 1
const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
const allowedCheckinDays = ['Friday', 'Saturday', 'Monday']

function watchBookingTypeForChange() {
    const bookingTypeField = searchBar.querySelector("#select-booking_type");
    if (bookingTypeField) {
        bookingTypeField.addEventListener("change", (event) => {
            bookingType = event.target.value
            regenerateDatePicker()
            if (bookingType == 1) {
                updateArrivalDateAccommodation()
                updateNightsSelectorAccommodation()
            }
            else if (bookingType == 0) {
                updateArrivalDateCamping()
                updateNightsSelectorCamping()
            }
        });
    }
}

function updateNightsSelectorAccommodation() {
    const nightsSelector = searchBar.querySelector("#select-no_of_nights");
    const selectedDay = datePickerInstance.selectedDates[0]
    if (!selectedDay) return{

    }
    const selectedDayName = getDayName(datePickerInstance.selectedDates[0])

    let stayLength;
    switch (selectedDayName) {
        case 'Friday':
            stayLength = 3
            break;
        case 'Saturday':
            stayLength = 2
            break;
        case 'Monday':
            stayLength = 4
            break;
    }

    nightsSelector.querySelectorAll("option").forEach(option => {
        option.classList.remove("hidden")
        option.removeAttribute("disabled")
        option.removeAttribute("selected")

        const optionValue = parseInt(option.value)
        
        if ((optionValue !== stayLength) && (optionValue !== 7)) {
            if (optionValue == 3 || optionValue == 2 || optionValue == 4) {
                option.setAttribute("disabled", "")
            }
            else {
                option.classList.add("hidden")
            }
        }
        if (optionValue == stayLength) {
            option.setAttribute("selected", "")
        }
    });
}

function updateNightsSelectorCamping() {
    const nightsSelector = searchBar.querySelector("#select-no_of_nights");
    nightsSelector.querySelectorAll("option").forEach(option => {
        option.classList.remove("hidden")
        option.removeAttribute("disabled")
    });
}

function updateArrivalDateAccommodation() {
    initialiseDatePicker(arrivalDateInput)
}

function updateArrivalDateCamping() {
    initialiseDatePicker(arrivalDateInput)
}

function searchBarOnPage() {
    return document.querySelector(".searchBarContainer")
}

window.addEventListener("load", (event) => {
    if (searchBarOnPage()) {
        regenerateDatePicker()
        if (bookingType == 1) {
            updateArrivalDateAccommodation()
            updateNightsSelectorAccommodation()
        }
        else if (bookingType == 0) {
            updateArrivalDateCamping()
            updateNightsSelectorCamping()
        }
        watchBookingTypeForChange()
    }
});

function regenerateDatePicker() {
    searchBar = document.querySelector(".searchBarContainer")
    arrivalDateInput = document.querySelector(".searchBarDateInput")
    arrivalDateInput.replaceWith(arrivalDateInput.cloneNode(false));
    arrivalDateInput = document.querySelector(".searchBarDateInput")
}

function findAltField(inputField) {
    const uniqueInputId = inputField.dataset.uuid
    return document.querySelector("." + uniqueInputId)
}

function getStartDate() {
    const today = new Date()
    let currentDate = today

    if (datePickerInstance) {
        if (datePickerInstance?.selectedDates.length > 0) {
            if (datePickerInstance?.selectedDates[0]) {
                currentDate = datePickerInstance.selectedDates[0]
            }
        }
    }

    let dayName = getDayName(currentDate)
    if (bookingType == 1 && !allowedCheckinDays.includes(dayName)) {
        while (!allowedCheckinDays.includes(dayName)) {
            currentDate.setDate(currentDate.getDate()+1)
            dayName = getDayName(currentDate)
        }
    }

    return currentDate
}

function parseDays(altField) {
    return parseInt(altField.dataset.days_to_add.split("+")[1].split(" ")[0]) ?? 0
}

function initialiseDatePicker(input) {
    const field = input
    const altField = findAltField(input)
    const fieldDateFormat = "dd-MM-yyyy"
    const altFieldDateFormat = altField.dataset.date_format ?? fieldDateFormat
    const startDate = getStartDate(altField)
    const placeholderTextIsEnabled = input.dataset?.enable_placeholder_text;
    const datePickerSettings = {
        container: "#scroll-container",
        locale: localeEn,
        view: "days",
        autoClose: true,
        startDate: startDate,
        altField: altField,
        altFieldDateFormat: altFieldDateFormat,
        dateFormat: fieldDateFormat,
        selectedDates: [startDate],
        showOtherMonths: false,
        position({ $datepicker, $target, $pointer, done }) {
            let popper = createPopper($target, $datepicker, {
                placement: "top",
                modifiers: [
                    {
                        name: "flip",
                        options: {
                            padding: {
                                top: 64,
                            },
                        },
                    },
                    {
                        name: "offset",
                        options: {
                            offset: [0, 20],
                        },
                    },
                    {
                        name: "arrow",
                        options: {
                            element: $pointer,
                        },
                    },
                ],
            })

            return function completeHide() {
                popper.destroy()
                done()
            }
        },

        onRenderCell({ date, cellType }) {
            // Disable all 12th dates in month
            if (cellType === 'day') {
                let dayName = getDayName(date)
                let today = new Date()
                if (bookingType == 1) {
                    if (!allowedCheckinDays.includes(dayName) || date < today) {
                        return {
                            disabled: true,
                            classes: 'disabled-class',
                            attrs: {
                                title: "Can't check-in on " + dayName + "s for Accommodation"
                            }
                        }
                    }
                }
                if (bookingType == 0) {
                    if (date < today) {
                        return {
                            disabled: true,
                            classes: 'disabled-class',
                            attrs: {
                                title: ""
                            }
                        }
                    }
                }
            }
        },
        onSelect({date, formattedDate, datepicker}) {
            if (bookingType == 1) {
                updateNightsSelectorAccommodation()
            }
            if (bookingType == 0) {
                updateNightsSelectorCamping()
            }
        }
    }

    if (placeholderTextIsEnabled === "false") {
        datePickerSettings.selectedDates = [startDate]
    }

    if (AirDatepicker) {
        datePickerInstance = new AirDatepicker(field, datePickerSettings)
    }

    
}

function getDayName(date) {
    return date.toLocaleString('en-us', {weekday:'long'})
}