
class Field {
    constructor(name, formElement, required, length = null, pattern = null) {
        this.name = name
        this.required = required
        this.length = length
        this.formElement = formElement
        this.htmlElement = this.findHtmlElement()
        this.value = ""
        this.pattern = pattern
        this.addRequiredAttribute()
        this.addMaxLengthAttribute()
        this.addPatternAttribute()
        this.addEventListenerToInput()
    }

    addRequiredAttribute() {
        if (this.htmlElement && this.required) {
            this.htmlElement.setAttribute("required", "")
        }
    }

    addPatternAttribute() {
        if (this.htmlElement && this.pattern) {
            this.htmlElement.setAttribute("pattern", this.pattern)
        }
    }

    addMaxLengthAttribute() {
        if (this.htmlElement && this.length) { 
            this.htmlElement.setAttribute("maxlength", this.length)

        }
    }

    addEventListenerToInput() {
        if (this.htmlElement) {
            this.htmlElement.addEventListener("change", (event) => {
                this.value = event.target.value
            });
        }
    }

    findHtmlElement() {
        const select = this.formElement.querySelector(`select[name="${this.name}"]`)
        const input = this.formElement.querySelector(`input[name="${this.name}"]`)
        if (select) {
            return select
        }
        else if (input) {
            return input
        }
        return null
    }
}

export default Field