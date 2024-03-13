
class Field {
    constructor(name, formElement, required, length) {
        this.name = name
        this.required = required
        this.length = length
        this.htmlElement = formElement.querySelector(`input[name="${this.name}"]`)
        this.value = ""
        this.addRequiredAttribute()
        this.addMaxLengthAttribute()
        this.addEventListenerToInput()
    }

    addRequiredAttribute() {
        if (this.htmlElement) {
            this.htmlElement.setAttribute("required", this.required)
        }
    }

    addMaxLengthAttribute() {
        if (this.htmlElement) { 
            this.htmlElement.setAttribute("maxlength", this.length)

        }
    }

    addEventListenerToInput() {
        if (this.htmlElement) {
            this.htmlElement.addEventListener("change", (event) => {
                this.value = event.target.value
                console.log(this.value)
            });
        }
    }
}

export default Field