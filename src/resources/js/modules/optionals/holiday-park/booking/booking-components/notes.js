import Field from '../field'

class Notes {
    fields = []
    stage = 1

    constructor(form) {
        this.contactForm = form
        this.createFields()
    }

    createFields() {
        this.fields.push(new Field('notes', this.contactForm, false, 250))
    }

    update(currentStage) {
        if (currentStage == this.stage) {
            console.log('updating notes info')
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            console.log('loading notes page')
        }
    }
}

export default Notes