
class Field {
    constructor(name, formElement, required, length) {
        this.name = name
        this.required = required
        this.length = length
        this.htmlElement = formElement.querySelector(`input[name="${this.name}"]`)
    }
}

export default Field