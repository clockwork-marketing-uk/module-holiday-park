

class SearchResultsPage {
    constructor() {
        this.propertyList = document.getElementById('property-list')
        this.loadingSpinner = document.getElementById('results-loading-spinner')
        this.bookingType = document.getElementById('booking-type')
        this.findSearchBarOnPage()
        this.preventFormSubmit()
        this.fetchNewResults()
    }

    findSearchBarOnPage() {
        this.searchResults = document.getElementById('search-results')
        if (this.searchResults) {
            this.availabilitySearchBar = this.searchResults.getElementsByTagName('form')[0]
        }
    }

    preventFormSubmit() {
        if (this.availabilitySearchBar) {
            const formButtons = this.availabilitySearchBar.getElementsByTagName('button')
            if (formButtons) {
                if (formButtons.length > 1) {
                    this.hideSecondarySubmitButtons(formButtons)
                }
                if (formButtons.length > 0) {
                    this.preventButtonSubmit(formButtons[0])
                    formButtons[0].addEventListener("click", (e) => {
                        this.fetchNewResults()
                    });
                }
            }
        }
    }

    hideSecondarySubmitButtons(formButtons) {
        for (let i = 1; i < formButtons.length; i++) {
            formButtons[i].classList.add('hidden')
        }
    }

    preventButtonSubmit(button) {
        button.addEventListener("click", function(event){
            event.preventDefault()
        });
    }

    hidePropertyList() {
        this.propertyList.classList.add('hidden')
    }
    
    showPropertyList() {
        this.propertyList.classList.remove('hidden')
    }

    async fetchNewResults() {
        this.hidePropertyList()
        this.showLoadingSpinner()
        const results = await this.getResultsFromBackend()
        this.hideLoadingSpinner()
        this.showResults(results)
    }

    getFieldsFromForm() {
        let formFields = {};
        const formFieldElements = this.availabilitySearchBar.querySelectorAll('div');
        console.log(formFieldElements)
        if (formFieldElements && formFieldElements?.length > 0) {
            formFieldElements.forEach(field => {
                const input = field.querySelector('input') ?? field.querySelector('select');
                if (input && input.value) {
                    const name = input.getAttribute('name')
                    const value = input.value
                    formFields[name] = value
                }
            });
        }
        if (this.bookingType && this.bookingType?.value) {
            formFields.booking_type = this.bookingType.value
        }
        return formFields
        
    }

    showResults(results) {
        let gradeCodesAvailable = []
        results.forEach(result => {
            gradeCodesAvailable.push(result['@attributes'].grade_code)
        });
        console.log(gradeCodesAvailable)
        
        this.propertyList.querySelectorAll('.accommodation-item').forEach(property => {
            const gradeCode = property.dataset.code
            const propertyIsAvailable = gradeCodesAvailable.includes(gradeCode)
            if (!propertyIsAvailable) {
                console.log(gradeCode)
                property.style.display = "none";
            }
            else {
                property.style.display = null;
                this.addBookingInfoToButton(property.querySelector('.booking-button'), gradeCode)
            }
        });

        this.propertyList.classList.remove('hidden')
    }

    addBookingInfoToButton(button, gradeCode) {
        let href = button.getAttribute("href") 
        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        for (const [key, value] of Object.entries(params)) {
            href = href + `&${key}=${value}`
        }
        href = href + `&grade_code=${gradeCode}`
        if (this.bookingType && this.bookingType?.value) {
            href = href + `&booking_type=${this.bookingType.value}`
        }
        button.setAttribute('href', href)
    }

    hidePropertyList() {
        this.propertyList.classList.add('hidden')
    }

    async getResultsFromBackend() {
        const URL = this.searchResults.dataset.query_route
        const formFields = this.getFieldsFromForm()

        const availability = await axios.post(URL, formFields).then(
          response => {
            return response.data.availability.data.Result ?? []
          },
          error => {},
        )
        return availability
      }

    hideLoadingSpinner() {
        this.loadingSpinner.classList.add('hidden')
    }

    showLoadingSpinner() {
        this.loadingSpinner.classList.remove('hidden')
    }
}

function isSearchResultsPage() {
    return document.getElementById("search-results")
}

window.addEventListener("load", (event) => {
    if (isSearchResultsPage()) {
        new SearchResultsPage()
    }
});

