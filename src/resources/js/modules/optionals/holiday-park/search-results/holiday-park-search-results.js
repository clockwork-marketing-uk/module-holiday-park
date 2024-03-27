

class SearchResultsPage {
    constructor() {
        this.propertyList = document.getElementById('property-list')
        this.loadingSpinner = document.getElementById('results-loading-spinner')
        this.bookingType = document.getElementById('select-booking_type')
        this.noResultsMessage = document.getElementById('no-results-found-message')
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
        this.hideNoResultsMessage()
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
        const isArray = results instanceof Array 
        if (!isArray) {
            results = [results]
        }
        results.forEach(result => {
            gradeCodesAvailable.push(result['@attributes'].grade_code)
        });

        if (results.length == 0) {
            this.showNoResultsMessage()
        }
        
        this.propertyList.querySelectorAll('.accommodation-item').forEach(property => {
            const gradeCode = property.dataset.grade_code
            const accommodationId = property.dataset.accommodation_id
            const propertyIsAvailable = gradeCodesAvailable.includes(gradeCode)
            if (!propertyIsAvailable) {
                property.style.display = "none";
            }
            else {
                property.style.display = null;
                const button = property.querySelector('.booking-button')
                this.addBookingInfoToButton(button, gradeCode, accommodationId)
            }
        });

        this.propertyList.classList.remove('hidden')
    }

    addBookingInfoToButton(button, gradeCode, accommodationId) {
        let href = button.getAttribute("href") 
        const url = new URL(href)
        let formFields = this.getFieldsFromForm()
        formFields.id = accommodationId
        url.search = new URLSearchParams(formFields)
        url.searchParams.set('grade_code', gradeCode)
        button.setAttribute('href', url.toString())
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

    hideNoResultsMessage() {
        this.noResultsMessage.classList.remove('flex')
        this.noResultsMessage.classList.add('hidden')
    }

    showNoResultsMessage() {
        this.noResultsMessage.classList.remove('hidden')
        this.noResultsMessage.classList.add('flex')
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

